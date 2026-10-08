<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;
use Psr\Http\Message\UploadedFileInterface;

/**
 * Pembayaran Controller
 *
 * @property \App\Model\Table\PembayaranTable $Pembayaran
 */
class PembayaranController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Pembayaran->find()
            ->contain(['Transaksis']);
        $pembayaran = $this->paginate($query);

        $this->set(compact('pembayaran'));
    }

    /**
     * View method
     *
     * @param string|null $id Pembayaran id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pembayaranEntity = $this->Pembayaran->get($id, contain: ['Transaksis']);
        $this->set(compact('pembayaranEntity'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($transaksiId = null)
    {
        $transaksi = $this->fetchTable('Transaksi')->get($transaksiId);

        $sudahBayar = (float) $this->Pembayaran->find()
            ->where(['transaksi_id' => $transaksiId])
            ->select(['total' => 'SUM(jumlah_bayar)'])
            ->first()->total;
        $sisa = $transaksi->total_harga - $sudahBayar;

        $pembayaran = $this->Pembayaran->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $jumlah = (int)($data['jumlah_bayar'] ?? 0);

            if ($jumlah <= 0 || $jumlah > $sisa) {
                $this->Flash->error('Jumlah harus lebih dari 0 dan tidak melebihi sisa tagihan.');
            } else {
                // Bukti hanya diwajibkan untuk QRIS dan Transfer
                $metode = strtolower((string)($data['metode_pembayaran'] ?? ''));
                $perluBukti = in_array($metode, ['qris', 'transfer'], true);
                $namaBukti = null;
                $galat = null;

                if ($perluBukti) {
                    [$namaBukti, $galat] = $this->simpanBukti($this->request->getData('bukti_file'));
                    if ($namaBukti === null && $galat === null) {
                        $galat = 'Foto bukti wajib diunggah untuk pembayaran QRIS atau Transfer.';
                    }
                }

                if ($galat !== null) {
                    $this->Flash->error($galat);
                } else {
                    unset($data['bukti_file']);
                    $data['transaksi_id'] = (int)$transaksiId;
                    $data['tanggal_pembayaran'] = date('Y-m-d H:i:s');
                    $data['status_pembayaran'] = ($jumlah >= $sisa) ? 'Lunas' : 'DP';

                    $pembayaran = $this->Pembayaran->patchEntity($pembayaran, $data);
                    $pembayaran->bukti_transfer = $namaBukti;

                    if ($this->Pembayaran->save($pembayaran)) {
                        $this->Flash->success('Pembayaran tersimpan.');
                        return $this->redirect(['controller' => 'Transaksi', 'action' => 'view', $transaksiId]);
                    }
                    // Simpan gagal: buang foto yang sudah terlanjur diunggah
                    if ($namaBukti !== null) {
                        @unlink($this->folderBukti() . DS . $namaBukti);
                    }
                    $this->Flash->error('Pembayaran gagal disimpan.');
                }
            }
        }
        $this->set(compact('pembayaran', 'transaksi', 'sudahBayar', 'sisa'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Pembayaran id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pembayaranEntity = $this->Pembayaran->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pembayaranEntity = $this->Pembayaran->patchEntity($pembayaranEntity, $this->request->getData());
            if ($this->Pembayaran->save($pembayaranEntity)) {
                $this->Flash->success(__('The pembayaran has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pembayaran could not be saved. Please, try again.'));
        }
        $transaksis = $this->Pembayaran->Transaksis->find('list', limit: 200)->all();
        $this->set(compact('pembayaranEntity', 'transaksis'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Pembayaran id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pembayaranEntity = $this->Pembayaran->get($id);
        $fileBukti = (string)$pembayaranEntity->bukti_transfer;
        if ($this->Pembayaran->delete($pembayaranEntity)) {
            if ($fileBukti !== '') {
                @unlink($this->folderBukti() . DS . basename($fileBukti));
            }
            $this->Flash->success(__('The pembayaran has been deleted.'));
        } else {
            $this->Flash->error(__('The pembayaran could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Menampilkan foto bukti. Foto disimpan di luar webroot, jadi hanya
     * pengguna yang sudah login (dan lolos petaAkses) yang bisa membukanya.
     */
    public function bukti($id = null)
    {
        $pembayaranEntity = $this->Pembayaran->get($id);
        $nama = basename((string)$pembayaranEntity->bukti_transfer);
        $path = $this->folderBukti() . DS . $nama;
        if ($nama === '' || !is_file($path)) {
            throw new NotFoundException('Bukti tidak ditemukan.');
        }

        return $this->response->withFile($path, ['download' => false]);
    }

    private function folderBukti(): string
    {
        return ROOT . DS . 'storage' . DS . 'bukti';
    }

    /**
     * @return array{0: ?string, 1: ?string} [nama file, pesan galat]
     */
    private function simpanBukti(?UploadedFileInterface $file): array
    {
        if ($file === null || $file->getError() === UPLOAD_ERR_NO_FILE) {
            return [null, null];
        }
        if ($file->getError() !== UPLOAD_ERR_OK) {
            return [null, 'Unggahan foto gagal. Coba lagi.'];
        }
        if ($file->getSize() > 5 * 1024 * 1024) {
            return [null, 'Ukuran foto maksimal 5 MB.'];
        }
        // Cek isi file yang sebenarnya, bukan hanya ekstensinya
        $mime = (new \finfo(FILEINFO_MIME_TYPE))->file($file->getStream()->getMetadata('uri'));
        $ekstensi = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'][$mime] ?? null;
        if ($ekstensi === null) {
            return [null, 'Bukti harus berupa foto JPG, PNG, atau WebP.'];
        }

        $folder = $this->folderBukti();
        if (!is_dir($folder)) {
            mkdir($folder, 0775, true);
        }
        $nama = date('Ymd_His') . '_' . bin2hex(random_bytes(6)) . '.' . $ekstensi;
        $file->moveTo($folder . DS . $nama);

        return [$nama, null];
    }
}