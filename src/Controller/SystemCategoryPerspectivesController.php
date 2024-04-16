<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * SystemCategoryPerspectives Controller
 *
 * @property \ProductBackend\Model\Table\SystemCategoryPerspectivesTable $SystemCategoryPerspectives
 * @method \ProductBackend\Model\Entity\SystemCategoryPerspective[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SystemCategoryPerspectivesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Perspectives', 'SystemCategories', 'Banners'],
        ];
        $systemCategoryPerspectives = $this->paginate($this->SystemCategoryPerspectives);

        $this->set(compact('systemCategoryPerspectives'));
    }

    /**
     * View method
     *
     * @param string|null $id System Category Perspective id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $systemCategoryPerspective = $this->SystemCategoryPerspectives->get($id, contain: ['Perspectives', 'SystemCategories', 'Banners']);

        $this->set(compact('systemCategoryPerspective'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $systemCategoryPerspective = $this->SystemCategoryPerspectives->newEmptyEntity();
        if ($this->request->is('post')) {
            $systemCategoryPerspective = $this->SystemCategoryPerspectives->patchEntity($systemCategoryPerspective, $this->request->getData());
            if ($this->SystemCategoryPerspectives->save($systemCategoryPerspective)) {
                $this->Flash->success(__('The system category perspective has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The system category perspective could not be saved. Please, try again.'));
        }
        $perspectives = $this->SystemCategoryPerspectives->Perspectives->find('list', ['limit' => 200]);
        $systemCategories = $this->SystemCategoryPerspectives->SystemCategories->find('list', ['limit' => 200]);
        $banners = $this->SystemCategoryPerspectives->Banners->find('list', ['limit' => 200]);
        $this->set(compact('systemCategoryPerspective', 'perspectives', 'systemCategories', 'banners'));
    }

    /**
     * Edit method
     *
     * @param string|null $id System Category Perspective id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $systemCategoryPerspective = $this->SystemCategoryPerspectives->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $systemCategoryPerspective = $this->SystemCategoryPerspectives->patchEntity($systemCategoryPerspective, $this->request->getData());
            if ($this->SystemCategoryPerspectives->save($systemCategoryPerspective)) {
                $this->Flash->success(__('The system category perspective has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The system category perspective could not be saved. Please, try again.'));
        }
        $perspectives = $this->SystemCategoryPerspectives->Perspectives->find('list', ['limit' => 200]);
        $systemCategories = $this->SystemCategoryPerspectives->SystemCategories->find('list', ['limit' => 200]);
        $banners = $this->SystemCategoryPerspectives->Banners->find('list', ['limit' => 200]);
        $this->set(compact('systemCategoryPerspective', 'perspectives', 'systemCategories', 'banners'));
    }

    /**
     * Delete method
     *
     * @param string|null $id System Category Perspective id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $systemCategoryPerspective = $this->SystemCategoryPerspectives->get($id);
        if ($this->SystemCategoryPerspectives->delete($systemCategoryPerspective)) {
            $this->Flash->success(__('The system category perspective has been deleted.'));
        } else {
            $this->Flash->error(__('The system category perspective could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
