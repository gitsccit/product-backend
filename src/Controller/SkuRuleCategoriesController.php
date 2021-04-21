<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * SkuRuleCategories Controller
 *
 * @property \ProductBackend\Model\Table\SkuRuleCategoriesTable $SkuRuleCategories
 * @method \ProductBackend\Model\Entity\SkuRuleCategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SkuRuleCategoriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ParentSkuRuleCategories'],
        ];
        $skuRuleCategories = $this->paginate($this->SkuRuleCategories);

        $this->set(compact('skuRuleCategories'));
    }

    /**
     * View method
     *
     * @param string|null $id Sku Rule Category id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $skuRuleCategory = $this->SkuRuleCategories->get($id, [
            'contain' => ['ParentSkuRuleCategories', 'ChildSkuRuleCategories', 'SkuRules'],
        ]);

        $this->set(compact('skuRuleCategory'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $skuRuleCategory = $this->SkuRuleCategories->newEmptyEntity();
        if ($this->request->is('post')) {
            $skuRuleCategory = $this->SkuRuleCategories->patchEntity($skuRuleCategory, $this->request->getData());
            if ($this->SkuRuleCategories->save($skuRuleCategory)) {
                $this->Flash->success(__('The sku rule category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sku rule category could not be saved. Please, try again.'));
        }
        $parentSkuRuleCategories = $this->SkuRuleCategories->ParentSkuRuleCategories->find('list', ['limit' => 200]);
        $this->set(compact('skuRuleCategory', 'parentSkuRuleCategories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Sku Rule Category id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $skuRuleCategory = $this->SkuRuleCategories->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $skuRuleCategory = $this->SkuRuleCategories->patchEntity($skuRuleCategory, $this->request->getData());
            if ($this->SkuRuleCategories->save($skuRuleCategory)) {
                $this->Flash->success(__('The sku rule category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sku rule category could not be saved. Please, try again.'));
        }
        $parentSkuRuleCategories = $this->SkuRuleCategories->ParentSkuRuleCategories->find('list', ['limit' => 200]);
        $this->set(compact('skuRuleCategory', 'parentSkuRuleCategories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Sku Rule Category id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $skuRuleCategory = $this->SkuRuleCategories->get($id);
        if ($this->SkuRuleCategories->delete($skuRuleCategory)) {
            $this->Flash->success(__('The sku rule category has been deleted.'));
        } else {
            $this->Flash->error(__('The sku rule category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
