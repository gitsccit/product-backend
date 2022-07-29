<?php
declare(strict_types=1);

namespace ProductBackend\Controller\Api;

use Cake\Http\Exception\NotFoundException;

/**
 * Systems Controller
 *
 * @property \ProductBackend\Model\Table\ProductCategoriesTable $ProductCategories
 * @method \ProductBackend\Model\Entity\System[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductCategoriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $productCategories = $this->ProductCategories->find('listing')->find('threaded')->all()->toList();

        if ($parentID = $this->request->getAttribute('parent_id')) {
            $findSubCategories = function ($categories) use (&$findSubCategories, $parentID) {
                $matchingCategories = [];

                foreach ($categories as $category) {
                    if ($category->parent_id == $parentID) {
                        $matchingCategories[] = $category;
                    }

                    $matchingCategories = array_merge($matchingCategories, $findSubCategories($category->children));
                }

                return $matchingCategories;
            };

            $productCategories = $findSubCategories($productCategories);
        }

        $this->Crud->serialize(compact('productCategories'));
    }

    /**
     * View method
     *
     * @param string|null $id Environment id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(...$url)
    {
        $productCategories = $this->ProductCategories->find('listing')->find('threaded')->all()->toList();

        foreach ($url as $categoryUrl) {
            $productCategory = array_filter($productCategories, function ($productCategory) use ($categoryUrl) {
                return $productCategory->url === $categoryUrl;
            });
            $productCategory = array_pop($productCategory);

            if (is_null($productCategory)) {
                throw new NotFoundException();
            }

            $productCategories = $productCategory->children;
        }

        $products = $this->ProductCategories->Products->find('listing')
            ->where(['Products.product_category_id' => $productCategory->id]);

        if ($products->count() === 0) {
            $this->request = $this->request->withAttribute('parent_id', $productCategory->id);

            return $this->index();
        }

        $products = $this->paginate($products);

        $this->Crud->serialize(compact('products'));
    }
}
