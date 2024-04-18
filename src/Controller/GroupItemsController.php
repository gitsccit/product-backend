<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * GroupItems Controller
 *
 * @property \ProductBackend\Model\Table\GroupItemsTable $GroupItems
 * @method \ProductBackend\Model\Entity\GroupItem[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GroupItemsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Groups', 'Products', 'Systems'],
        ];
        $groupItems = $this->paginate($this->GroupItems);

        $this->set(compact('groupItems'));
    }

    /**
     * View method
     *
     * @param string|null $id Group Item id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $groupItem = $this->GroupItems->get($id, contain: ['Groups', 'Products', 'Systems', 'KitItems', 'SystemRuleDetails']);

        $this->set(compact('groupItem'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $groupItem = $this->GroupItems->newEmptyEntity();
        if ($this->request->is('post')) {
            $groupItem = $this->GroupItems->patchEntity($groupItem, $this->request->getData());
            if ($this->GroupItems->save($groupItem)) {
                $this->Flash->success(__('The group item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The group item could not be saved. Please, try again.'));
        }
        $groups = $this->GroupItems->Groups->find(limit: 200)->all()->toList();
        $products = $this->GroupItems->Products->find(limit: 200)->all()->toList();
        $systems = $this->GroupItems->Systems->find(limit: 200)->all()->toList();
        $this->set(compact('groupItem', 'groups', 'products', 'systems'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Group Item id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $groupItem = $this->GroupItems->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $groupItem = $this->GroupItems->patchEntity($groupItem, $this->request->getData());
            if ($this->GroupItems->save($groupItem)) {
                $this->Flash->success(__('The group item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The group item could not be saved. Please, try again.'));
        }
        $groups = $this->GroupItems->Groups->find(limit: 200)->all()->toList();
        $products = $this->GroupItems->Products->find(limit: 200)->all()->toList();
        $systems = $this->GroupItems->Systems->find(limit: 200)->all()->toList();
        $this->set(compact('groupItem', 'groups', 'products', 'systems'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Group Item id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $groupItem = $this->GroupItems->get($id);
        if ($this->GroupItems->delete($groupItem)) {
            $this->Flash->success(__('The group item has been deleted.'));
        } else {
            $this->Flash->error(__('The group item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
