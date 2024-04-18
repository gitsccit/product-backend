<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * SkuRuleAdditionalSkus Controller
 *
 * @property \ProductBackend\Model\Table\SkuRuleAdditionalSkusTable $SkuRuleAdditionalSkus
 * @method \ProductBackend\Model\Entity\SkuRuleAdditionalSkus[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SkuRuleAdditionalSkusController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['SkuRules', 'SkuRuleGroups'],
        ];
        $skuRuleAdditionalSkus = $this->paginate($this->SkuRuleAdditionalSkus);

        $this->set(compact('skuRuleAdditionalSkus'));
    }

    /**
     * View method
     *
     * @param string|null $id Sku Rule Additional Skus id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $skuRuleAdditionalSkus = $this->SkuRuleAdditionalSkus->get($id, contain: ['SkuRules', 'SkuRuleGroups']);

        $this->set(compact('skuRuleAdditionalSkus'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $skuRuleAdditionalSkus = $this->SkuRuleAdditionalSkus->newEmptyEntity();
        if ($this->request->is('post')) {
            $skuRuleAdditionalSkus = $this->SkuRuleAdditionalSkus->patchEntity($skuRuleAdditionalSkus, $this->request->getData());
            if ($this->SkuRuleAdditionalSkus->save($skuRuleAdditionalSkus)) {
                $this->Flash->success(__('The sku rule additional skus has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sku rule additional skus could not be saved. Please, try again.'));
        }
        $skuRules = $this->SkuRuleAdditionalSkus->SkuRules->find(limit: 200)->all()->toList();
        $skuRuleGroups = $this->SkuRuleAdditionalSkus->SkuRuleGroups->find(limit: 200)->all()->toList();
        $this->set(compact('skuRuleAdditionalSkus', 'skuRules', 'skuRuleGroups'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Sku Rule Additional Skus id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $skuRuleAdditionalSkus = $this->SkuRuleAdditionalSkus->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $skuRuleAdditionalSkus = $this->SkuRuleAdditionalSkus->patchEntity($skuRuleAdditionalSkus, $this->request->getData());
            if ($this->SkuRuleAdditionalSkus->save($skuRuleAdditionalSkus)) {
                $this->Flash->success(__('The sku rule additional skus has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sku rule additional skus could not be saved. Please, try again.'));
        }
        $skuRules = $this->SkuRuleAdditionalSkus->SkuRules->find(limit: 200)->all()->toList();
        $skuRuleGroups = $this->SkuRuleAdditionalSkus->SkuRuleGroups->find(limit: 200)->all()->toList();
        $this->set(compact('skuRuleAdditionalSkus', 'skuRules', 'skuRuleGroups'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Sku Rule Additional Skus id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $skuRuleAdditionalSkus = $this->SkuRuleAdditionalSkus->get($id);
        if ($this->SkuRuleAdditionalSkus->delete($skuRuleAdditionalSkus)) {
            $this->Flash->success(__('The sku rule additional skus has been deleted.'));
        } else {
            $this->Flash->error(__('The sku rule additional skus could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
