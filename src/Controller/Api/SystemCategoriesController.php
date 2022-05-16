<?php
declare(strict_types=1);

namespace ProductBackend\Controller\Api;

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

        $this->Crud->serialize(compact('systemCategories'));
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

        $systems = $this->paginate($systems);

        $this->Crud->serialize(compact('systems'));
    }
}
