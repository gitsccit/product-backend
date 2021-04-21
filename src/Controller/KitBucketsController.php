<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * KitBuckets Controller
 *
 * @property \ProductBackend\Model\Table\KitBucketsTable $KitBuckets
 * @method \ProductBackend\Model\Entity\KitBucket[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class KitBucketsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Kits', 'Buckets'],
        ];
        $kitBuckets = $this->paginate($this->KitBuckets);

        $this->set(compact('kitBuckets'));
    }

    /**
     * View method
     *
     * @param string|null $id Kit Bucket id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $kitBucket = $this->KitBuckets->get($id, [
            'contain' => ['Kits', 'Buckets'],
        ]);

        $this->set(compact('kitBucket'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $kitBucket = $this->KitBuckets->newEmptyEntity();
        if ($this->request->is('post')) {
            $kitBucket = $this->KitBuckets->patchEntity($kitBucket, $this->request->getData());
            if ($this->KitBuckets->save($kitBucket)) {
                $this->Flash->success(__('The kit bucket has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The kit bucket could not be saved. Please, try again.'));
        }
        $kits = $this->KitBuckets->Kits->find('list', ['limit' => 200]);
        $buckets = $this->KitBuckets->Buckets->find('list', ['limit' => 200]);
        $this->set(compact('kitBucket', 'kits', 'buckets'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Kit Bucket id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $kitBucket = $this->KitBuckets->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $kitBucket = $this->KitBuckets->patchEntity($kitBucket, $this->request->getData());
            if ($this->KitBuckets->save($kitBucket)) {
                $this->Flash->success(__('The kit bucket has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The kit bucket could not be saved. Please, try again.'));
        }
        $kits = $this->KitBuckets->Kits->find('list', ['limit' => 200]);
        $buckets = $this->KitBuckets->Buckets->find('list', ['limit' => 200]);
        $this->set(compact('kitBucket', 'kits', 'buckets'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Kit Bucket id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $kitBucket = $this->KitBuckets->get($id);
        if ($this->KitBuckets->delete($kitBucket)) {
            $this->Flash->success(__('The kit bucket has been deleted.'));
        } else {
            $this->Flash->error(__('The kit bucket could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
