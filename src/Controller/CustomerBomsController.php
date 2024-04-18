<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * CustomerBoms Controller
 *
 * @property \ProductBackend\Model\Table\CustomerBomsTable $CustomerBoms
 * @method \ProductBackend\Model\Entity\CustomerBom[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CustomerBomsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Customers', 'CustomerCategories', 'Locations', 'Images'],
        ];
        $customerBoms = $this->paginate($this->CustomerBoms);

        $this->set(compact('customerBoms'));
    }

    /**
     * View method
     *
     * @param string|null $id Customer Bom id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $customerBom = $this->CustomerBoms->get($id, contain: ['Customers', 'CustomerCategories', 'Locations', 'Images', 'CustomerBomDetails']);

        $this->set(compact('customerBom'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $customerBom = $this->CustomerBoms->newEmptyEntity();
        if ($this->request->is('post')) {
            $customerBom = $this->CustomerBoms->patchEntity($customerBom, $this->request->getData());
            if ($this->CustomerBoms->save($customerBom)) {
                $this->Flash->success(__('The customer bom has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer bom could not be saved. Please, try again.'));
        }
        $customers = $this->CustomerBoms->Customers->find(limit: 200)->all()->toList();
        $customerCategories = $this->CustomerBoms->CustomerCategories->find(limit: 200)->all()->toList();
        $locations = $this->CustomerBoms->Locations->find(limit: 200)->all()->toList();
        $images = $this->CustomerBoms->Images->find(limit: 200)->all()->toList();
        $this->set(compact('customerBom', 'customers', 'customerCategories', 'locations', 'images'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Customer Bom id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $customerBom = $this->CustomerBoms->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customerBom = $this->CustomerBoms->patchEntity($customerBom, $this->request->getData());
            if ($this->CustomerBoms->save($customerBom)) {
                $this->Flash->success(__('The customer bom has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer bom could not be saved. Please, try again.'));
        }
        $customers = $this->CustomerBoms->Customers->find(limit: 200)->all()->toList();
        $customerCategories = $this->CustomerBoms->CustomerCategories->find(limit: 200)->all()->toList();
        $locations = $this->CustomerBoms->Locations->find(limit: 200)->all()->toList();
        $images = $this->CustomerBoms->Images->find(limit: 200)->all()->toList();
        $this->set(compact('customerBom', 'customers', 'customerCategories', 'locations', 'images'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer Bom id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $customerBom = $this->CustomerBoms->get($id);
        if ($this->CustomerBoms->delete($customerBom)) {
            $this->Flash->success(__('The customer bom has been deleted.'));
        } else {
            $this->Flash->error(__('The customer bom could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
