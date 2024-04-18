<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * BucketCategories Controller
 *
 * @property \ProductBackend\Model\Table\BucketCategoriesTable $BucketCategories
 * @method \ProductBackend\Model\Entity\BucketCategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BucketCategoriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ParentBucketCategories'],
        ];
        $bucketCategories = $this->paginate($this->BucketCategories);

        $this->set(compact('bucketCategories'));
    }

    /**
     * View method
     *
     * @param string|null $id Bucket Category id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bucketCategory = $this->BucketCategories->get($id, contain: ['ParentBucketCategories', 'ChildBucketCategories', 'Buckets', 'Groups']);

        $this->set(compact('bucketCategory'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bucketCategory = $this->BucketCategories->newEmptyEntity();
        if ($this->request->is('post')) {
            $bucketCategory = $this->BucketCategories->patchEntity($bucketCategory, $this->request->getData());
            if ($this->BucketCategories->save($bucketCategory)) {
                $this->Flash->success(__('The bucket category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bucket category could not be saved. Please, try again.'));
        }
        $parentBucketCategories = $this->BucketCategories->ParentBucketCategories->find(limit: 200)->all()->toList();
        $this->set(compact('bucketCategory', 'parentBucketCategories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bucket Category id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bucketCategory = $this->BucketCategories->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bucketCategory = $this->BucketCategories->patchEntity($bucketCategory, $this->request->getData());
            if ($this->BucketCategories->save($bucketCategory)) {
                $this->Flash->success(__('The bucket category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bucket category could not be saved. Please, try again.'));
        }
        $parentBucketCategories = $this->BucketCategories->ParentBucketCategories->find(limit: 200)->all()->toList();
        $this->set(compact('bucketCategory', 'parentBucketCategories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bucket Category id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bucketCategory = $this->BucketCategories->get($id);
        if ($this->BucketCategories->delete($bucketCategory)) {
            $this->Flash->success(__('The bucket category has been deleted.'));
        } else {
            $this->Flash->error(__('The bucket category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
