<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * ProductStatuses Controller
 *
 * @property \ProductBackend\Model\Table\ProductStatusesTable $ProductStatuses
 * @method \ProductBackend\Model\Entity\ProductStatus[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductStatusesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $productStatuses = $this->paginate($this->ProductStatuses);

        $this->set(compact('productStatuses'));
    }

    /**
     * View method
     *
     * @param string|null $id Product Status id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $productStatus = $this->ProductStatuses->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('productStatus'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $productStatus = $this->ProductStatuses->newEmptyEntity();
        if ($this->request->is('post')) {
            $productStatus = $this->ProductStatuses->patchEntity($productStatus, $this->request->getData());
            if ($this->ProductStatuses->save($productStatus)) {
                $this->Flash->success(__('The product status has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product status could not be saved. Please, try again.'));
        }
        $this->set(compact('productStatus'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product Status id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productStatus = $this->ProductStatuses->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productStatus = $this->ProductStatuses->patchEntity($productStatus, $this->request->getData());
            if ($this->ProductStatuses->save($productStatus)) {
                $this->Flash->success(__('The product status has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product status could not be saved. Please, try again.'));
        }
        $this->set(compact('productStatus'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product Status id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productStatus = $this->ProductStatuses->get($id);
        if ($this->ProductStatuses->delete($productStatus)) {
            $this->Flash->success(__('The product status has been deleted.'));
        } else {
            $this->Flash->error(__('The product status could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
