<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * ShipRegionLocations Controller
 *
 * @property \ProductBackend\Model\Table\ShipRegionLocationsTable $ShipRegionLocations
 * @method \ProductBackend\Model\Entity\ShipRegionLocation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ShipRegionLocationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ShipRegions'],
        ];
        $shipRegionLocations = $this->paginate($this->ShipRegionLocations);

        $this->set(compact('shipRegionLocations'));
    }

    /**
     * View method
     *
     * @param string|null $id Ship Region Location id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $shipRegionLocation = $this->ShipRegionLocations->get($id, [
            'contain' => ['ShipRegions'],
        ]);

        $this->set(compact('shipRegionLocation'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $shipRegionLocation = $this->ShipRegionLocations->newEmptyEntity();
        if ($this->request->is('post')) {
            $shipRegionLocation = $this->ShipRegionLocations->patchEntity($shipRegionLocation, $this->request->getData());
            if ($this->ShipRegionLocations->save($shipRegionLocation)) {
                $this->Flash->success(__('The ship region location has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ship region location could not be saved. Please, try again.'));
        }
        $shipRegions = $this->ShipRegionLocations->ShipRegions->find('list', ['limit' => 200]);
        $this->set(compact('shipRegionLocation', 'shipRegions'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Ship Region Location id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $shipRegionLocation = $this->ShipRegionLocations->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $shipRegionLocation = $this->ShipRegionLocations->patchEntity($shipRegionLocation, $this->request->getData());
            if ($this->ShipRegionLocations->save($shipRegionLocation)) {
                $this->Flash->success(__('The ship region location has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ship region location could not be saved. Please, try again.'));
        }
        $shipRegions = $this->ShipRegionLocations->ShipRegions->find('list', ['limit' => 200]);
        $this->set(compact('shipRegionLocation', 'shipRegions'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Ship Region Location id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $shipRegionLocation = $this->ShipRegionLocations->get($id);
        if ($this->ShipRegionLocations->delete($shipRegionLocation)) {
            $this->Flash->success(__('The ship region location has been deleted.'));
        } else {
            $this->Flash->error(__('The ship region location could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
