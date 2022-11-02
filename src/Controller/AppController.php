<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

use App\Controller\AppController as BaseController;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

class AppController extends BaseController
{
    public function initialize(): void
    {
        parent::initialize();

        $activeDB = TableRegistry::getTableLocator()->get('ProductBackend.ActiveBackendDatabase')->find()->first()->name;
        ConnectionManager::get('product_backend')->execute("USE $activeDB;");
    }
}
