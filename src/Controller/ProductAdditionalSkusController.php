<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * ProductAdditionalSkus Controller
 *
 * @property \ProductBackend\Model\Table\ProductAdditionalSkusTable $ProductAdditionalSkus
 * @method \ProductBackend\Model\Entity\ProductAdditionalSkus[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductAdditionalSkusController extends AppController
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
        $productAdditionalSkus = $this->paginate($this->ProductAdditionalSkus);

        $this->set(compact('productAdditionalSkus'));
    }

    /**
     * View method
     *
     * @param string|null $id Product Additional Skus id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $productAdditionalSkus = $this->ProductAdditionalSkus->get($id, contain: ['Products']);

        $this->set(compact('productAdditionalSkus'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $productAdditionalSkus = $this->ProductAdditionalSkus->newEmptyEntity();
        if ($this->request->is('post')) {
            $productAdditionalSkus = $this->ProductAdditionalSkus->patchEntity($productAdditionalSkus, $this->request->getData());
            if ($this->ProductAdditionalSkus->save($productAdditionalSkus)) {
                $this->Flash->success(__('The product additional skus has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product additional skus could not be saved. Please, try again.'));
        }
        $products = $this->ProductAdditionalSkus->Products->find('list', ['limit' => 200]);
        $this->set(compact('productAdditionalSkus', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product Additional Skus id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productAdditionalSkus = $this->ProductAdditionalSkus->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productAdditionalSkus = $this->ProductAdditionalSkus->patchEntity($productAdditionalSkus, $this->request->getData());
            if ($this->ProductAdditionalSkus->save($productAdditionalSkus)) {
                $this->Flash->success(__('The product additional skus has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product additional skus could not be saved. Please, try again.'));
        }
        $products = $this->ProductAdditionalSkus->Products->find('list', ['limit' => 200]);
        $this->set(compact('productAdditionalSkus', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product Additional Skus id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productAdditionalSkus = $this->ProductAdditionalSkus->get($id);
        if ($this->ProductAdditionalSkus->delete($productAdditionalSkus)) {
            $this->Flash->success(__('The product additional skus has been deleted.'));
        } else {
            $this->Flash->error(__('The product additional skus could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
