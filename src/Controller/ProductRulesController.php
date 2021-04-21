<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * ProductRules Controller
 *
 * @property \ProductBackend\Model\Table\ProductRulesTable $ProductRules
 * @method \ProductBackend\Model\Entity\ProductRule[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductRulesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $productRules = $this->paginate($this->ProductRules);

        $this->set(compact('productRules'));
    }

    /**
     * View method
     *
     * @param string|null $id Product Rule id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $productRule = $this->ProductRules->get($id, [
            'contain' => ['Products'],
        ]);

        $this->set(compact('productRule'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $productRule = $this->ProductRules->newEmptyEntity();
        if ($this->request->is('post')) {
            $productRule = $this->ProductRules->patchEntity($productRule, $this->request->getData());
            if ($this->ProductRules->save($productRule)) {
                $this->Flash->success(__('The product rule has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product rule could not be saved. Please, try again.'));
        }
        $products = $this->ProductRules->Products->find('list', ['limit' => 200]);
        $this->set(compact('productRule', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product Rule id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productRule = $this->ProductRules->get($id, [
            'contain' => ['Products'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productRule = $this->ProductRules->patchEntity($productRule, $this->request->getData());
            if ($this->ProductRules->save($productRule)) {
                $this->Flash->success(__('The product rule has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product rule could not be saved. Please, try again.'));
        }
        $products = $this->ProductRules->Products->find('list', ['limit' => 200]);
        $this->set(compact('productRule', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product Rule id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productRule = $this->ProductRules->get($id);
        if ($this->ProductRules->delete($productRule)) {
            $this->Flash->success(__('The product rule has been deleted.'));
        } else {
            $this->Flash->error(__('The product rule could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
