<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * Kits Controller
 *
 * @property \ProductBackend\Model\Table\KitsTable $Kits
 * @method \ProductBackend\Model\Entity\Kit[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class KitsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Locations', 'ShipBoxes'],
        ];
        $kits = $this->paginate($this->Kits);

        $this->set(compact('kits'));
    }

    /**
     * View method
     *
     * @param string|null $id Kit id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $kit = $this->Kits->get($id, [
            'contain' => ['Locations', 'ShipBoxes', 'Icons', 'Tags', 'KitBuckets', 'KitItems', 'Systems'],
        ]);

        $this->set(compact('kit'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $kit = $this->Kits->newEmptyEntity();
        if ($this->request->is('post')) {
            $kit = $this->Kits->patchEntity($kit, $this->request->getData());
            if ($this->Kits->save($kit)) {
                $this->Flash->success(__('The kit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The kit could not be saved. Please, try again.'));
        }
        $locations = $this->Kits->Locations->find('list', ['limit' => 200]);
        $shipBoxes = $this->Kits->ShipBoxes->find('list', ['limit' => 200]);
        $icons = $this->Kits->Icons->find('list', ['limit' => 200]);
        $tags = $this->Kits->Tags->find('list', ['limit' => 200]);
        $this->set(compact('kit', 'locations', 'shipBoxes', 'icons', 'tags'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Kit id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $kit = $this->Kits->get($id, [
            'contain' => ['Icons', 'Tags'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $kit = $this->Kits->patchEntity($kit, $this->request->getData());
            if ($this->Kits->save($kit)) {
                $this->Flash->success(__('The kit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The kit could not be saved. Please, try again.'));
        }
        $locations = $this->Kits->Locations->find('list', ['limit' => 200]);
        $shipBoxes = $this->Kits->ShipBoxes->find('list', ['limit' => 200]);
        $icons = $this->Kits->Icons->find('list', ['limit' => 200]);
        $tags = $this->Kits->Tags->find('list', ['limit' => 200]);
        $this->set(compact('kit', 'locations', 'shipBoxes', 'icons', 'tags'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Kit id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $kit = $this->Kits->get($id);
        if ($this->Kits->delete($kit)) {
            $this->Flash->success(__('The kit has been deleted.'));
        } else {
            $this->Flash->error(__('The kit could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
