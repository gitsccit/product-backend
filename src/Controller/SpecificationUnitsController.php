<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * SpecificationUnits Controller
 *
 * @property \ProductBackend\Model\Table\SpecificationUnitsTable $SpecificationUnits
 * @method \ProductBackend\Model\Entity\SpecificationUnit[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SpecificationUnitsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['SpecificationUnitGroups'],
        ];
        $specificationUnits = $this->paginate($this->SpecificationUnits);

        $this->set(compact('specificationUnits'));
    }

    /**
     * View method
     *
     * @param string|null $id Specification Unit id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $specificationUnit = $this->SpecificationUnits->get($id, contain: ['SpecificationUnitGroups', 'Specifications']);

        $this->set(compact('specificationUnit'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $specificationUnit = $this->SpecificationUnits->newEmptyEntity();
        if ($this->request->is('post')) {
            $specificationUnit = $this->SpecificationUnits->patchEntity($specificationUnit, $this->request->getData());
            if ($this->SpecificationUnits->save($specificationUnit)) {
                $this->Flash->success(__('The specification unit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The specification unit could not be saved. Please, try again.'));
        }
        $specificationUnitGroups = $this->SpecificationUnits->SpecificationUnitGroups->find('list', ['limit' => 200]);
        $this->set(compact('specificationUnit', 'specificationUnitGroups'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Specification Unit id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $specificationUnit = $this->SpecificationUnits->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $specificationUnit = $this->SpecificationUnits->patchEntity($specificationUnit, $this->request->getData());
            if ($this->SpecificationUnits->save($specificationUnit)) {
                $this->Flash->success(__('The specification unit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The specification unit could not be saved. Please, try again.'));
        }
        $specificationUnitGroups = $this->SpecificationUnits->SpecificationUnitGroups->find('list', ['limit' => 200]);
        $this->set(compact('specificationUnit', 'specificationUnitGroups'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Specification Unit id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $specificationUnit = $this->SpecificationUnits->get($id);
        if ($this->SpecificationUnits->delete($specificationUnit)) {
            $this->Flash->success(__('The specification unit has been deleted.'));
        } else {
            $this->Flash->error(__('The specification unit could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
