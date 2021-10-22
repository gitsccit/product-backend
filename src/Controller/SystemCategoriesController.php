<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

use Cake\Collection\Collection;
use Cake\Http\Exception\NotFoundException;
use Cake\Utility\Hash;

/**
 * SystemCategories Controller
 *
 * @property \ProductBackend\Model\Table\SystemCategoriesTable $SystemCategories
 * @method \ProductBackend\Model\Entity\SystemCategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SystemCategoriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($opportunityKey = null)
    {
        $systemCategories = $this->SystemCategories->find('listing')->find('threaded');

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

            $systemCategories = new Collection($findSubCategories($systemCategories));
        }

        # Add a few systems to the system categories for category preview.
        foreach ($systemCategories as $systemCategory) {
            if ($this->request->getParam('pass')) {
                $systemCategory->loadSystems(1);
            } else {
                foreach ($systemCategory->children as $subCategory) {
                    $subCategory->loadSystems(1);
                }
            }
        }

        $firstChildCategory = $systemCategories->first();

        $firstChildCategoryBreadcrumbs = $firstChildCategory->getBreadcrumbs();
        $breadcrumbs = array_slice($firstChildCategoryBreadcrumbs, 0, count($firstChildCategoryBreadcrumbs) - 1);

        $this->set(compact('systemCategories', 'breadcrumbs', 'opportunityKey'));

        $layout = $this->request->getSession()->read('options.store.layout.system-category-browsing');
        $this->viewBuilder()->setTemplate("index_$layout");
    }

    /**
     * View method
     *
     * @param string|null $url System Category url.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(...$url)
    {
        $systemCategories = $this->SystemCategories->find('listing')->find('threaded')->toList();
        $urlFilters = $url;

        $opportunityKey = array_pop($url);

        if (count($url) <= 1 && $this->request->getSession()->check("opportunities.$opportunityKey")) {
            return $this->index($opportunityKey);
        }

        $url[] = $opportunityKey;

        foreach ($url as $index => $categoryUrl) {
            $systemCategories = array_filter($systemCategories, function ($systemCategory) use ($categoryUrl) {
                return $systemCategory->url === $categoryUrl;
            });

            if (empty($systemCategories)) {
                break;
            }

            $systemCategory = end($systemCategories);
            $systemCategories = $systemCategory->children;
            unset($urlFilters[$index]);
        }

        if (!isset($systemCategory)) {
            throw new NotFoundException();
        }

        $systems = $this->SystemCategories->Systems->find('listing')
            ->where(['Systems.system_category_id' => $systemCategory->id]);

        $filter = json_decode(base64_decode($this->request->getQuery('filter', '')), true) ?? [];
        if ($urlFilters || $filter) {
            $tags = array_merge($urlFilters, Hash::extract($filter, '{*}.{n}'));

            $systems
                ->innerJoin(
                    ['Kits' => 'kits'],
                    [
                        'Kits.id = Systems.kit_id',
                    ]
                );

            foreach ($tags as $index => $value) {
                $systems
                    ->innerJoin(
                        ["KitsTags_$index" => 'kits_tags'],
                        [
                            "KitsTags_$index.kit_id = Kits.id",
                        ]
                    )
                    ->innerJoin(
                        ["Tags_$index" => 'tags'],
                        [
                            "Tags_$index.id = KitsTags_$index.tag_id",
                            "Tags_$index.name LIKE" => "%$value%",
                        ]
                    );
            }
        }

        if ($systems->count() === 0) {
            if ($urlFilters) {
                throw new NotFoundException();
            }

            $this->request = $this->request->withAttribute('parent_id', $systemCategory->id);

            return $this->index();
        }

        $tagCategories = $this->SystemCategories->Systems->Kits->find('filter', [
            'kits' => $systems->extract('kit_id')->toList(),
        ]);

        $systems = $this->paginate($systems);
        $tagCategories = $tagCategories->toList();
        $breadcrumbs = $systemCategory->getBreadcrumbs();
        $filterBreadcrumbs = array_map(function ($filter) {
            return [
                'title' => $filter,
            ];
        }, $urlFilters);
        $breadcrumbs = array_merge($breadcrumbs, $filterBreadcrumbs);

        $this->set(compact('systemCategory', 'systems', 'tagCategories', 'breadcrumbs', 'opportunityKey'));

        $layout = $this->request->getSession()->read('options.store.layout.system-browsing');
        $this->viewBuilder()->setTemplate("view_$layout");
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $systemCategory = $this->SystemCategories->newEmptyEntity();
        if ($this->request->is('post')) {
            $systemCategory = $this->SystemCategories->patchEntity($systemCategory, $this->request->getData());
            if ($this->SystemCategories->save($systemCategory)) {
                $this->Flash->success(__('The system category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The system category could not be saved. Please, try again.'));
        }
        $parentSystemCategories = $this->SystemCategories->ParentSystemCategories->find('list', ['limit' => 200]);
        $banners = $this->SystemCategories->Banners->find('list', ['limit' => 200]);
        $this->set(compact('systemCategory', 'parentSystemCategories', 'banners'));
    }

    /**
     * Edit method
     *
     * @param string|null $id System Category id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $systemCategory = $this->SystemCategories->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $systemCategory = $this->SystemCategories->patchEntity($systemCategory, $this->request->getData());
            if ($this->SystemCategories->save($systemCategory)) {
                $this->Flash->success(__('The system category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The system category could not be saved. Please, try again.'));
        }
        $parentSystemCategories = $this->SystemCategories->ParentSystemCategories->find('list', ['limit' => 200]);
        $banners = $this->SystemCategories->Banners->find('list', ['limit' => 200]);
        $this->set(compact('systemCategory', 'parentSystemCategories', 'banners'));
    }

    /**
     * Delete method
     *
     * @param string|null $id System Category id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $systemCategory = $this->SystemCategories->get($id);
        if ($this->SystemCategories->delete($systemCategory)) {
            $this->Flash->success(__('The system category has been deleted.'));
        } else {
            $this->Flash->error(__('The system category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
