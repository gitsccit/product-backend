<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * KitItems Controller
 *
 * @property \ProductBackend\Model\Table\KitItemsTable $KitItems
 * @method \ProductBackend\Model\Entity\KitItem[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class KitItemsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Kits', 'GroupItems'],
        ];
        $kitItems = $this->paginate($this->KitItems);

        $this->set(compact('kitItems'));
    }

    /**
     * View method
     *
     * @param string|null $id Kit Item id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $kitItem = $this->KitItems->get($id, contain: ['Kits', 'GroupItems']);

        $this->set(compact('kitItem'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $kitItem = $this->KitItems->newEmptyEntity();
        if ($this->request->is('post')) {
            $kitItem = $this->KitItems->patchEntity($kitItem, $this->request->getData());
            if ($this->KitItems->save($kitItem)) {
                $this->Flash->success(__('The kit item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The kit item could not be saved. Please, try again.'));
        }
        $kits = $this->KitItems->Kits->find('list', ['limit' => 200]);
        $groupItems = $this->KitItems->GroupItems->find('list', ['limit' => 200]);
        $this->set(compact('kitItem', 'kits', 'groupItems'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Kit Item id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $kitItem = $this->KitItems->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $kitItem = $this->KitItems->patchEntity($kitItem, $this->request->getData());
            if ($this->KitItems->save($kitItem)) {
                $this->Flash->success(__('The kit item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The kit item could not be saved. Please, try again.'));
        }
        $kits = $this->KitItems->Kits->find('list', ['limit' => 200]);
        $groupItems = $this->KitItems->GroupItems->find('list', ['limit' => 200]);
        $this->set(compact('kitItem', 'kits', 'groupItems'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Kit Item id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $kitItem = $this->KitItems->get($id);
        if ($this->KitItems->delete($kitItem)) {
            $this->Flash->success(__('The kit item has been deleted.'));
        } else {
            $this->Flash->error(__('The kit item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
