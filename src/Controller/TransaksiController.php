<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Transaksi Controller
 *
 * @property \App\Model\Table\TransaksiTable $Transaksi
 */
class TransaksiController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
{
    $query = $this->Transaksi->find()
        ->contain(['Pelanggan', 'Layanan'])
        ->orderBy(['Transaksi.id' => 'DESC']);

    $status = $this->request->getQuery('status');
    if ($status) {
        $query->where(['Transaksi.status_laundry' => $status]);
    }

    $daftarStatus = $this->Transaksi->find()
        ->select(['status_laundry'])
        ->distinct()
        ->all()
        ->extract('status_laundry')
        ->toList();

    $transaksi = $this->paginate($query);
    $this->set(compact('transaksi', 'daftarStatus'));
}

    /**
     * View method
     *
     * @param string|null $id Transaksi id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $transaksiEntity = $this->Transaksi->get($id, contain: ['Pelanggan', 'Layanan', 'Users', 'Pembayaran']);
        $this->set(compact('transaksiEntity'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
{
    $transaksi = $this->Transaksi->newEmptyEntity();
    if ($this->request->is('post')) {
        $data = $this->request->getData();
        $layanan = $this->Transaksi->Layanan->get($data['layanan_id']);
        $berat = (float)($data['berat'] ?? 0);
        $diskon = (int)($data['diskon'] ?? 0);

        if ($berat <= 0) {
            $this->Flash->error(__('Berat harus lebih dari 0.'));
        } else {
            $subtotal = (int)round($berat * (float)$layanan->harga_per_kg); // ganti harga_per_kg jika nama kolomnya beda
            $data['subtotal'] = $subtotal;
            $data['diskon'] = $diskon;
            $data['total_harga'] = max($subtotal - $diskon, 0);
            $data['nomor_nota'] = $this->buatNomorNota();
            $data['user_id'] = $this->request->getAttribute('identity')->getIdentifier();
            $data['status_laundry'] = 'Diterima';
            $data['tanggal_masuk'] = date('Y-m-d H:i:s');

            $transaksi = $this->Transaksi->patchEntity($transaksi, $data);
            if ($this->Transaksi->save($transaksi)) {
                $this->Flash->success(__('Transaksi {0} berhasil disimpan.', $transaksi->nomor_nota));

                return $this->redirect(['action' => 'view', $transaksi->id]);
            }
            $this->Flash->error(__('Transaksi gagal disimpan. Silakan coba lagi.'));
        }
    }
    $daftarPelanggan = $this->Transaksi->Pelanggan->find('list', keyField: 'id', valueField: 'nama')->all();
    $daftarLayanan = $this->Transaksi->Layanan->find('list', keyField: 'id', valueField: 'nama_layanan')->all();
    $this->set(compact('transaksi', 'daftarPelanggan', 'daftarLayanan'));
}

private function buatNomorNota(): string
{
    $terakhir = $this->Transaksi->find()
        ->select(['nomor_nota'])
        ->orderBy(['id' => 'DESC'])
        ->first();
    $angka = 0;
    if ($terakhir && preg_match('/(\d+)$/', (string)$terakhir->nomor_nota, $m)) {
        $angka = (int)$m[1];
    }

    return 'LDR-' . str_pad((string)($angka + 1), 5, '0', STR_PAD_LEFT);
}

    /**
     * Edit method
     *
     * @param string|null $id Transaksi id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $transaksiEntity = $this->Transaksi->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $transaksiEntity = $this->Transaksi->patchEntity($transaksiEntity, $this->request->getData());
            if ($this->Transaksi->save($transaksiEntity)) {
                $this->Flash->success(__('The transaksi has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The transaksi could not be saved. Please, try again.'));
        }
        $pelanggans = $this->Transaksi->Pelanggan->find('list', limit: 200)->all();
        $layanans = $this->Transaksi->Layanan->find('list', limit: 200)->all();
        $users = $this->Transaksi->Users->find('list', limit: 200)->all();
        $this->set(compact('transaksiEntity', 'pelanggans', 'layanans', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Transaksi id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $transaksiEntity = $this->Transaksi->get($id);
        if ($this->Transaksi->delete($transaksiEntity)) {
            $this->Flash->success(__('The transaksi has been deleted.'));
        } else {
            $this->Flash->error(__('The transaksi could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
