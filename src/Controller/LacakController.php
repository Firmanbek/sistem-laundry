<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Cache\Cache;

/**
 * Lacak Controller
 *
 * Halaman publik (tanpa login) agar pelanggan bisa mengecek status cucian
 * dan sisa pembayaran memakai nomor nota + 4 digit terakhir nomor HP.
 *
 * @property \App\Model\Table\TransaksiTable $Transaksi
 */
class LacakController extends AppController
{
    /**
     * Urutan status laundry, sama dengan alur di TransaksiController::ubahStatus().
     *
     * @var array<string>
     */
    private const ALUR_STATUS = ['Diterima', 'Dicuci/Disetrika', 'Siap Diambil', 'Selesai'];

    /** Batas percobaan gagal per IP sebelum diblokir sementara. */
    private const BATAS_GAGAL = 5;

    /** Lama jendela pembatasan (detik). */
    private const JEDA_DETIK = 900;

    /**
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->Authentication->allowUnauthenticated(['index']);
    }

    /**
     * Form pencarian dan hasil pelacakan.
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->viewBuilder()->setLayout('lacak');
        $this->response = $this->response
            ->withHeader('X-Robots-Tag', 'noindex, nofollow')
            ->withHeader('Cache-Control', 'no-store');

        $hasil = null;
        $pesanError = null;
        $nomorNota = '';

        if ($this->request->is('post')) {
            $nomorNota = strtoupper((string)preg_replace('/\s+/', '', (string)$this->request->getData('nomor_nota')));
            $hp4 = (string)preg_replace('/\D+/', '', (string)$this->request->getData('hp4'));

            if ($this->sedangDibatasi()) {
                $pesanError = 'Terlalu banyak percobaan. Silakan coba lagi dalam beberapa menit.';
            } elseif ($nomorNota === '' || strlen($hp4) !== 4) {
                $pesanError = 'Isi nomor nota dan 4 digit terakhir nomor HP.';
            } else {
                $transaksi = $this->fetchTable('Transaksi')->find()
                    ->contain(['Pelanggan', 'Layanan', 'Pembayaran'])
                    ->where(['Transaksi.nomor_nota' => $nomorNota])
                    ->first();

                $cocok = false;
                if ($transaksi !== null && $transaksi->pelanggan !== null) {
                    $hp = (string)preg_replace('/\D+/', '', (string)$transaksi->pelanggan->no_hp);
                    $cocok = strlen($hp) >= 4 && hash_equals(substr($hp, -4), $hp4);
                }

                if ($cocok) {
                    Cache::delete($this->kunciPembatas());
                    $hasil = $this->susunHasil($transaksi);
                } else {
                    // Pesan sengaja sama untuk "nota tidak ada" dan "HP salah"
                    // supaya orang tidak bisa menebak nomor nota yang valid.
                    $this->catatGagal();
                    $pesanError = 'Nota tidak ditemukan atau 4 digit nomor HP tidak cocok.';
                }
            }
        }

        $outlet = $this->fetchTable('Pengaturan')->find()->first();

        $this->set([
            'hasil' => $hasil,
            'pesanError' => $pesanError,
            'nomorNota' => $nomorNota,
            'outlet' => $outlet,
            'alurStatus' => self::ALUR_STATUS,
        ]);
    }

    /**
     * Mengambil hanya data yang aman ditampilkan ke publik.
     * Nomor HP, alamat, dan nama lengkap pelanggan tidak ikut dikirim ke view.
     *
     * @param \App\Model\Entity\Transaksi $transaksi Transaksi lengkap dengan relasi
     * @return array<string, mixed>
     */
    private function susunHasil($transaksi): array
    {
        $namaLengkap = trim((string)$transaksi->pelanggan->nama);
        $namaDepan = explode(' ', $namaLengkap)[0] ?? '';

        return [
            'nomor_nota' => $transaksi->nomor_nota,
            'nama_depan' => $namaDepan,
            'layanan' => $transaksi->layanan?->nama_layanan,
            'berat' => (float)$transaksi->berat,
            'status' => $transaksi->status_laundry,
            'tanggal_masuk' => $transaksi->tanggal_masuk,
            'tanggal_selesai' => $transaksi->tanggal_selesai,
            'total' => (float)$transaksi->total_harga,
            'dibayar' => $transaksi->total_dibayar,
            'kekurangan' => $transaksi->kekurangan,
        ];
    }

    /**
     * @return string
     */
    private function kunciPembatas(): string
    {
        return 'lacak_gagal_' . md5((string)$this->request->clientIp());
    }

    /**
     * @return bool
     */
    private function sedangDibatasi(): bool
    {
        $data = Cache::read($this->kunciPembatas());

        return is_array($data)
            && $data['jumlah'] >= self::BATAS_GAGAL
            && $data['sampai'] > time();
    }

    /**
     * @return void
     */
    private function catatGagal(): void
    {
        $kunci = $this->kunciPembatas();
        $data = Cache::read($kunci);

        if (!is_array($data) || $data['sampai'] <= time()) {
            $data = ['jumlah' => 0, 'sampai' => time() + self::JEDA_DETIK];
        }
        $data['jumlah']++;

        Cache::write($kunci, $data);
    }
}
