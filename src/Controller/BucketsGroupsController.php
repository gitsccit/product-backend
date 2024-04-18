<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * BucketsGroups Controller
 *
 * @property \ProductBackend\Model\Table\BucketsGroupsTable $BucketsGroups
 * @method \ProductBackend\Model\Entity\BucketsGroup[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BucketsGroupsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Buckets', 'Groups'],
        ];
        $bucketsGroups = $this->paginate($this->BucketsGroups);

        $this->set(compact('bucketsGroups'));
    }

    /**
     * View method
     *
     * @param string|null $id Buckets Group id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bucketsGroup = $this->BucketsGroups->get($id, contain: ['Buckets', 'Groups']);

        $this->set(compact('bucketsGroup'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bucketsGroup = $this->BucketsGroups->newEmptyEntity();
        if ($this->request->is('post')) {
            $bucketsGroup = $this->BucketsGroups->patchEntity($bucketsGroup, $this->request->getData());
            if ($this->BucketsGroups->save($bucketsGroup)) {
                $this->Flash->success(__('The buckets group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The buckets group could not be saved. Please, try again.'));
        }
        $buckets = $this->BucketsGroups->Buckets->find(limit: 200)->all()->toList();
        $groups = $this->BucketsGroups->Groups->find(limit: 200)->all()->toList();
        $this->set(compact('bucketsGroup', 'buckets', 'groups'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Buckets Group id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bucketsGroup = $this->BucketsGroups->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bucketsGroup = $this->BucketsGroups->patchEntity($bucketsGroup, $this->request->getData());
            if ($this->BucketsGroups->save($bucketsGroup)) {
                $this->Flash->success(__('The buckets group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The buckets group could not be saved. Please, try again.'));
        }
        $buckets = $this->BucketsGroups->Buckets->find(limit: 200)->all()->toList();
        $groups = $this->BucketsGroups->Groups->find(limit: 200)->all()->toList();
        $this->set(compact('bucketsGroup', 'buckets', 'groups'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Buckets Group id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bucketsGroup = $this->BucketsGroups->get($id);
        if ($this->BucketsGroups->delete($bucketsGroup)) {
            $this->Flash->success(__('The buckets group has been deleted.'));
        } else {
            $this->Flash->error(__('The buckets group could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
