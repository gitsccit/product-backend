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
    public function index()
    {
        $systemCategories = $this->SystemCategories->find('listing')->find('threaded')->all();

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

        $firstChildCategory = $systemCategories->first();
        $firstChildCategoryBreadcrumbs = $firstChildCategory->getBreadcrumbs();
        $breadcrumbs = array_slice($firstChildCategoryBreadcrumbs, 0, count($firstChildCategoryBreadcrumbs) - 1);

        $this->set(compact('systemCategories', 'breadcrumbs'));

        $layout = $this->request->getSession()->read('store.layout_system_category_browsing');
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
        $systemCategories = $this->SystemCategories->find('listing')->find('threaded')->all()->toList();
        $urlFilters = $url;

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

        $tagGroups = $this->SystemCategories->Systems->Kits->find('filter',
            kits: $systems->all()->extract('kit_id')->toList(),
        );

        $systems = $this->paginate($systems);
        $tagGroups = $tagGroups->all()->toList();
        $breadcrumbs = $systemCategory->getBreadcrumbs();
        $filterBreadcrumbs = array_map(function ($filter) {
            return [
                'title' => $filter,
            ];
        }, $urlFilters);
        $breadcrumbs = array_merge($breadcrumbs, $filterBreadcrumbs);

        $this->set(compact('systemCategory', 'systems', 'tagGroups', 'breadcrumbs'));

        $layout = $this->request->getSession()->read('store.layout_system_browsing');
        $this->viewBuilder()->setTemplate("view_$layout");
    }
}
