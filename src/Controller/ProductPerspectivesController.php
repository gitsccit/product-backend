<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * ProductPerspectives Controller
 *
 * @property \ProductBackend\Model\Table\ProductPerspectivesTable $ProductPerspectives
 * @method \ProductBackend\Model\Entity\ProductPerspective[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductPerspectivesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Perspectives', 'Products'],
        ];
        $productPerspectives = $this->paginate($this->ProductPerspectives);

        $this->set(compact('productPerspectives'));
    }

    /**
     * View method
     *
     * @param string|null $id Product Perspective id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $productPerspective = $this->ProductPerspectives->get($id, contain: ['Perspectives', 'Products']);

        $this->set(compact('productPerspective'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $productPerspective = $this->ProductPerspectives->newEmptyEntity();
        if ($this->request->is('post')) {
            $productPerspective = $this->ProductPerspectives->patchEntity($productPerspective, $this->request->getData());
            if ($this->ProductPerspectives->save($productPerspective)) {
                $this->Flash->success(__('The product perspective has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product perspective could not be saved. Please, try again.'));
        }
        $perspectives = $this->ProductPerspectives->Perspectives->find('list', ['limit' => 200]);
        $products = $this->ProductPerspectives->Products->find('list', ['limit' => 200]);
        $this->set(compact('productPerspective', 'perspectives', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product Perspective id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productPerspective = $this->ProductPerspectives->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productPerspective = $this->ProductPerspectives->patchEntity($productPerspective, $this->request->getData());
            if ($this->ProductPerspectives->save($productPerspective)) {
                $this->Flash->success(__('The product perspective has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product perspective could not be saved. Please, try again.'));
        }
        $perspectives = $this->ProductPerspectives->Perspectives->find('list', ['limit' => 200]);
        $products = $this->ProductPerspectives->Products->find('list', ['limit' => 200]);
        $this->set(compact('productPerspective', 'perspectives', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product Perspective id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productPerspective = $this->ProductPerspectives->get($id);
        if ($this->ProductPerspectives->delete($productPerspective)) {
            $this->Flash->success(__('The product perspective has been deleted.'));
        } else {
            $this->Flash->error(__('The product perspective could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
