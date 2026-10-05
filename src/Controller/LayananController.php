<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Layanan Controller
 *
 * @property \App\Model\Table\LayananTable $Layanan
 */
class LayananController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Layanan->find();
        $layanan = $this->paginate($query);

        $this->set(compact('layanan'));
    }

    /**
     * View method
     *
     * @param string|null $id Layanan id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $layananEntity = $this->Layanan->get($id, contain: ['Transaksi']);
        $this->set(compact('layananEntity'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $layananEntity = $this->Layanan->newEmptyEntity();
        if ($this->request->is('post')) {
            $layananEntity = $this->Layanan->patchEntity($layananEntity, $this->request->getData());
            if ($this->Layanan->save($layananEntity)) {
                $this->Flash->success(__('The layanan has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The layanan could not be saved. Please, try again.'));
        }
        $this->set(compact('layananEntity'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Layanan id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $layananEntity = $this->Layanan->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $layananEntity = $this->Layanan->patchEntity($layananEntity, $this->request->getData());
            if ($this->Layanan->save($layananEntity)) {
                $this->Flash->success(__('The layanan has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The layanan could not be saved. Please, try again.'));
        }
        $this->set(compact('layananEntity'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Layanan id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $layananEntity = $this->Layanan->get($id);
        if ($this->Layanan->delete($layananEntity)) {
            $this->Flash->success(__('The layanan has been deleted.'));
        } else {
            $this->Flash->error(__('The layanan could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
