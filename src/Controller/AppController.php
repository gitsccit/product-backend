<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

use App\Controller\AppController as BaseController;
use Cake\Event\EventInterface;

class AppController extends BaseController
{
    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);

        $this->set('filesApiHandler', new \FilesApiHandler());
    }
}
