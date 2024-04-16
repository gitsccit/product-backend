<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * PriceLevelPerspectives Controller
 *
 * @property \ProductBackend\Model\Table\PriceLevelPerspectivesTable $PriceLevelPerspectives
 * @method \ProductBackend\Model\Entity\PriceLevelPerspective[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PriceLevelPerspectivesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Perspectives', 'PriceLevels'],
        ];
        $priceLevelPerspectives = $this->paginate($this->PriceLevelPerspectives);

        $this->set(compact('priceLevelPerspectives'));
    }

    /**
     * View method
     *
     * @param string|null $id Price Level Perspective id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $priceLevelPerspective = $this->PriceLevelPerspectives->get($id, contain: ['Perspectives', 'PriceLevels']);

        $this->set(compact('priceLevelPerspective'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $priceLevelPerspective = $this->PriceLevelPerspectives->newEmptyEntity();
        if ($this->request->is('post')) {
            $priceLevelPerspective = $this->PriceLevelPerspectives->patchEntity($priceLevelPerspective, $this->request->getData());
            if ($this->PriceLevelPerspectives->save($priceLevelPerspective)) {
                $this->Flash->success(__('The price level perspective has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The price level perspective could not be saved. Please, try again.'));
        }
        $perspectives = $this->PriceLevelPerspectives->Perspectives->find('list', ['limit' => 200]);
        $priceLevels = $this->PriceLevelPerspectives->PriceLevels->find('list', ['limit' => 200]);
        $this->set(compact('priceLevelPerspective', 'perspectives', 'priceLevels'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Price Level Perspective id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $priceLevelPerspective = $this->PriceLevelPerspectives->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $priceLevelPerspective = $this->PriceLevelPerspectives->patchEntity($priceLevelPerspective, $this->request->getData());
            if ($this->PriceLevelPerspectives->save($priceLevelPerspective)) {
                $this->Flash->success(__('The price level perspective has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The price level perspective could not be saved. Please, try again.'));
        }
        $perspectives = $this->PriceLevelPerspectives->Perspectives->find('list', ['limit' => 200]);
        $priceLevels = $this->PriceLevelPerspectives->PriceLevels->find('list', ['limit' => 200]);
        $this->set(compact('priceLevelPerspective', 'perspectives', 'priceLevels'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Price Level Perspective id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $priceLevelPerspective = $this->PriceLevelPerspectives->get($id);
        if ($this->PriceLevelPerspectives->delete($priceLevelPerspective)) {
            $this->Flash->success(__('The price level perspective has been deleted.'));
        } else {
            $this->Flash->error(__('The price level perspective could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
