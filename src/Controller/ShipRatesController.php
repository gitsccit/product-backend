<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * ShipRates Controller
 *
 * @property \ProductBackend\Model\Table\ShipRatesTable $ShipRates
 * @method \ProductBackend\Model\Entity\ShipRate[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ShipRatesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $shipRates = $this->paginate($this->ShipRates);

        $this->set(compact('shipRates'));
    }

    /**
     * View method
     *
     * @param string|null $id Ship Rate id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $shipRate = $this->ShipRates->get($id, contain: ['ShipBoxes', 'ShipRateShipRegionPrices']);

        $this->set(compact('shipRate'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $shipRate = $this->ShipRates->newEmptyEntity();
        if ($this->request->is('post')) {
            $shipRate = $this->ShipRates->patchEntity($shipRate, $this->request->getData());
            if ($this->ShipRates->save($shipRate)) {
                $this->Flash->success(__('The ship rate has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ship rate could not be saved. Please, try again.'));
        }
        $shipBoxes = $this->ShipRates->ShipBoxes->find(limit: 200)->all()->toList();
        $this->set(compact('shipRate', 'shipBoxes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Ship Rate id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $shipRate = $this->ShipRates->get($id, contain: ['ShipBoxes']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $shipRate = $this->ShipRates->patchEntity($shipRate, $this->request->getData());
            if ($this->ShipRates->save($shipRate)) {
                $this->Flash->success(__('The ship rate has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ship rate could not be saved. Please, try again.'));
        }
        $shipBoxes = $this->ShipRates->ShipBoxes->find(limit: 200)->all()->toList();
        $this->set(compact('shipRate', 'shipBoxes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Ship Rate id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $shipRate = $this->ShipRates->get($id);
        if ($this->ShipRates->delete($shipRate)) {
            $this->Flash->success(__('The ship rate has been deleted.'));
        } else {
            $this->Flash->error(__('The ship rate could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
