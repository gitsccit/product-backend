<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * ProductsRelations Controller
 *
 * @property \ProductBackend\Model\Table\ProductsRelationsTable $ProductsRelations
 * @method \ProductBackend\Model\Entity\ProductsRelation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductsRelationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Products'],
        ];
        $productsRelations = $this->paginate($this->ProductsRelations);

        $this->set(compact('productsRelations'));
    }

    /**
     * View method
     *
     * @param string|null $id Products Relation id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $productsRelation = $this->ProductsRelations->get($id, contain: ['Products']);

        $this->set(compact('productsRelation'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $productsRelation = $this->ProductsRelations->newEmptyEntity();
        if ($this->request->is('post')) {
            $productsRelation = $this->ProductsRelations->patchEntity($productsRelation, $this->request->getData());
            if ($this->ProductsRelations->save($productsRelation)) {
                $this->Flash->success(__('The products relation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The products relation could not be saved. Please, try again.'));
        }
        $products = $this->ProductsRelations->Products->find('list', ['limit' => 200]);
        $this->set(compact('productsRelation', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Products Relation id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productsRelation = $this->ProductsRelations->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productsRelation = $this->ProductsRelations->patchEntity($productsRelation, $this->request->getData());
            if ($this->ProductsRelations->save($productsRelation)) {
                $this->Flash->success(__('The products relation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The products relation could not be saved. Please, try again.'));
        }
        $products = $this->ProductsRelations->Products->find('list', ['limit' => 200]);
        $this->set(compact('productsRelation', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Products Relation id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productsRelation = $this->ProductsRelations->get($id);
        if ($this->ProductsRelations->delete($productsRelation)) {
            $this->Flash->success(__('The products relation has been deleted.'));
        } else {
            $this->Flash->error(__('The products relation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
