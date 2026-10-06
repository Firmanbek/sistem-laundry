<?php
declare(strict_types=1);

namespace App\Controller;

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
            $data['transaksi_id'] = (int)$transaksiId;
            $data['tanggal_pembayaran'] = date('Y-m-d H:i:s');
            $data['status_pembayaran'] = ($jumlah >= $sisa) ? 'Lunas' : 'DP';

            $pembayaran = $this->Pembayaran->patchEntity($pembayaran, $data);
            if ($this->Pembayaran->save($pembayaran)) {
                $this->Flash->success('Pembayaran tersimpan.');
                return $this->redirect(['controller' => 'Transaksi', 'action' => 'view', $transaksiId]);
            }
            $this->Flash->error('Pembayaran gagal disimpan.');
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
        if ($this->Pembayaran->delete($pembayaranEntity)) {
            $this->Flash->success(__('The pembayaran has been deleted.'));
        } else {
            $this->Flash->error(__('The pembayaran could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
