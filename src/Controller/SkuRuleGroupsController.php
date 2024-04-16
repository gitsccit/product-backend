<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * SkuRuleGroups Controller
 *
 * @property \ProductBackend\Model\Table\SkuRuleGroupsTable $SkuRuleGroups
 * @method \ProductBackend\Model\Entity\SkuRuleGroup[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SkuRuleGroupsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Specs'],
        ];
        $skuRuleGroups = $this->paginate($this->SkuRuleGroups);

        $this->set(compact('skuRuleGroups'));
    }

    /**
     * View method
     *
     * @param string|null $id Sku Rule Group id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $skuRuleGroup = $this->SkuRuleGroups->get($id, contain: ['Specs', 'SkuRules', 'SkuRuleAdditionalSkus', 'SkuRuleGroupSkus']);

        $this->set(compact('skuRuleGroup'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $skuRuleGroup = $this->SkuRuleGroups->newEmptyEntity();
        if ($this->request->is('post')) {
            $skuRuleGroup = $this->SkuRuleGroups->patchEntity($skuRuleGroup, $this->request->getData());
            if ($this->SkuRuleGroups->save($skuRuleGroup)) {
                $this->Flash->success(__('The sku rule group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sku rule group could not be saved. Please, try again.'));
        }
        $specs = $this->SkuRuleGroups->Specs->find('list', ['limit' => 200]);
        $this->set(compact('skuRuleGroup', 'specs'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Sku Rule Group id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $skuRuleGroup = $this->SkuRuleGroups->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $skuRuleGroup = $this->SkuRuleGroups->patchEntity($skuRuleGroup, $this->request->getData());
            if ($this->SkuRuleGroups->save($skuRuleGroup)) {
                $this->Flash->success(__('The sku rule group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sku rule group could not be saved. Please, try again.'));
        }
        $specs = $this->SkuRuleGroups->Specs->find('list', ['limit' => 200]);
        $this->set(compact('skuRuleGroup', 'specs'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Sku Rule Group id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $skuRuleGroup = $this->SkuRuleGroups->get($id);
        if ($this->SkuRuleGroups->delete($skuRuleGroup)) {
            $this->Flash->success(__('The sku rule group has been deleted.'));
        } else {
            $this->Flash->error(__('The sku rule group could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
