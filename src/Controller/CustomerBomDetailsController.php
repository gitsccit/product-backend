<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * CustomerBomDetails Controller
 *
 * @property \ProductBackend\Model\Table\CustomerBomDetailsTable $CustomerBomDetails
 * @method \ProductBackend\Model\Entity\CustomerBomDetail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CustomerBomDetailsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['CustomerBoms'],
        ];
        $customerBomDetails = $this->paginate($this->CustomerBomDetails);

        $this->set(compact('customerBomDetails'));
    }

    /**
     * View method
     *
     * @param string|null $id Customer Bom Detail id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $customerBomDetail = $this->CustomerBomDetails->get($id, [
            'contain' => ['CustomerBoms', 'CustomerBomDetailAdditionalSkus'],
        ]);

        $this->set(compact('customerBomDetail'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $customerBomDetail = $this->CustomerBomDetails->newEmptyEntity();
        if ($this->request->is('post')) {
            $customerBomDetail = $this->CustomerBomDetails->patchEntity($customerBomDetail, $this->request->getData());
            if ($this->CustomerBomDetails->save($customerBomDetail)) {
                $this->Flash->success(__('The customer bom detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer bom detail could not be saved. Please, try again.'));
        }
        $customerBoms = $this->CustomerBomDetails->CustomerBoms->find('list', ['limit' => 200]);
        $this->set(compact('customerBomDetail', 'customerBoms'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Customer Bom Detail id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $customerBomDetail = $this->CustomerBomDetails->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customerBomDetail = $this->CustomerBomDetails->patchEntity($customerBomDetail, $this->request->getData());
            if ($this->CustomerBomDetails->save($customerBomDetail)) {
                $this->Flash->success(__('The customer bom detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer bom detail could not be saved. Please, try again.'));
        }
        $customerBoms = $this->CustomerBomDetails->CustomerBoms->find('list', ['limit' => 200]);
        $this->set(compact('customerBomDetail', 'customerBoms'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer Bom Detail id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $customerBomDetail = $this->CustomerBomDetails->get($id);
        if ($this->CustomerBomDetails->delete($customerBomDetail)) {
            $this->Flash->success(__('The customer bom detail has been deleted.'));
        } else {
            $this->Flash->error(__('The customer bom detail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
