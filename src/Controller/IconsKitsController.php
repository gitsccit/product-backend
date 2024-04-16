<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * IconsKits Controller
 *
 * @property \ProductBackend\Model\Table\IconsKitsTable $IconsKits
 * @method \ProductBackend\Model\Entity\IconsKit[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class IconsKitsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Icons', 'Kits'],
        ];
        $iconsKits = $this->paginate($this->IconsKits);

        $this->set(compact('iconsKits'));
    }

    /**
     * View method
     *
     * @param string|null $id Icons Kit id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $iconsKit = $this->IconsKits->get($id, contain: ['Icons', 'Kits']);

        $this->set(compact('iconsKit'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $iconsKit = $this->IconsKits->newEmptyEntity();
        if ($this->request->is('post')) {
            $iconsKit = $this->IconsKits->patchEntity($iconsKit, $this->request->getData());
            if ($this->IconsKits->save($iconsKit)) {
                $this->Flash->success(__('The icons kit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The icons kit could not be saved. Please, try again.'));
        }
        $icons = $this->IconsKits->Icons->find('list', ['limit' => 200]);
        $kits = $this->IconsKits->Kits->find('list', ['limit' => 200]);
        $this->set(compact('iconsKit', 'icons', 'kits'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Icons Kit id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $iconsKit = $this->IconsKits->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $iconsKit = $this->IconsKits->patchEntity($iconsKit, $this->request->getData());
            if ($this->IconsKits->save($iconsKit)) {
                $this->Flash->success(__('The icons kit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The icons kit could not be saved. Please, try again.'));
        }
        $icons = $this->IconsKits->Icons->find('list', ['limit' => 200]);
        $kits = $this->IconsKits->Kits->find('list', ['limit' => 200]);
        $this->set(compact('iconsKit', 'icons', 'kits'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Icons Kit id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $iconsKit = $this->IconsKits->get($id);
        if ($this->IconsKits->delete($iconsKit)) {
            $this->Flash->success(__('The icons kit has been deleted.'));
        } else {
            $this->Flash->error(__('The icons kit could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
