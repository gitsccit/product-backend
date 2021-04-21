<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * SpecificationGroups Controller
 *
 * @property \ProductBackend\Model\Table\SpecificationGroupsTable $SpecificationGroups
 * @method \ProductBackend\Model\Entity\SpecificationGroup[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SpecificationGroupsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $specificationGroups = $this->paginate($this->SpecificationGroups);

        $this->set(compact('specificationGroups'));
    }

    /**
     * View method
     *
     * @param string|null $id Specification Group id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $specificationGroup = $this->SpecificationGroups->get($id, [
            'contain' => ['SpecificationFields'],
        ]);

        $this->set(compact('specificationGroup'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $specificationGroup = $this->SpecificationGroups->newEmptyEntity();
        if ($this->request->is('post')) {
            $specificationGroup = $this->SpecificationGroups->patchEntity($specificationGroup, $this->request->getData());
            if ($this->SpecificationGroups->save($specificationGroup)) {
                $this->Flash->success(__('The specification group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The specification group could not be saved. Please, try again.'));
        }
        $this->set(compact('specificationGroup'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Specification Group id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $specificationGroup = $this->SpecificationGroups->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $specificationGroup = $this->SpecificationGroups->patchEntity($specificationGroup, $this->request->getData());
            if ($this->SpecificationGroups->save($specificationGroup)) {
                $this->Flash->success(__('The specification group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The specification group could not be saved. Please, try again.'));
        }
        $this->set(compact('specificationGroup'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Specification Group id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $specificationGroup = $this->SpecificationGroups->get($id);
        if ($this->SpecificationGroups->delete($specificationGroup)) {
            $this->Flash->success(__('The specification group has been deleted.'));
        } else {
            $this->Flash->error(__('The specification group could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
