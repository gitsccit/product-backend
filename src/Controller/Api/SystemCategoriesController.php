<?php
declare(strict_types=1);

namespace ProductBackend\Controller\Api;

use Cake\Collection\Collection;
use Cake\Http\Exception\NotFoundException;

/**
 * Systems Controller
 *
 * @property \ProductBackend\Model\Table\SystemCategoriesTable $SystemCategories
 * @method \ProductBackend\Model\Entity\System[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
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
        $systemCategories = $this->SystemCategories->find('listing')->find('threaded')->all()->toList();

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

        $this->Crud->serialize(compact('systemCategories'));
    }

    /**
     * View method
     *
     * @param string|null $id Environment id.
     * @return \Cake\Http\Response|null
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
            $systems = null;
            $this->Crud->serialize(compact('systems'));

            return;
        }

        $systems = $this->SystemCategories->Systems->find('listing', ['tagCount' => 99])
            ->where(['Systems.system_category_id' => $systemCategory->id]);

        if ($systems->count() === 0) {
            if ($urlFilters) {
                $systems = null;
                $this->Crud->serialize(compact('systems'));

                return;
            }

            $this->request = $this->request->withAttribute('parent_id', $systemCategory->id);

            return $this->index();
        }

        $systems = $this->paginate($systems);

        $this->Crud->serialize(compact('systems'));
    }
}
