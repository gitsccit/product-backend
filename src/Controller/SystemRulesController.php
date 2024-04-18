<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * SystemRules Controller
 *
 * @property \ProductBackend\Model\Table\SystemRulesTable $SystemRules
 * @method \ProductBackend\Model\Entity\SystemRule[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SystemRulesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Systems'],
        ];
        $systemRules = $this->paginate($this->SystemRules);

        $this->set(compact('systemRules'));
    }

    /**
     * View method
     *
     * @param string|null $id System Rule id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $systemRule = $this->SystemRules->get($id, [
            'contain' => ['Systems', 'SystemRuleDetails'],
        ]);

        $this->set(compact('systemRule'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $systemRule = $this->SystemRules->newEmptyEntity();
        if ($this->request->is('post')) {
            $systemRule = $this->SystemRules->patchEntity($systemRule, $this->request->getData());
            if ($this->SystemRules->save($systemRule)) {
                $this->Flash->success(__('The system rule has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The system rule could not be saved. Please, try again.'));
        }
        $systems = $this->SystemRules->Systems->find(limit: 200)->all()->toList();
        $this->set(compact('systemRule', 'systems'));
    }

    /**
     * Edit method
     *
     * @param string|null $id System Rule id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $systemRule = $this->SystemRules->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $systemRule = $this->SystemRules->patchEntity($systemRule, $this->request->getData());
            if ($this->SystemRules->save($systemRule)) {
                $this->Flash->success(__('The system rule has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The system rule could not be saved. Please, try again.'));
        }
        $systems = $this->SystemRules->Systems->find(limit: 200)->all()->toList();
        $this->set(compact('systemRule', 'systems'));
    }

    /**
     * Delete method
     *
     * @param string|null $id System Rule id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $systemRule = $this->SystemRules->get($id);
        if ($this->SystemRules->delete($systemRule)) {
            $this->Flash->success(__('The system rule has been deleted.'));
        } else {
            $this->Flash->error(__('The system rule could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
