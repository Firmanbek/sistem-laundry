<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Pelanggan Controller
 *
 * @property \App\Model\Table\PelangganTable $Pelanggan
 */
class PelangganController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
{
    $query = $this->Pelanggan->find();
    $cari = $this->request->getQuery('cari');
    if ($cari) {
        $query->where(['OR' => [
            'nama LIKE' => '%' . $cari . '%',
            'no_hp LIKE' => '%' . $cari . '%',
        ]]);
    }
    $pelanggan = $this->paginate($query);
    $this->set(compact('pelanggan'));
}

    /**
     * View method
     *
     * @param string|null $id Pelanggan id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pelangganEntity = $this->Pelanggan->get($id, contain: ['Transaksi']);
        $this->set(compact('pelangganEntity'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pelangganEntity = $this->Pelanggan->newEmptyEntity();
        if ($this->request->is('post')) {
            $pelangganEntity = $this->Pelanggan->patchEntity($pelangganEntity, $this->request->getData());
            if ($this->Pelanggan->save($pelangganEntity)) {
                $this->Flash->success(__('The pelanggan has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pelanggan could not be saved. Please, try again.'));
        }
        $this->set(compact('pelangganEntity'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Pelanggan id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pelangganEntity = $this->Pelanggan->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pelangganEntity = $this->Pelanggan->patchEntity($pelangganEntity, $this->request->getData());
            if ($this->Pelanggan->save($pelangganEntity)) {
                $this->Flash->success(__('The pelanggan has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pelanggan could not be saved. Please, try again.'));
        }
        $this->set(compact('pelangganEntity'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Pelanggan id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
public function delete($id = null)
{
    $this->request->allowMethod(['post', 'delete']);
    $pelanggan = $this->Pelanggan->get($id);
    try {
        if ($this->Pelanggan->delete($pelanggan)) {
            $this->Flash->success(__('Data pelanggan berhasil dihapus.'));
        } else {
            $this->Flash->error(__('Data pelanggan gagal dihapus. Silakan coba lagi.'));
        }
    } catch (\Cake\Database\Exception\QueryException $e) {
        $this->Flash->error(__('Pelanggan tidak bisa dihapus karena sudah memiliki transaksi.'));
    }

    return $this->redirect(['action' => 'index']);
}
}
