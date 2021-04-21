<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * GenericsProducts Controller
 *
 * @property \ProductBackend\Model\Table\GenericsProductsTable $GenericsProducts
 * @method \ProductBackend\Model\Entity\GenericsProduct[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GenericsProductsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Generics', 'Products'],
        ];
        $genericsProducts = $this->paginate($this->GenericsProducts);

        $this->set(compact('genericsProducts'));
    }

    /**
     * View method
     *
     * @param string|null $id Generics Product id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $genericsProduct = $this->GenericsProducts->get($id, [
            'contain' => ['Generics', 'Products'],
        ]);

        $this->set(compact('genericsProduct'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $genericsProduct = $this->GenericsProducts->newEmptyEntity();
        if ($this->request->is('post')) {
            $genericsProduct = $this->GenericsProducts->patchEntity($genericsProduct, $this->request->getData());
            if ($this->GenericsProducts->save($genericsProduct)) {
                $this->Flash->success(__('The generics product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The generics product could not be saved. Please, try again.'));
        }
        $generics = $this->GenericsProducts->Generics->find('list', ['limit' => 200]);
        $products = $this->GenericsProducts->Products->find('list', ['limit' => 200]);
        $this->set(compact('genericsProduct', 'generics', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Generics Product id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $genericsProduct = $this->GenericsProducts->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $genericsProduct = $this->GenericsProducts->patchEntity($genericsProduct, $this->request->getData());
            if ($this->GenericsProducts->save($genericsProduct)) {
                $this->Flash->success(__('The generics product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The generics product could not be saved. Please, try again.'));
        }
        $generics = $this->GenericsProducts->Generics->find('list', ['limit' => 200]);
        $products = $this->GenericsProducts->Products->find('list', ['limit' => 200]);
        $this->set(compact('genericsProduct', 'generics', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Generics Product id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $genericsProduct = $this->GenericsProducts->get($id);
        if ($this->GenericsProducts->delete($genericsProduct)) {
            $this->Flash->success(__('The generics product has been deleted.'));
        } else {
            $this->Flash->error(__('The generics product could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
