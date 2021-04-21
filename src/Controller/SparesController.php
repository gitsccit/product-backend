<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * Spares Controller
 *
 * @property \ProductBackend\Model\Table\SparesTable $Spares
 * @method \ProductBackend\Model\Entity\Spare[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SparesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Products', 'SpareCategories'],
        ];
        $spares = $this->paginate($this->Spares);

        $this->set(compact('spares'));
    }

    /**
     * View method
     *
     * @param string|null $id Spare id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $spare = $this->Spares->get($id, [
            'contain' => ['Products', 'SpareCategories'],
        ]);

        $this->set(compact('spare'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $spare = $this->Spares->newEmptyEntity();
        if ($this->request->is('post')) {
            $spare = $this->Spares->patchEntity($spare, $this->request->getData());
            if ($this->Spares->save($spare)) {
                $this->Flash->success(__('The spare has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The spare could not be saved. Please, try again.'));
        }
        $products = $this->Spares->Products->find('list', ['limit' => 200]);
        $spareCategories = $this->Spares->SpareCategories->find('list', ['limit' => 200]);
        $this->set(compact('spare', 'products', 'spareCategories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Spare id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $spare = $this->Spares->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $spare = $this->Spares->patchEntity($spare, $this->request->getData());
            if ($this->Spares->save($spare)) {
                $this->Flash->success(__('The spare has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The spare could not be saved. Please, try again.'));
        }
        $products = $this->Spares->Products->find('list', ['limit' => 200]);
        $spareCategories = $this->Spares->SpareCategories->find('list', ['limit' => 200]);
        $this->set(compact('spare', 'products', 'spareCategories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Spare id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $spare = $this->Spares->get($id);
        if ($this->Spares->delete($spare)) {
            $this->Flash->success(__('The spare has been deleted.'));
        } else {
            $this->Flash->error(__('The spare could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
