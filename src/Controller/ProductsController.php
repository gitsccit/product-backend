<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

use Cake\Collection\Collection;
use Cake\Http\Exception\NotFoundException;

/**
 * Products Controller
 *
 * @property \ProductBackend\Model\Table\ProductsTable $Products
 * @method \ProductBackend\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => [
                'ProductCategories',
                'Galleries',
                'Manufacturers',
                'ProductStatuses',
                'ShipBoxes',
                'Locations'
            ],
        ];
        $products = $this->paginate($this->Products);

        $this->set(compact('products'));
    }

    /**
     * View method
     *
     * @param string $url Product url
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(string $url)
    {
        $product = $this->Products
            ->find('details')
            ->where([
                'Products.url' => $url,
            ])
            ->first();

        if (is_null($product)) {
            throw new NotFoundException();
        }

        if (!$this->request->is('ajax')) {
            $breadcrumbs = $product->getBreadcrumbs();
            $this->set(compact('breadcrumbs'));
        }

        $this->set(compact('product'));

        $layout = $this->request->getSession()->read('options.store.layout.product');
        $this->viewBuilder()->setTemplate("view_$layout");
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $product = $this->Products->newEmptyEntity();
        if ($this->request->is('post')) {
            $product = $this->Products->patchEntity($product, $this->request->getData());
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }
        $productCategories = $this->Products->ProductCategories->find('list', ['limit' => 200]);
        $galleries = $this->Products->Galleries->find('list', ['limit' => 200]);
        $manufacturers = $this->Products->Manufacturers->find('list', ['limit' => 200]);
        $productStatuses = $this->Products->ProductStatuses->find('list', ['limit' => 200]);
        $shipBoxes = $this->Products->ShipBoxes->find('list', ['limit' => 200]);
        $locations = $this->Products->Locations->find('list', ['limit' => 200]);
        $generics = $this->Products->Generics->find('list', ['limit' => 200]);
        $productRules = $this->Products->ProductRules->find('list', ['limit' => 200]);
        $this->set(compact('product', 'productCategories', 'galleries', 'manufacturers', 'productStatuses', 'shipBoxes',
            'locations', 'generics', 'productRules'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $product = $this->Products->get($id, [
            'contain' => ['Generics', 'ProductRules'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $product = $this->Products->patchEntity($product, $this->request->getData());
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }
        $productCategories = $this->Products->ProductCategories->find('list', ['limit' => 200]);
        $galleries = $this->Products->Galleries->find('list', ['limit' => 200]);
        $manufacturers = $this->Products->Manufacturers->find('list', ['limit' => 200]);
        $productStatuses = $this->Products->ProductStatuses->find('list', ['limit' => 200]);
        $shipBoxes = $this->Products->ShipBoxes->find('list', ['limit' => 200]);
        $locations = $this->Products->Locations->find('list', ['limit' => 200]);
        $generics = $this->Products->Generics->find('list', ['limit' => 200]);
        $productRules = $this->Products->ProductRules->find('list', ['limit' => 200]);
        $this->set(compact('product', 'productCategories', 'galleries', 'manufacturers', 'productStatuses', 'shipBoxes',
            'locations', 'generics', 'productRules'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $product = $this->Products->get($id);
        if ($this->Products->delete($product)) {
            $this->Flash->success(__('The product has been deleted.'));
        } else {
            $this->Flash->error(__('The product could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
