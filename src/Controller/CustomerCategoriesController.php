<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * CustomerCategories Controller
 *
 * @property \ProductBackend\Model\Table\CustomerCategoriesTable $CustomerCategories
 * @method \ProductBackend\Model\Entity\CustomerCategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CustomerCategoriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ParentCustomerCategories', 'Customers'],
        ];
        $customerCategories = $this->paginate($this->CustomerCategories);

        $this->set(compact('customerCategories'));
    }

    /**
     * View method
     *
     * @param string|null $id Customer Category id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $customerCategory = $this->CustomerCategories->get($id, contain: ['ParentCustomerCategories', 'Customers', 'CustomerBoms', 'ChildCustomerCategories', 'CustomerProducts']);

        $this->set(compact('customerCategory'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $customerCategory = $this->CustomerCategories->newEmptyEntity();
        if ($this->request->is('post')) {
            $customerCategory = $this->CustomerCategories->patchEntity($customerCategory, $this->request->getData());
            if ($this->CustomerCategories->save($customerCategory)) {
                $this->Flash->success(__('The customer category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer category could not be saved. Please, try again.'));
        }
        $parentCustomerCategories = $this->CustomerCategories->ParentCustomerCategories->find('list', ['limit' => 200]);
        $customers = $this->CustomerCategories->Customers->find('list', ['limit' => 200]);
        $this->set(compact('customerCategory', 'parentCustomerCategories', 'customers'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Customer Category id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $customerCategory = $this->CustomerCategories->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customerCategory = $this->CustomerCategories->patchEntity($customerCategory, $this->request->getData());
            if ($this->CustomerCategories->save($customerCategory)) {
                $this->Flash->success(__('The customer category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer category could not be saved. Please, try again.'));
        }
        $parentCustomerCategories = $this->CustomerCategories->ParentCustomerCategories->find('list', ['limit' => 200]);
        $customers = $this->CustomerCategories->Customers->find('list', ['limit' => 200]);
        $this->set(compact('customerCategory', 'parentCustomerCategories', 'customers'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer Category id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $customerCategory = $this->CustomerCategories->get($id);
        if ($this->CustomerCategories->delete($customerCategory)) {
            $this->Flash->success(__('The customer category has been deleted.'));
        } else {
            $this->Flash->error(__('The customer category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
