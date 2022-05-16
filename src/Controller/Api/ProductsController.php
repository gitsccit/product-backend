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
