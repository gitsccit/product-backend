<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * CustomerBomDetailAdditionalSkus Controller
 *
 * @property \ProductBackend\Model\Table\CustomerBomDetailAdditionalSkusTable $CustomerBomDetailAdditionalSkus
 * @method \ProductBackend\Model\Entity\CustomerBomDetailAdditionalSkus[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CustomerBomDetailAdditionalSkusController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['CustomerBomDetails'],
        ];
        $customerBomDetailAdditionalSkus = $this->paginate($this->CustomerBomDetailAdditionalSkus);

        $this->set(compact('customerBomDetailAdditionalSkus'));
    }

    /**
     * View method
     *
     * @param string|null $id Customer Bom Detail Additional Skus id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $customerBomDetailAdditionalSkus = $this->CustomerBomDetailAdditionalSkus->get($id, contain: ['CustomerBomDetails']);

        $this->set(compact('customerBomDetailAdditionalSkus'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $customerBomDetailAdditionalSkus = $this->CustomerBomDetailAdditionalSkus->newEmptyEntity();
        if ($this->request->is('post')) {
            $customerBomDetailAdditionalSkus = $this->CustomerBomDetailAdditionalSkus->patchEntity($customerBomDetailAdditionalSkus, $this->request->getData());
            if ($this->CustomerBomDetailAdditionalSkus->save($customerBomDetailAdditionalSkus)) {
                $this->Flash->success(__('The customer bom detail additional skus has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer bom detail additional skus could not be saved. Please, try again.'));
        }
        $customerBomDetails = $this->CustomerBomDetailAdditionalSkus->CustomerBomDetails->find('list', ['limit' => 200]);
        $this->set(compact('customerBomDetailAdditionalSkus', 'customerBomDetails'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Customer Bom Detail Additional Skus id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $customerBomDetailAdditionalSkus = $this->CustomerBomDetailAdditionalSkus->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customerBomDetailAdditionalSkus = $this->CustomerBomDetailAdditionalSkus->patchEntity($customerBomDetailAdditionalSkus, $this->request->getData());
            if ($this->CustomerBomDetailAdditionalSkus->save($customerBomDetailAdditionalSkus)) {
                $this->Flash->success(__('The customer bom detail additional skus has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer bom detail additional skus could not be saved. Please, try again.'));
        }
        $customerBomDetails = $this->CustomerBomDetailAdditionalSkus->CustomerBomDetails->find('list', ['limit' => 200]);
        $this->set(compact('customerBomDetailAdditionalSkus', 'customerBomDetails'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer Bom Detail Additional Skus id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $customerBomDetailAdditionalSkus = $this->CustomerBomDetailAdditionalSkus->get($id);
        if ($this->CustomerBomDetailAdditionalSkus->delete($customerBomDetailAdditionalSkus)) {
            $this->Flash->success(__('The customer bom detail additional skus has been deleted.'));
        } else {
            $this->Flash->error(__('The customer bom detail additional skus could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
