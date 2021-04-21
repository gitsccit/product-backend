<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * CustomerPasswords Controller
 *
 * @property \ProductBackend\Model\Table\CustomerPasswordsTable $CustomerPasswords
 * @method \ProductBackend\Model\Entity\CustomerPassword[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CustomerPasswordsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Customers'],
        ];
        $customerPasswords = $this->paginate($this->CustomerPasswords);

        $this->set(compact('customerPasswords'));
    }

    /**
     * View method
     *
     * @param string|null $id Customer Password id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $customerPassword = $this->CustomerPasswords->get($id, [
            'contain' => ['Customers'],
        ]);

        $this->set(compact('customerPassword'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $customerPassword = $this->CustomerPasswords->newEmptyEntity();
        if ($this->request->is('post')) {
            $customerPassword = $this->CustomerPasswords->patchEntity($customerPassword, $this->request->getData());
            if ($this->CustomerPasswords->save($customerPassword)) {
                $this->Flash->success(__('The customer password has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer password could not be saved. Please, try again.'));
        }
        $customers = $this->CustomerPasswords->Customers->find('list', ['limit' => 200]);
        $this->set(compact('customerPassword', 'customers'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Customer Password id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $customerPassword = $this->CustomerPasswords->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customerPassword = $this->CustomerPasswords->patchEntity($customerPassword, $this->request->getData());
            if ($this->CustomerPasswords->save($customerPassword)) {
                $this->Flash->success(__('The customer password has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer password could not be saved. Please, try again.'));
        }
        $customers = $this->CustomerPasswords->Customers->find('list', ['limit' => 200]);
        $this->set(compact('customerPassword', 'customers'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer Password id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $customerPassword = $this->CustomerPasswords->get($id);
        if ($this->CustomerPasswords->delete($customerPassword)) {
            $this->Flash->success(__('The customer password has been deleted.'));
        } else {
            $this->Flash->error(__('The customer password could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
