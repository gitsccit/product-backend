<?php
declare(strict_types=1);

namespace ProductBackend\Controller\Api;

/**
 * Systems Controller
 *
 * @property \ProductBackend\Model\Table\SystemsTable $Systems
 * @method \ProductBackend\Model\Entity\System[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SystemsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Permissions'],
        ];
        $Systems = $this->paginate($this->Systems);

        $this->Crud->serialize(compact('Systems'));
    }

    /**
     * View method
     *
     * @param string|null $id Environment id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $environment = $this->Systems->get($id, [
            'contain' => ['Permissions', 'OptionStores', 'StoreIpMaps'],
        ]);

        $this->Crud->serialize(compact('environment'));
    }
}
