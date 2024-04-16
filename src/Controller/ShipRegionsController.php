<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * ShipRegions Controller
 *
 * @property \ProductBackend\Model\Table\ShipRegionsTable $ShipRegions
 * @method \ProductBackend\Model\Entity\ShipRegion[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ShipRegionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $shipRegions = $this->paginate($this->ShipRegions);

        $this->set(compact('shipRegions'));
    }

    /**
     * View method
     *
     * @param string|null $id Ship Region id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $shipRegion = $this->ShipRegions->get($id, contain: ['ShipRateShipRegionPrices', 'ShipRegionLocations']);

        $this->set(compact('shipRegion'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $shipRegion = $this->ShipRegions->newEmptyEntity();
        if ($this->request->is('post')) {
            $shipRegion = $this->ShipRegions->patchEntity($shipRegion, $this->request->getData());
            if ($this->ShipRegions->save($shipRegion)) {
                $this->Flash->success(__('The ship region has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ship region could not be saved. Please, try again.'));
        }
        $this->set(compact('shipRegion'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Ship Region id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $shipRegion = $this->ShipRegions->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $shipRegion = $this->ShipRegions->patchEntity($shipRegion, $this->request->getData());
            if ($this->ShipRegions->save($shipRegion)) {
                $this->Flash->success(__('The ship region has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ship region could not be saved. Please, try again.'));
        }
        $this->set(compact('shipRegion'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Ship Region id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $shipRegion = $this->ShipRegions->get($id);
        if ($this->ShipRegions->delete($shipRegion)) {
            $this->Flash->success(__('The ship region has been deleted.'));
        } else {
            $this->Flash->error(__('The ship region could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
