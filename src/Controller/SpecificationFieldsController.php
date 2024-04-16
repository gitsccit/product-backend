<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * SpecificationFields Controller
 *
 * @property \ProductBackend\Model\Table\SpecificationFieldsTable $SpecificationFields
 * @method \ProductBackend\Model\Entity\SpecificationField[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SpecificationFieldsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['SpecificationGroups', 'SpecificationUnitGroups'],
        ];
        $specificationFields = $this->paginate($this->SpecificationFields);

        $this->set(compact('specificationFields'));
    }

    /**
     * View method
     *
     * @param string|null $id Specification Field id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $specificationField = $this->SpecificationFields->get($id, contain: ['SpecificationGroups', 'SpecificationUnitGroups', 'Specifications']);

        $this->set(compact('specificationField'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $specificationField = $this->SpecificationFields->newEmptyEntity();
        if ($this->request->is('post')) {
            $specificationField = $this->SpecificationFields->patchEntity($specificationField, $this->request->getData());
            if ($this->SpecificationFields->save($specificationField)) {
                $this->Flash->success(__('The specification field has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The specification field could not be saved. Please, try again.'));
        }
        $specificationGroups = $this->SpecificationFields->SpecificationGroups->find('list', ['limit' => 200]);
        $specificationUnitGroups = $this->SpecificationFields->SpecificationUnitGroups->find('list', ['limit' => 200]);
        $this->set(compact('specificationField', 'specificationGroups', 'specificationUnitGroups'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Specification Field id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $specificationField = $this->SpecificationFields->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $specificationField = $this->SpecificationFields->patchEntity($specificationField, $this->request->getData());
            if ($this->SpecificationFields->save($specificationField)) {
                $this->Flash->success(__('The specification field has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The specification field could not be saved. Please, try again.'));
        }
        $specificationGroups = $this->SpecificationFields->SpecificationGroups->find('list', ['limit' => 200]);
        $specificationUnitGroups = $this->SpecificationFields->SpecificationUnitGroups->find('list', ['limit' => 200]);
        $this->set(compact('specificationField', 'specificationGroups', 'specificationUnitGroups'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Specification Field id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $specificationField = $this->SpecificationFields->get($id);
        if ($this->SpecificationFields->delete($specificationField)) {
            $this->Flash->success(__('The specification field has been deleted.'));
        } else {
            $this->Flash->error(__('The specification field could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
