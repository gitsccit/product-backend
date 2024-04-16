<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * SkuRulesFiles Controller
 *
 * @property \ProductBackend\Model\Table\SkuRulesFilesTable $SkuRulesFiles
 * @method \ProductBackend\Model\Entity\SkuRulesFile[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SkuRulesFilesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['SkuRules', 'Files'],
        ];
        $skuRulesFiles = $this->paginate($this->SkuRulesFiles);

        $this->set(compact('skuRulesFiles'));
    }

    /**
     * View method
     *
     * @param string|null $id Sku Rules File id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $skuRulesFile = $this->SkuRulesFiles->get($id, contain: ['SkuRules', 'Files']);

        $this->set(compact('skuRulesFile'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $skuRulesFile = $this->SkuRulesFiles->newEmptyEntity();
        if ($this->request->is('post')) {
            $skuRulesFile = $this->SkuRulesFiles->patchEntity($skuRulesFile, $this->request->getData());
            if ($this->SkuRulesFiles->save($skuRulesFile)) {
                $this->Flash->success(__('The sku rules file has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sku rules file could not be saved. Please, try again.'));
        }
        $skuRules = $this->SkuRulesFiles->SkuRules->find('list', ['limit' => 200]);
        $files = $this->SkuRulesFiles->Files->find('list', ['limit' => 200]);
        $this->set(compact('skuRulesFile', 'skuRules', 'files'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Sku Rules File id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $skuRulesFile = $this->SkuRulesFiles->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $skuRulesFile = $this->SkuRulesFiles->patchEntity($skuRulesFile, $this->request->getData());
            if ($this->SkuRulesFiles->save($skuRulesFile)) {
                $this->Flash->success(__('The sku rules file has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sku rules file could not be saved. Please, try again.'));
        }
        $skuRules = $this->SkuRulesFiles->SkuRules->find('list', ['limit' => 200]);
        $files = $this->SkuRulesFiles->Files->find('list', ['limit' => 200]);
        $this->set(compact('skuRulesFile', 'skuRules', 'files'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Sku Rules File id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $skuRulesFile = $this->SkuRulesFiles->get($id);
        if ($this->SkuRulesFiles->delete($skuRulesFile)) {
            $this->Flash->success(__('The sku rules file has been deleted.'));
        } else {
            $this->Flash->error(__('The sku rules file could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
