<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * SpecificationUnitGroups Controller
 *
 * @property \ProductBackend\Model\Table\SpecificationUnitGroupsTable $SpecificationUnitGroups
 * @method \ProductBackend\Model\Entity\SpecificationUnitGroup[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SpecificationUnitGroupsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $specificationUnitGroups = $this->paginate($this->SpecificationUnitGroups);

        $this->set(compact('specificationUnitGroups'));
    }

    /**
     * View method
     *
     * @param string|null $id Specification Unit Group id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $specificationUnitGroup = $this->SpecificationUnitGroups->get($id, contain: ['SpecificationFields', 'SpecificationUnits']);

        $this->set(compact('specificationUnitGroup'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $specificationUnitGroup = $this->SpecificationUnitGroups->newEmptyEntity();
        if ($this->request->is('post')) {
            $specificationUnitGroup = $this->SpecificationUnitGroups->patchEntity($specificationUnitGroup, $this->request->getData());
            if ($this->SpecificationUnitGroups->save($specificationUnitGroup)) {
                $this->Flash->success(__('The specification unit group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The specification unit group could not be saved. Please, try again.'));
        }
        $this->set(compact('specificationUnitGroup'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Specification Unit Group id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $specificationUnitGroup = $this->SpecificationUnitGroups->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $specificationUnitGroup = $this->SpecificationUnitGroups->patchEntity($specificationUnitGroup, $this->request->getData());
            if ($this->SpecificationUnitGroups->save($specificationUnitGroup)) {
                $this->Flash->success(__('The specification unit group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The specification unit group could not be saved. Please, try again.'));
        }
        $this->set(compact('specificationUnitGroup'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Specification Unit Group id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $specificationUnitGroup = $this->SpecificationUnitGroups->get($id);
        if ($this->SpecificationUnitGroups->delete($specificationUnitGroup)) {
            $this->Flash->success(__('The specification unit group has been deleted.'));
        } else {
            $this->Flash->error(__('The specification unit group could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
