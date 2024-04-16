<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * ProductCategoryPerspectives Controller
 *
 * @property \ProductBackend\Model\Table\ProductCategoryPerspectivesTable $ProductCategoryPerspectives
 * @method \ProductBackend\Model\Entity\ProductCategoryPerspective[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductCategoryPerspectivesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Perspectives', 'ProductCategories'],
        ];
        $productCategoryPerspectives = $this->paginate($this->ProductCategoryPerspectives);

        $this->set(compact('productCategoryPerspectives'));
    }

    /**
     * View method
     *
     * @param string|null $id Product Category Perspective id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $productCategoryPerspective = $this->ProductCategoryPerspectives->get($id, contain: ['Perspectives', 'ProductCategories']);

        $this->set(compact('productCategoryPerspective'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $productCategoryPerspective = $this->ProductCategoryPerspectives->newEmptyEntity();
        if ($this->request->is('post')) {
            $productCategoryPerspective = $this->ProductCategoryPerspectives->patchEntity($productCategoryPerspective, $this->request->getData());
            if ($this->ProductCategoryPerspectives->save($productCategoryPerspective)) {
                $this->Flash->success(__('The product category perspective has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product category perspective could not be saved. Please, try again.'));
        }
        $perspectives = $this->ProductCategoryPerspectives->Perspectives->find('list', ['limit' => 200]);
        $productCategories = $this->ProductCategoryPerspectives->ProductCategories->find('list', ['limit' => 200]);
        $this->set(compact('productCategoryPerspective', 'perspectives', 'productCategories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product Category Perspective id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productCategoryPerspective = $this->ProductCategoryPerspectives->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productCategoryPerspective = $this->ProductCategoryPerspectives->patchEntity($productCategoryPerspective, $this->request->getData());
            if ($this->ProductCategoryPerspectives->save($productCategoryPerspective)) {
                $this->Flash->success(__('The product category perspective has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product category perspective could not be saved. Please, try again.'));
        }
        $perspectives = $this->ProductCategoryPerspectives->Perspectives->find('list', ['limit' => 200]);
        $productCategories = $this->ProductCategoryPerspectives->ProductCategories->find('list', ['limit' => 200]);
        $this->set(compact('productCategoryPerspective', 'perspectives', 'productCategories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product Category Perspective id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productCategoryPerspective = $this->ProductCategoryPerspectives->get($id);
        if ($this->ProductCategoryPerspectives->delete($productCategoryPerspective)) {
            $this->Flash->success(__('The product category perspective has been deleted.'));
        } else {
            $this->Flash->error(__('The product category perspective could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
