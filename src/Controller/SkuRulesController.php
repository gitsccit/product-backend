<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * SkuRules Controller
 *
 * @property \ProductBackend\Model\Table\SkuRulesTable $SkuRules
 * @method \ProductBackend\Model\Entity\SkuRule[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SkuRulesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['SkuRuleCategories'],
        ];
        $skuRules = $this->paginate($this->SkuRules);

        $this->set(compact('skuRules'));
    }

    /**
     * View method
     *
     * @param string|null $id Sku Rule id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $skuRule = $this->SkuRules->get($id, contain: ['SkuRuleCategories', 'SkuRuleGroups', 'SkuRuleAdditionalSkus', 'SkuRulesFiles']);

        $this->set(compact('skuRule'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $skuRule = $this->SkuRules->newEmptyEntity();
        if ($this->request->is('post')) {
            $skuRule = $this->SkuRules->patchEntity($skuRule, $this->request->getData());
            if ($this->SkuRules->save($skuRule)) {
                $this->Flash->success(__('The sku rule has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sku rule could not be saved. Please, try again.'));
        }
        $skuRuleCategories = $this->SkuRules->SkuRuleCategories->find('list', ['limit' => 200]);
        $this->set(compact('skuRule', 'skuRuleCategories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Sku Rule id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $skuRule = $this->SkuRules->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $skuRule = $this->SkuRules->patchEntity($skuRule, $this->request->getData());
            if ($this->SkuRules->save($skuRule)) {
                $this->Flash->success(__('The sku rule has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sku rule could not be saved. Please, try again.'));
        }
        $skuRuleCategories = $this->SkuRules->SkuRuleCategories->find('list', ['limit' => 200]);
        $this->set(compact('skuRule', 'skuRuleCategories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Sku Rule id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $skuRule = $this->SkuRules->get($id);
        if ($this->SkuRules->delete($skuRule)) {
            $this->Flash->success(__('The sku rule has been deleted.'));
        } else {
            $this->Flash->error(__('The sku rule could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
