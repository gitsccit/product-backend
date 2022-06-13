<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use ProductBackend\Model\Entity\ProductCategory;

/**
 * ProductCategories Controller
 *
 * @property \ProductBackend\Model\Table\ProductCategoriesTable $ProductCategories
 * @method \ProductBackend\Model\Entity\ProductCategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductCategoriesController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Authentication->addUnauthenticatedActions(['compare']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $productCategories = $this->ProductCategories->find('listing')->find('threaded');

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

        # Add a few products to the product categories for category preview.
        foreach ($productCategories as $systemCategory) {
            $systemCategory->loadProducts(1);
        }

        $breadcrumbs = ProductCategory::getBreadcrumbBase();

        $this->set(compact('productCategories', 'breadcrumbs'));

        $layout = $this->request->getSession()->read('store.layout_product_category_browsing');
        $this->viewBuilder()->setTemplate("index_$layout");
    }

    /**
     * View method
     *
     * @param string|null $url Product Category name.
     * @return \Cake\Http\Response|null|void Renders view
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

        $specifications = $this->ProductCategories->Products->find('specifications', [
            'productCategoryID' => $productCategory->id,
        ]);

        if ($filter = json_decode(base64_decode($this->request->getQuery('filter', '')), true)) {
            $specs = array_replace(...array_values($filter));

            foreach ($specs as $specificationField => $value) {
                $alias = "{$specificationField}_filter";

                $products->innerJoin(
                    [$alias => 'Specifications'],
                    [
                        "$alias.specification_field_id" => $specificationField,
                        "$alias.product_id = Products.id",
                        "$alias.text_value" => $value,
                    ]
                );
                $specifications->innerJoin(
                    [$alias => 'Specifications'],
                    [
                        "$alias.specification_field_id" => $specificationField,
                        "$alias.product_id = Products.id",
                        "$alias.text_value" => $value,
                    ]
                );
            }
        }

        $products = $this->paginate($products);
        $specifications = $specifications->all()->toList();
        $breadcrumbs = $productCategory->getBreadcrumbs();

        $this->set(compact('productCategory', 'products', 'specifications', 'breadcrumbs'));

        $layout = $this->request->getSession()->read('store.layout_product_browsing');
        $this->viewBuilder()->setTemplate("view_$layout");
    }

    public function compare(...$ids)
    {
        $products = $this->ProductCategories->Products
            ->find('compare')
            ->whereInList('Products.id', $ids)
            ->all()
            ->toList();

        $products = array_combine(Hash::extract($products, '{n}.id'), $products);

        $productsCopy = [];
        foreach ($ids as $index => $id) {
            $productsCopy[$index] = $products[$id];
        }
        $products = $productsCopy;

        if ($bucketID = $this->request->getQuery('bucket')) {
            $bucket = TableRegistry::getTableLocator()->get('ProductBackend.Buckets')->get($bucketID);

            if ($bucket['compare'] === 'no') {
                throw new \Exception('Bucket is not comparable');
            }
            $bucket['multiple'] = $bucket['multiple'] === 'yes';

            $this->set(compact('bucket'));
        }

        $this->set(compact('products'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $productCategory = $this->ProductCategories->newEmptyEntity();
        if ($this->request->is('post')) {
            $productCategory = $this->ProductCategories->patchEntity($productCategory, $this->request->getData());
            if ($this->ProductCategories->save($productCategory)) {
                $this->Flash->success(__('The product category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product category could not be saved. Please, try again.'));
        }
        $parentProductCategories = $this->ProductCategories->ParentProductCategories->find('list', ['limit' => 200]);
        $this->set(compact('productCategory', 'parentProductCategories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product Category id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productCategory = $this->ProductCategories->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productCategory = $this->ProductCategories->patchEntity($productCategory, $this->request->getData());
            if ($this->ProductCategories->save($productCategory)) {
                $this->Flash->success(__('The product category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product category could not be saved. Please, try again.'));
        }
        $parentProductCategories = $this->ProductCategories->ParentProductCategories->find('list', ['limit' => 200]);
        $this->set(compact('productCategory', 'parentProductCategories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product Category id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productCategory = $this->ProductCategories->get($id);
        if ($this->ProductCategories->delete($productCategory)) {
            $this->Flash->success(__('The product category has been deleted.'));
        } else {
            $this->Flash->error(__('The product category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
