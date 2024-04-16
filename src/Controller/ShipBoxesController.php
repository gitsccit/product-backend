<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * ShipBoxes Controller
 *
 * @property \ProductBackend\Model\Table\ShipBoxesTable $ShipBoxes
 * @method \ProductBackend\Model\Entity\ShipBox[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ShipBoxesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $shipBoxes = $this->paginate($this->ShipBoxes);

        $this->set(compact('shipBoxes'));
    }

    /**
     * View method
     *
     * @param string|null $id Ship Box id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $shipBox = $this->ShipBoxes->get($id, contain: ['ShipRates', 'Kits', 'Products']);

        $this->set(compact('shipBox'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $shipBox = $this->ShipBoxes->newEmptyEntity();
        if ($this->request->is('post')) {
            $shipBox = $this->ShipBoxes->patchEntity($shipBox, $this->request->getData());
            if ($this->ShipBoxes->save($shipBox)) {
                $this->Flash->success(__('The ship box has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ship box could not be saved. Please, try again.'));
        }
        $shipRates = $this->ShipBoxes->ShipRates->find('list', ['limit' => 200]);
        $this->set(compact('shipBox', 'shipRates'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Ship Box id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $shipBox = $this->ShipBoxes->get($id, contain: ['ShipRates']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $shipBox = $this->ShipBoxes->patchEntity($shipBox, $this->request->getData());
            if ($this->ShipBoxes->save($shipBox)) {
                $this->Flash->success(__('The ship box has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ship box could not be saved. Please, try again.'));
        }
        $shipRates = $this->ShipBoxes->ShipRates->find('list', ['limit' => 200]);
        $this->set(compact('shipBox', 'shipRates'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Ship Box id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $shipBox = $this->ShipBoxes->get($id);
        if ($this->ShipBoxes->delete($shipBox)) {
            $this->Flash->success(__('The ship box has been deleted.'));
        } else {
            $this->Flash->error(__('The ship box could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
