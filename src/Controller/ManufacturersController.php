<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * Manufacturers Controller
 *
 * @property \ProductBackend\Model\Table\ManufacturersTable $Manufacturers
 * @method \ProductBackend\Model\Entity\Manufacturer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ManufacturersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Locations', 'Images'],
        ];
        $manufacturers = $this->paginate($this->Manufacturers);

        $this->set(compact('manufacturers'));
    }

    /**
     * View method
     *
     * @param string|null $id Manufacturer id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $manufacturer = $this->Manufacturers->get($id, contain: ['Locations', 'Images', 'Products']);

        $this->set(compact('manufacturer'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $manufacturer = $this->Manufacturers->newEmptyEntity();
        if ($this->request->is('post')) {
            $manufacturer = $this->Manufacturers->patchEntity($manufacturer, $this->request->getData());
            if ($this->Manufacturers->save($manufacturer)) {
                $this->Flash->success(__('The manufacturer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The manufacturer could not be saved. Please, try again.'));
        }
        $locations = $this->Manufacturers->Locations->find(limit: 200)->all()->toList();
        $images = $this->Manufacturers->Images->find(limit: 200)->all()->toList();
        $this->set(compact('manufacturer', 'locations', 'images'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Manufacturer id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $manufacturer = $this->Manufacturers->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $manufacturer = $this->Manufacturers->patchEntity($manufacturer, $this->request->getData());
            if ($this->Manufacturers->save($manufacturer)) {
                $this->Flash->success(__('The manufacturer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The manufacturer could not be saved. Please, try again.'));
        }
        $locations = $this->Manufacturers->Locations->find(limit: 200)->all()->toList();
        $images = $this->Manufacturers->Images->find(limit: 200)->all()->toList();
        $this->set(compact('manufacturer', 'locations', 'images'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Manufacturer id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $manufacturer = $this->Manufacturers->get($id);
        if ($this->Manufacturers->delete($manufacturer)) {
            $this->Flash->success(__('The manufacturer has been deleted.'));
        } else {
            $this->Flash->error(__('The manufacturer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
