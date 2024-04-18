<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * SkuRuleGroupSkus Controller
 *
 * @property \ProductBackend\Model\Table\SkuRuleGroupSkusTable $SkuRuleGroupSkus
 * @method \ProductBackend\Model\Entity\SkuRuleGroupSkus[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SkuRuleGroupSkusController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['SkuRuleGroups'],
        ];
        $skuRuleGroupSkus = $this->paginate($this->SkuRuleGroupSkus);

        $this->set(compact('skuRuleGroupSkus'));
    }

    /**
     * View method
     *
     * @param string|null $id Sku Rule Group Skus id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $skuRuleGroupSkus = $this->SkuRuleGroupSkus->get($id, contain: ['SkuRuleGroups']);

        $this->set(compact('skuRuleGroupSkus'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $skuRuleGroupSkus = $this->SkuRuleGroupSkus->newEmptyEntity();
        if ($this->request->is('post')) {
            $skuRuleGroupSkus = $this->SkuRuleGroupSkus->patchEntity($skuRuleGroupSkus, $this->request->getData());
            if ($this->SkuRuleGroupSkus->save($skuRuleGroupSkus)) {
                $this->Flash->success(__('The sku rule group skus has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sku rule group skus could not be saved. Please, try again.'));
        }
        $skuRuleGroups = $this->SkuRuleGroupSkus->SkuRuleGroups->find(limit: 200)->all()->toList();
        $this->set(compact('skuRuleGroupSkus', 'skuRuleGroups'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Sku Rule Group Skus id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $skuRuleGroupSkus = $this->SkuRuleGroupSkus->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $skuRuleGroupSkus = $this->SkuRuleGroupSkus->patchEntity($skuRuleGroupSkus, $this->request->getData());
            if ($this->SkuRuleGroupSkus->save($skuRuleGroupSkus)) {
                $this->Flash->success(__('The sku rule group skus has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sku rule group skus could not be saved. Please, try again.'));
        }
        $skuRuleGroups = $this->SkuRuleGroupSkus->SkuRuleGroups->find(limit: 200)->all()->toList();
        $this->set(compact('skuRuleGroupSkus', 'skuRuleGroups'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Sku Rule Group Skus id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $skuRuleGroupSkus = $this->SkuRuleGroupSkus->get($id);
        if ($this->SkuRuleGroupSkus->delete($skuRuleGroupSkus)) {
            $this->Flash->success(__('The sku rule group skus has been deleted.'));
        } else {
            $this->Flash->error(__('The sku rule group skus could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
