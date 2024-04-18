<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * Icons Controller
 *
 * @property \ProductBackend\Model\Table\IconsTable $Icons
 * @method \ProductBackend\Model\Entity\Icon[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class IconsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Images'],
        ];
        $icons = $this->paginate($this->Icons);

        $this->set(compact('icons'));
    }

    /**
     * View method
     *
     * @param string|null $id Icon id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $icon = $this->Icons->get($id, contain: ['Images', 'Kits']);

        $this->set(compact('icon'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $icon = $this->Icons->newEmptyEntity();
        if ($this->request->is('post')) {
            $icon = $this->Icons->patchEntity($icon, $this->request->getData());
            if ($this->Icons->save($icon)) {
                $this->Flash->success(__('The icon has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The icon could not be saved. Please, try again.'));
        }
        $images = $this->Icons->Images->find(limit: 200)->all()->toList();
        $kits = $this->Icons->Kits->find(limit: 200)->all()->toList();
        $this->set(compact('icon', 'images', 'kits'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Icon id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $icon = $this->Icons->get($id, contain: ['Kits']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $icon = $this->Icons->patchEntity($icon, $this->request->getData());
            if ($this->Icons->save($icon)) {
                $this->Flash->success(__('The icon has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The icon could not be saved. Please, try again.'));
        }
        $images = $this->Icons->Images->find(limit: 200)->all()->toList();
        $kits = $this->Icons->Kits->find(limit: 200)->all()->toList();
        $this->set(compact('icon', 'images', 'kits'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Icon id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $icon = $this->Icons->get($id);
        if ($this->Icons->delete($icon)) {
            $this->Flash->success(__('The icon has been deleted.'));
        } else {
            $this->Flash->error(__('The icon could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
