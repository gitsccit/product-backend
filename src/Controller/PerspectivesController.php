<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * Perspectives Controller
 *
 * @property \ProductBackend\Model\Table\PerspectivesTable $Perspectives
 * @method \ProductBackend\Model\Entity\Perspective[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PerspectivesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $perspectives = $this->paginate($this->Perspectives);

        $this->set(compact('perspectives'));
    }

    /**
     * View method
     *
     * @param string|null $id Perspective id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $perspective = $this->Perspectives->get($id, contain: ['Customers', 'PriceLevelPerspectives', 'ProductCategoryPerspectives', 'ProductPerspectives', 'SystemCategoryPerspectives', 'SystemPerspectives']);

        $this->set(compact('perspective'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $perspective = $this->Perspectives->newEmptyEntity();
        if ($this->request->is('post')) {
            $perspective = $this->Perspectives->patchEntity($perspective, $this->request->getData());
            if ($this->Perspectives->save($perspective)) {
                $this->Flash->success(__('The perspective has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The perspective could not be saved. Please, try again.'));
        }
        $this->set(compact('perspective'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Perspective id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $perspective = $this->Perspectives->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $perspective = $this->Perspectives->patchEntity($perspective, $this->request->getData());
            if ($this->Perspectives->save($perspective)) {
                $this->Flash->success(__('The perspective has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The perspective could not be saved. Please, try again.'));
        }
        $this->set(compact('perspective'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Perspective id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $perspective = $this->Perspectives->get($id);
        if ($this->Perspectives->delete($perspective)) {
            $this->Flash->success(__('The perspective has been deleted.'));
        } else {
            $this->Flash->error(__('The perspective could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
