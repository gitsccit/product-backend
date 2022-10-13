<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\TableRegistry;

/**
 * Products Controller
 *
 * @property \ProductBackend\Model\Table\ProductsTable $Products
 * @method \ProductBackend\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductsController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Authentication->addUnauthenticatedActions(['save']);
    }

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
                'Locations',
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
                'IFNULL(ProductPerspectives.url, Products.url) =' => $url,
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

        $layout = $this->request->getSession()->read('store.layout_product');
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
        $this->set(compact(
            'product',
            'productCategories',
            'galleries',
            'manufacturers',
            'productStatuses',
            'shipBoxes',
            'locations',
            'generics',
            'productRules'
        ));
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
        $this->set(compact(
            'product',
            'productCategories',
            'galleries',
            'manufacturers',
            'productStatuses',
            'shipBoxes',
            'locations',
            'generics',
            'productRules'
        ));
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

    public function save($productID, $opportunityKey = null)
    {
        $session = $this->request->getSession();
        $productID = (int)$productID;

        $defaultOpportunityDetail = [
            'opportunity_detail_type_id' => 1,
            'product_id' => $productID,
        ];
        $opportunity = [
            'store_id' => $session->read("opportunities.$opportunityKey.store.id") ?? $session->read('store.id'),
            'opportunity_details' => [$defaultOpportunityDetail],
        ];

        $opportunityKey = $opportunityKey ?? random_string(6);
        if ($opportunities = $session->read('opportunities')) {
            if ($session->check("opportunities.$opportunityKey.current")) {
                $opportunity = $session->read("opportunities.$opportunityKey.current");
            } else {
                $opportunityKey = array_keys($opportunities)[0];
                $opportunity = $opportunities[$opportunityKey]['current'];
            }

            $addingExistingProduct = false;

            foreach ($opportunity['opportunity_details'] as &$opportunityDetail) {
                if ($opportunityDetail['product_id'] === $productID) {
                    $opportunityDetail['quantity'] += 1;
                    $addingExistingProduct = true;
                    break;
                }
            }

            if (!$addingExistingProduct) {
                $opportunity['opportunity_details'][] = $defaultOpportunityDetail;
            }
        }

        $action = isset($opportunity['id']) ? 'commit' : 'prepare';
        $opportunity = Configure::read("Functions.{$action}Opportunity")($opportunity);
        $session->write("opportunities.$opportunityKey.current", $opportunity);

        if (Configure::read('ProductBackend.showCost')) {
            return $this->redirect(['controller' => 'Quotes', 'action' => 'load', 'prefix' => 'Sales', 'plugin' => null, $opportunityKey]);
        }

        return $this->redirect(['controller' => 'Order', 'action' => 'index', 'plugin' => null]);
    }
}
