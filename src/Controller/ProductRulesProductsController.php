<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * ProductRulesProducts Controller
 *
 * @property \ProductBackend\Model\Table\ProductRulesProductsTable $ProductRulesProducts
 * @method \ProductBackend\Model\Entity\ProductRulesProduct[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductRulesProductsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ProductRules', 'Products'],
        ];
        $productRulesProducts = $this->paginate($this->ProductRulesProducts);

        $this->set(compact('productRulesProducts'));
    }

    /**
     * View method
     *
     * @param string|null $id Product Rules Product id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $productRulesProduct = $this->ProductRulesProducts->get($id, contain: ['ProductRules', 'Products']);

        $this->set(compact('productRulesProduct'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $productRulesProduct = $this->ProductRulesProducts->newEmptyEntity();
        if ($this->request->is('post')) {
            $productRulesProduct = $this->ProductRulesProducts->patchEntity($productRulesProduct, $this->request->getData());
            if ($this->ProductRulesProducts->save($productRulesProduct)) {
                $this->Flash->success(__('The product rules product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product rules product could not be saved. Please, try again.'));
        }
        $productRules = $this->ProductRulesProducts->ProductRules->find(limit: 200)->all()->toList();
        $products = $this->ProductRulesProducts->Products->find(limit: 200)->all()->toList();
        $this->set(compact('productRulesProduct', 'productRules', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product Rules Product id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productRulesProduct = $this->ProductRulesProducts->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productRulesProduct = $this->ProductRulesProducts->patchEntity($productRulesProduct, $this->request->getData());
            if ($this->ProductRulesProducts->save($productRulesProduct)) {
                $this->Flash->success(__('The product rules product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product rules product could not be saved. Please, try again.'));
        }
        $productRules = $this->ProductRulesProducts->ProductRules->find(limit: 200)->all()->toList();
        $products = $this->ProductRulesProducts->Products->find(limit: 200)->all()->toList();
        $this->set(compact('productRulesProduct', 'productRules', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product Rules Product id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productRulesProduct = $this->ProductRulesProducts->get($id);
        if ($this->ProductRulesProducts->delete($productRulesProduct)) {
            $this->Flash->success(__('The product rules product has been deleted.'));
        } else {
            $this->Flash->error(__('The product rules product could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
