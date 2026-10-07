<?php
declare(strict_types=1);

namespace App\Controller;

class DashboardController extends AppController
{
    public function index()
    {
        $transaksi = $this->fetchTable('Transaksi');
        $pembayaran = $this->fetchTable('Pembayaran');

        $awal = date('Y-m-d 00:00:00');
        $akhir = date('Y-m-d 23:59:59');

        $stat = [
            'total' => $transaksi->find()->count(),
            'hariIni' => $transaksi->find()
                ->where(['tanggal_masuk >=' => $awal, 'tanggal_masuk <=' => $akhir])
                ->count(),
            'menunggu' => $transaksi->find()->where(['status_laundry' => 'Diterima'])->count(),
            'diproses' => $transaksi->find()
                ->where(['status_laundry IN' => ['Diterima', 'Dicuci/Disetrika']])
                ->count(),
            'siap' => $transaksi->find()->where(['status_laundry' => 'Siap Diambil'])->count(),
            'pendapatan' => (float)$pembayaran->find()
                ->where(['tanggal_pembayaran >=' => $awal, 'tanggal_pembayaran <=' => $akhir])
                ->select(['total' => 'SUM(jumlah_bayar)'])
                ->first()->total,
            'belumLunas' => $transaksi->find()
                ->contain(['Pembayaran'])
                ->all()
                ->filter(fn ($t) => $t->kekurangan > 0)
                ->count(),
        ];

        $terakhir = $transaksi->find()
            ->contain(['Pelanggan', 'Layanan'])
            ->orderBy(['Transaksi.id' => 'DESC'])
            ->limit(5)
            ->all();

        $identity = $this->request->getAttribute('identity');
        $nama = $identity ? (string)$identity->get('nama') : '';

        $jam = (int)date('G');
        $sapaan = $jam < 11 ? 'Selamat pagi' : ($jam < 15 ? 'Selamat siang' : ($jam < 18 ? 'Selamat sore' : 'Selamat malam'));

        $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $bulan = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $tanggal = $hari[(int)date('w')] . ', ' . date('j') . ' ' . $bulan[(int)date('n')] . ' ' . date('Y');

        $this->set(compact('stat', 'terakhir', 'nama', 'sapaan', 'tanggal'));
    }
}
