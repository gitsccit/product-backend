<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * ProductPriceLevels Controller
 *
 * @property \ProductBackend\Model\Table\ProductPriceLevelsTable $ProductPriceLevels
 * @method \ProductBackend\Model\Entity\ProductPriceLevel[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductPriceLevelsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['PriceLevels', 'Products'],
        ];
        $productPriceLevels = $this->paginate($this->ProductPriceLevels);

        $this->set(compact('productPriceLevels'));
    }

    /**
     * View method
     *
     * @param string|null $id Product Price Level id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $productPriceLevel = $this->ProductPriceLevels->get($id, contain: ['PriceLevels', 'Products']);

        $this->set(compact('productPriceLevel'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $productPriceLevel = $this->ProductPriceLevels->newEmptyEntity();
        if ($this->request->is('post')) {
            $productPriceLevel = $this->ProductPriceLevels->patchEntity($productPriceLevel, $this->request->getData());
            if ($this->ProductPriceLevels->save($productPriceLevel)) {
                $this->Flash->success(__('The product price level has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product price level could not be saved. Please, try again.'));
        }
        $priceLevels = $this->ProductPriceLevels->PriceLevels->find(limit: 200)->all()->toList();
        $products = $this->ProductPriceLevels->Products->find(limit: 200)->all()->toList();
        $this->set(compact('productPriceLevel', 'priceLevels', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product Price Level id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productPriceLevel = $this->ProductPriceLevels->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productPriceLevel = $this->ProductPriceLevels->patchEntity($productPriceLevel, $this->request->getData());
            if ($this->ProductPriceLevels->save($productPriceLevel)) {
                $this->Flash->success(__('The product price level has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product price level could not be saved. Please, try again.'));
        }
        $priceLevels = $this->ProductPriceLevels->PriceLevels->find(limit: 200)->all()->toList();
        $products = $this->ProductPriceLevels->Products->find(limit: 200)->all()->toList();
        $this->set(compact('productPriceLevel', 'priceLevels', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product Price Level id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productPriceLevel = $this->ProductPriceLevels->get($id);
        if ($this->ProductPriceLevels->delete($productPriceLevel)) {
            $this->Flash->success(__('The product price level has been deleted.'));
        } else {
            $this->Flash->error(__('The product price level could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
