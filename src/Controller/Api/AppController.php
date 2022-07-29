<?php
declare(strict_types=1);

namespace ProductBackend\Controller\Api;

use App\Controller\Api\AppController as BaseController;
use Cake\Core\Configure;

class AppController extends BaseController
{
    public function initialize(): void
    {
        parent::initialize();

        Configure::write('ProductBackend', []);

        if ($perspective = $this->request->getQuery('perspective')) {
            $this->request->getSession()->write('store.perspective', $perspective);
        }

        if ($priceLevel = $this->request->getQuery('price-level')) {
            $this->request->getSession()->write('store.price_level', $priceLevel);
        }
    }
}
