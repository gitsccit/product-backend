<?php
declare(strict_types=1);

namespace ProductBackend\Controller\Api;

use App\Controller\Api\AppController as BaseController;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

class AppController extends BaseController
{
    public function initialize(): void
    {
        parent::initialize();

        $activeDB = TableRegistry::getTableLocator()->get('ProductBackend.ActiveBackendDatabase')->find()->first()->name;
        ConnectionManager::get('product_backend')->execute("USE $activeDB;");

        Configure::write('ProductBackend', [
            'showStock' => false,
            'showCost' => false,
        ]);

        if ($perspective = $this->request->getQuery('perspective')) {
            $this->request->getSession()->write('store.perspective', $perspective);
        }

        if ($priceLevel = $this->request->getQuery('price-level')) {
            $this->request->getSession()->write('store.price_level', $priceLevel);
        }
    }
}
