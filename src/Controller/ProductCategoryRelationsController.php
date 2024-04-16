<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * ProductCategoryRelations Controller
 *
 * @property \ProductBackend\Model\Table\ProductCategoryRelationsTable $ProductCategoryRelations
 * @method \ProductBackend\Model\Entity\ProductCategoryRelation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductCategoryRelationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ProductCategories'],
        ];
        $productCategoryRelations = $this->paginate($this->ProductCategoryRelations);

        $this->set(compact('productCategoryRelations'));
    }

    /**
     * View method
     *
     * @param string|null $id Product Category Relation id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $productCategoryRelation = $this->ProductCategoryRelations->get($id, contain: ['ProductCategories']);

        $this->set(compact('productCategoryRelation'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $productCategoryRelation = $this->ProductCategoryRelations->newEmptyEntity();
        if ($this->request->is('post')) {
            $productCategoryRelation = $this->ProductCategoryRelations->patchEntity($productCategoryRelation, $this->request->getData());
            if ($this->ProductCategoryRelations->save($productCategoryRelation)) {
                $this->Flash->success(__('The product category relation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product category relation could not be saved. Please, try again.'));
        }
        $productCategories = $this->ProductCategoryRelations->ProductCategories->find('list', ['limit' => 200]);
        $this->set(compact('productCategoryRelation', 'productCategories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product Category Relation id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productCategoryRelation = $this->ProductCategoryRelations->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productCategoryRelation = $this->ProductCategoryRelations->patchEntity($productCategoryRelation, $this->request->getData());
            if ($this->ProductCategoryRelations->save($productCategoryRelation)) {
                $this->Flash->success(__('The product category relation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product category relation could not be saved. Please, try again.'));
        }
        $productCategories = $this->ProductCategoryRelations->ProductCategories->find('list', ['limit' => 200]);
        $this->set(compact('productCategoryRelation', 'productCategories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product Category Relation id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productCategoryRelation = $this->ProductCategoryRelations->get($id);
        if ($this->ProductCategoryRelations->delete($productCategoryRelation)) {
            $this->Flash->success(__('The product category relation has been deleted.'));
        } else {
            $this->Flash->error(__('The product category relation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
