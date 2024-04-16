<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * ShipBoxesShipRates Controller
 *
 * @property \ProductBackend\Model\Table\ShipBoxesShipRatesTable $ShipBoxesShipRates
 * @method \ProductBackend\Model\Entity\ShipBoxesShipRate[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ShipBoxesShipRatesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ShipBoxes', 'ShipRates'],
        ];
        $shipBoxesShipRates = $this->paginate($this->ShipBoxesShipRates);

        $this->set(compact('shipBoxesShipRates'));
    }

    /**
     * View method
     *
     * @param string|null $id Ship Boxes Ship Rate id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $shipBoxesShipRate = $this->ShipBoxesShipRates->get($id, contain: ['ShipBoxes', 'ShipRates']);

        $this->set(compact('shipBoxesShipRate'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $shipBoxesShipRate = $this->ShipBoxesShipRates->newEmptyEntity();
        if ($this->request->is('post')) {
            $shipBoxesShipRate = $this->ShipBoxesShipRates->patchEntity($shipBoxesShipRate, $this->request->getData());
            if ($this->ShipBoxesShipRates->save($shipBoxesShipRate)) {
                $this->Flash->success(__('The ship boxes ship rate has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ship boxes ship rate could not be saved. Please, try again.'));
        }
        $shipBoxes = $this->ShipBoxesShipRates->ShipBoxes->find('list', ['limit' => 200]);
        $shipRates = $this->ShipBoxesShipRates->ShipRates->find('list', ['limit' => 200]);
        $this->set(compact('shipBoxesShipRate', 'shipBoxes', 'shipRates'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Ship Boxes Ship Rate id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $shipBoxesShipRate = $this->ShipBoxesShipRates->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $shipBoxesShipRate = $this->ShipBoxesShipRates->patchEntity($shipBoxesShipRate, $this->request->getData());
            if ($this->ShipBoxesShipRates->save($shipBoxesShipRate)) {
                $this->Flash->success(__('The ship boxes ship rate has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ship boxes ship rate could not be saved. Please, try again.'));
        }
        $shipBoxes = $this->ShipBoxesShipRates->ShipBoxes->find('list', ['limit' => 200]);
        $shipRates = $this->ShipBoxesShipRates->ShipRates->find('list', ['limit' => 200]);
        $this->set(compact('shipBoxesShipRate', 'shipBoxes', 'shipRates'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Ship Boxes Ship Rate id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $shipBoxesShipRate = $this->ShipBoxesShipRates->get($id);
        if ($this->ShipBoxesShipRates->delete($shipBoxesShipRate)) {
            $this->Flash->success(__('The ship boxes ship rate has been deleted.'));
        } else {
            $this->Flash->error(__('The ship boxes ship rate could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
