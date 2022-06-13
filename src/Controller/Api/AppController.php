<?php
declare(strict_types=1);

namespace ProductBackend\Controller\Api;

use App\Controller\Api\AppController as BaseController;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class AppController extends BaseController
{
    public function initialize(): void
    {
        parent::initialize();

        Configure::write('ProductBackend', []);

        if ($store = $this->request->getQuery('store')) {
            $this->request->getSession()->write('store.perspective', TableRegistry::getTableLocator()->get('Stores')->get($store)->perspective);
        }
    }
}
