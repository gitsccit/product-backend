<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * KitsTags Controller
 *
 * @property \ProductBackend\Model\Table\KitsTagsTable $KitsTags
 * @method \ProductBackend\Model\Entity\KitsTag[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class KitsTagsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Kits', 'Tags'],
        ];
        $kitsTags = $this->paginate($this->KitsTags);

        $this->set(compact('kitsTags'));
    }

    /**
     * View method
     *
     * @param string|null $id Kits Tag id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $kitsTag = $this->KitsTags->get($id, contain: ['Kits', 'Tags']);

        $this->set(compact('kitsTag'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $kitsTag = $this->KitsTags->newEmptyEntity();
        if ($this->request->is('post')) {
            $kitsTag = $this->KitsTags->patchEntity($kitsTag, $this->request->getData());
            if ($this->KitsTags->save($kitsTag)) {
                $this->Flash->success(__('The kits tag has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The kits tag could not be saved. Please, try again.'));
        }
        $kits = $this->KitsTags->Kits->find(limit: 200)->all()->toList();
        $tags = $this->KitsTags->Tags->find(limit: 200)->all()->toList();
        $this->set(compact('kitsTag', 'kits', 'tags'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Kits Tag id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $kitsTag = $this->KitsTags->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $kitsTag = $this->KitsTags->patchEntity($kitsTag, $this->request->getData());
            if ($this->KitsTags->save($kitsTag)) {
                $this->Flash->success(__('The kits tag has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The kits tag could not be saved. Please, try again.'));
        }
        $kits = $this->KitsTags->Kits->find(limit: 200)->all()->toList();
        $tags = $this->KitsTags->Tags->find(limit: 200)->all()->toList();
        $this->set(compact('kitsTag', 'kits', 'tags'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Kits Tag id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $kitsTag = $this->KitsTags->get($id);
        if ($this->KitsTags->delete($kitsTag)) {
            $this->Flash->success(__('The kits tag has been deleted.'));
        } else {
            $this->Flash->error(__('The kits tag could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
