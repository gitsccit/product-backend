<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * ActiveBackendDatabase Controller
 *
 * @property \ProductBackend\Model\Table\ActiveBackendDatabaseTable $ActiveBackendDatabase
 * @method \ProductBackend\Model\Entity\ActiveBackendDatabase[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ActiveBackendDatabaseController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $activeBackendDatabase = $this->paginate($this->ActiveBackendDatabase);

        $this->set(compact('activeBackendDatabase'));
    }

    /**
     * View method
     *
     * @param string|null $id Active Backend Database id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $activeBackendDatabase = $this->ActiveBackendDatabase->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('activeBackendDatabase'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $activeBackendDatabase = $this->ActiveBackendDatabase->newEmptyEntity();
        if ($this->request->is('post')) {
            $activeBackendDatabase = $this->ActiveBackendDatabase->patchEntity($activeBackendDatabase, $this->request->getData());
            if ($this->ActiveBackendDatabase->save($activeBackendDatabase)) {
                $this->Flash->success(__('The active backend database has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The active backend database could not be saved. Please, try again.'));
        }
        $this->set(compact('activeBackendDatabase'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Active Backend Database id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $activeBackendDatabase = $this->ActiveBackendDatabase->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $activeBackendDatabase = $this->ActiveBackendDatabase->patchEntity($activeBackendDatabase, $this->request->getData());
            if ($this->ActiveBackendDatabase->save($activeBackendDatabase)) {
                $this->Flash->success(__('The active backend database has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The active backend database could not be saved. Please, try again.'));
        }
        $this->set(compact('activeBackendDatabase'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Active Backend Database id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $activeBackendDatabase = $this->ActiveBackendDatabase->get($id);
        if ($this->ActiveBackendDatabase->delete($activeBackendDatabase)) {
            $this->Flash->success(__('The active backend database has been deleted.'));
        } else {
            $this->Flash->error(__('The active backend database could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
