<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * Specifications Controller
 *
 * @property \ProductBackend\Model\Table\SpecificationsTable $Specifications
 * @method \ProductBackend\Model\Entity\Specification[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SpecificationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Products', 'SpecificationFields', 'SpecificationUnits'],
        ];
        $specifications = $this->paginate($this->Specifications);

        $this->set(compact('specifications'));
    }

    /**
     * View method
     *
     * @param string|null $id Specification id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $specification = $this->Specifications->get($id, contain: ['Products', 'SpecificationFields', 'SpecificationUnits']);

        $this->set(compact('specification'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $specification = $this->Specifications->newEmptyEntity();
        if ($this->request->is('post')) {
            $specification = $this->Specifications->patchEntity($specification, $this->request->getData());
            if ($this->Specifications->save($specification)) {
                $this->Flash->success(__('The specification has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The specification could not be saved. Please, try again.'));
        }
        $products = $this->Specifications->Products->find('list', ['limit' => 200]);
        $specificationFields = $this->Specifications->SpecificationFields->find('list', ['limit' => 200]);
        $specificationUnits = $this->Specifications->SpecificationUnits->find('list', ['limit' => 200]);
        $this->set(compact('specification', 'products', 'specificationFields', 'specificationUnits'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Specification id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $specification = $this->Specifications->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $specification = $this->Specifications->patchEntity($specification, $this->request->getData());
            if ($this->Specifications->save($specification)) {
                $this->Flash->success(__('The specification has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The specification could not be saved. Please, try again.'));
        }
        $products = $this->Specifications->Products->find('list', ['limit' => 200]);
        $specificationFields = $this->Specifications->SpecificationFields->find('list', ['limit' => 200]);
        $specificationUnits = $this->Specifications->SpecificationUnits->find('list', ['limit' => 200]);
        $this->set(compact('specification', 'products', 'specificationFields', 'specificationUnits'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Specification id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $specification = $this->Specifications->get($id);
        if ($this->Specifications->delete($specification)) {
            $this->Flash->success(__('The specification has been deleted.'));
        } else {
            $this->Flash->error(__('The specification could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
