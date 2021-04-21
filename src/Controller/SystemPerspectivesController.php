<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * SystemPerspectives Controller
 *
 * @property \ProductBackend\Model\Table\SystemPerspectivesTable $SystemPerspectives
 * @method \ProductBackend\Model\Entity\SystemPerspective[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SystemPerspectivesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Perspectives', 'Systems'],
        ];
        $systemPerspectives = $this->paginate($this->SystemPerspectives);

        $this->set(compact('systemPerspectives'));
    }

    /**
     * View method
     *
     * @param string|null $id System Perspective id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $systemPerspective = $this->SystemPerspectives->get($id, [
            'contain' => ['Perspectives', 'Systems'],
        ]);

        $this->set(compact('systemPerspective'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $systemPerspective = $this->SystemPerspectives->newEmptyEntity();
        if ($this->request->is('post')) {
            $systemPerspective = $this->SystemPerspectives->patchEntity($systemPerspective, $this->request->getData());
            if ($this->SystemPerspectives->save($systemPerspective)) {
                $this->Flash->success(__('The system perspective has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The system perspective could not be saved. Please, try again.'));
        }
        $perspectives = $this->SystemPerspectives->Perspectives->find('list', ['limit' => 200]);
        $systems = $this->SystemPerspectives->Systems->find('list', ['limit' => 200]);
        $this->set(compact('systemPerspective', 'perspectives', 'systems'));
    }

    /**
     * Edit method
     *
     * @param string|null $id System Perspective id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $systemPerspective = $this->SystemPerspectives->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $systemPerspective = $this->SystemPerspectives->patchEntity($systemPerspective, $this->request->getData());
            if ($this->SystemPerspectives->save($systemPerspective)) {
                $this->Flash->success(__('The system perspective has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The system perspective could not be saved. Please, try again.'));
        }
        $perspectives = $this->SystemPerspectives->Perspectives->find('list', ['limit' => 200]);
        $systems = $this->SystemPerspectives->Systems->find('list', ['limit' => 200]);
        $this->set(compact('systemPerspective', 'perspectives', 'systems'));
    }

    /**
     * Delete method
     *
     * @param string|null $id System Perspective id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $systemPerspective = $this->SystemPerspectives->get($id);
        if ($this->SystemPerspectives->delete($systemPerspective)) {
            $this->Flash->success(__('The system perspective has been deleted.'));
        } else {
            $this->Flash->error(__('The system perspective could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
