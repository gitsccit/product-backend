<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * SystemRuleDetails Controller
 *
 * @property \ProductBackend\Model\Table\SystemRuleDetailsTable $SystemRuleDetails
 * @method \ProductBackend\Model\Entity\SystemRuleDetail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SystemRuleDetailsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['SystemRules', 'Buckets', 'GroupItems'],
        ];
        $systemRuleDetails = $this->paginate($this->SystemRuleDetails);

        $this->set(compact('systemRuleDetails'));
    }

    /**
     * View method
     *
     * @param string|null $id System Rule Detail id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $systemRuleDetail = $this->SystemRuleDetails->get($id, [
            'contain' => ['SystemRules', 'Buckets', 'GroupItems'],
        ]);

        $this->set(compact('systemRuleDetail'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $systemRuleDetail = $this->SystemRuleDetails->newEmptyEntity();
        if ($this->request->is('post')) {
            $systemRuleDetail = $this->SystemRuleDetails->patchEntity($systemRuleDetail, $this->request->getData());
            if ($this->SystemRuleDetails->save($systemRuleDetail)) {
                $this->Flash->success(__('The system rule detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The system rule detail could not be saved. Please, try again.'));
        }
        $systemRules = $this->SystemRuleDetails->SystemRules->find('list', ['limit' => 200]);
        $buckets = $this->SystemRuleDetails->Buckets->find('list', ['limit' => 200]);
        $groupItems = $this->SystemRuleDetails->GroupItems->find('list', ['limit' => 200]);
        $this->set(compact('systemRuleDetail', 'systemRules', 'buckets', 'groupItems'));
    }

    /**
     * Edit method
     *
     * @param string|null $id System Rule Detail id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $systemRuleDetail = $this->SystemRuleDetails->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $systemRuleDetail = $this->SystemRuleDetails->patchEntity($systemRuleDetail, $this->request->getData());
            if ($this->SystemRuleDetails->save($systemRuleDetail)) {
                $this->Flash->success(__('The system rule detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The system rule detail could not be saved. Please, try again.'));
        }
        $systemRules = $this->SystemRuleDetails->SystemRules->find('list', ['limit' => 200]);
        $buckets = $this->SystemRuleDetails->Buckets->find('list', ['limit' => 200]);
        $groupItems = $this->SystemRuleDetails->GroupItems->find('list', ['limit' => 200]);
        $this->set(compact('systemRuleDetail', 'systemRules', 'buckets', 'groupItems'));
    }

    /**
     * Delete method
     *
     * @param string|null $id System Rule Detail id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $systemRuleDetail = $this->SystemRuleDetails->get($id);
        if ($this->SystemRuleDetails->delete($systemRuleDetail)) {
            $this->Flash->success(__('The system rule detail has been deleted.'));
        } else {
            $this->Flash->error(__('The system rule detail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
