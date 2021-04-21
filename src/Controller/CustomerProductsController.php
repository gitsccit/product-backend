<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * CustomerProducts Controller
 *
 * @property \ProductBackend\Model\Table\CustomerProductsTable $CustomerProducts
 * @method \ProductBackend\Model\Entity\CustomerProduct[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CustomerProductsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Customers', 'CustomerCategories', 'Products'],
        ];
        $customerProducts = $this->paginate($this->CustomerProducts);

        $this->set(compact('customerProducts'));
    }

    /**
     * View method
     *
     * @param string|null $id Customer Product id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $customerProduct = $this->CustomerProducts->get($id, [
            'contain' => ['Customers', 'CustomerCategories', 'Products'],
        ]);

        $this->set(compact('customerProduct'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $customerProduct = $this->CustomerProducts->newEmptyEntity();
        if ($this->request->is('post')) {
            $customerProduct = $this->CustomerProducts->patchEntity($customerProduct, $this->request->getData());
            if ($this->CustomerProducts->save($customerProduct)) {
                $this->Flash->success(__('The customer product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer product could not be saved. Please, try again.'));
        }
        $customers = $this->CustomerProducts->Customers->find('list', ['limit' => 200]);
        $customerCategories = $this->CustomerProducts->CustomerCategories->find('list', ['limit' => 200]);
        $products = $this->CustomerProducts->Products->find('list', ['limit' => 200]);
        $this->set(compact('customerProduct', 'customers', 'customerCategories', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Customer Product id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $customerProduct = $this->CustomerProducts->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customerProduct = $this->CustomerProducts->patchEntity($customerProduct, $this->request->getData());
            if ($this->CustomerProducts->save($customerProduct)) {
                $this->Flash->success(__('The customer product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer product could not be saved. Please, try again.'));
        }
        $customers = $this->CustomerProducts->Customers->find('list', ['limit' => 200]);
        $customerCategories = $this->CustomerProducts->CustomerCategories->find('list', ['limit' => 200]);
        $products = $this->CustomerProducts->Products->find('list', ['limit' => 200]);
        $this->set(compact('customerProduct', 'customers', 'customerCategories', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer Product id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $customerProduct = $this->CustomerProducts->get($id);
        if ($this->CustomerProducts->delete($customerProduct)) {
            $this->Flash->success(__('The customer product has been deleted.'));
        } else {
            $this->Flash->error(__('The customer product could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
