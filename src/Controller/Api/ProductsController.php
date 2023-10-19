<?php
declare(strict_types=1);

namespace ProductBackend\Controller\Api;

use Cake\Http\Exception\NotFoundException;

/**
 * Systems Controller
 *
 * @property \ProductBackend\Model\Table\ProductsTable $Products
 * @method \ProductBackend\Model\Entity\System[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductsController extends AppController
{

    public function index()
    {
        $products = $this->Products->find('listing');

        if ($category = $this->request->getQuery('category', '')) {
            $products = $products->where(['Products.product_category_id' => $category]);
        }

        $products = $this->paginate($products);

        $this->Crud->serialize(compact('products'));
    }

    /**
     * View method
     *
     * @param string|null $id Environment id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($url)
    {
        $product = $this->Products
            ->find('details')
            ->where([
                'Products.url' => $url,
            ])
            ->first();

        $this->Crud->serialize(compact('product'));
    }
}
