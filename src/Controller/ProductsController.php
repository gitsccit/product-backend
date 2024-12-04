<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use ProductBackend\Model\Entity\Product;

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
                'ShipFromLocation',
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
            $breadcrumbs = (new Product($product))->getBreadcrumbs();
            $this->set(compact('breadcrumbs'));
        }

        $this->set(compact('product'));

        $layout = $this->request->getSession()->read('store.layout_product');
        $this->viewBuilder()->setTemplate("view_$layout");
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
