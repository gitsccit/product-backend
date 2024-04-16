<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * ShipRateShipRegionPrices Controller
 *
 * @property \ProductBackend\Model\Table\ShipRateShipRegionPricesTable $ShipRateShipRegionPrices
 * @method \ProductBackend\Model\Entity\ShipRateShipRegionPrice[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ShipRateShipRegionPricesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ShipRates', 'ShipRegions'],
        ];
        $shipRateShipRegionPrices = $this->paginate($this->ShipRateShipRegionPrices);

        $this->set(compact('shipRateShipRegionPrices'));
    }

    /**
     * View method
     *
     * @param string|null $id Ship Rate Ship Region Price id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $shipRateShipRegionPrice = $this->ShipRateShipRegionPrices->get($id, contain: ['ShipRates', 'ShipRegions']);

        $this->set(compact('shipRateShipRegionPrice'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $shipRateShipRegionPrice = $this->ShipRateShipRegionPrices->newEmptyEntity();
        if ($this->request->is('post')) {
            $shipRateShipRegionPrice = $this->ShipRateShipRegionPrices->patchEntity($shipRateShipRegionPrice, $this->request->getData());
            if ($this->ShipRateShipRegionPrices->save($shipRateShipRegionPrice)) {
                $this->Flash->success(__('The ship rate ship region price has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ship rate ship region price could not be saved. Please, try again.'));
        }
        $shipRates = $this->ShipRateShipRegionPrices->ShipRates->find('list', ['limit' => 200]);
        $shipRegions = $this->ShipRateShipRegionPrices->ShipRegions->find('list', ['limit' => 200]);
        $this->set(compact('shipRateShipRegionPrice', 'shipRates', 'shipRegions'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Ship Rate Ship Region Price id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $shipRateShipRegionPrice = $this->ShipRateShipRegionPrices->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $shipRateShipRegionPrice = $this->ShipRateShipRegionPrices->patchEntity($shipRateShipRegionPrice, $this->request->getData());
            if ($this->ShipRateShipRegionPrices->save($shipRateShipRegionPrice)) {
                $this->Flash->success(__('The ship rate ship region price has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ship rate ship region price could not be saved. Please, try again.'));
        }
        $shipRates = $this->ShipRateShipRegionPrices->ShipRates->find('list', ['limit' => 200]);
        $shipRegions = $this->ShipRateShipRegionPrices->ShipRegions->find('list', ['limit' => 200]);
        $this->set(compact('shipRateShipRegionPrice', 'shipRates', 'shipRegions'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Ship Rate Ship Region Price id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $shipRateShipRegionPrice = $this->ShipRateShipRegionPrices->get($id);
        if ($this->ShipRateShipRegionPrices->delete($shipRateShipRegionPrice)) {
            $this->Flash->success(__('The ship rate ship region price has been deleted.'));
        } else {
            $this->Flash->error(__('The ship rate ship region price could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
