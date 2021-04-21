<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * SystemPriceLevels Controller
 *
 * @property \ProductBackend\Model\Table\SystemPriceLevelsTable $SystemPriceLevels
 * @method \ProductBackend\Model\Entity\SystemPriceLevel[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SystemPriceLevelsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['PriceLevels', 'Systems'],
        ];
        $systemPriceLevels = $this->paginate($this->SystemPriceLevels);

        $this->set(compact('systemPriceLevels'));
    }

    /**
     * View method
     *
     * @param string|null $id System Price Level id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $systemPriceLevel = $this->SystemPriceLevels->get($id, [
            'contain' => ['PriceLevels', 'Systems'],
        ]);

        $this->set(compact('systemPriceLevel'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $systemPriceLevel = $this->SystemPriceLevels->newEmptyEntity();
        if ($this->request->is('post')) {
            $systemPriceLevel = $this->SystemPriceLevels->patchEntity($systemPriceLevel, $this->request->getData());
            if ($this->SystemPriceLevels->save($systemPriceLevel)) {
                $this->Flash->success(__('The system price level has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The system price level could not be saved. Please, try again.'));
        }
        $priceLevels = $this->SystemPriceLevels->PriceLevels->find('list', ['limit' => 200]);
        $systems = $this->SystemPriceLevels->Systems->find('list', ['limit' => 200]);
        $this->set(compact('systemPriceLevel', 'priceLevels', 'systems'));
    }

    /**
     * Edit method
     *
     * @param string|null $id System Price Level id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $systemPriceLevel = $this->SystemPriceLevels->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $systemPriceLevel = $this->SystemPriceLevels->patchEntity($systemPriceLevel, $this->request->getData());
            if ($this->SystemPriceLevels->save($systemPriceLevel)) {
                $this->Flash->success(__('The system price level has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The system price level could not be saved. Please, try again.'));
        }
        $priceLevels = $this->SystemPriceLevels->PriceLevels->find('list', ['limit' => 200]);
        $systems = $this->SystemPriceLevels->Systems->find('list', ['limit' => 200]);
        $this->set(compact('systemPriceLevel', 'priceLevels', 'systems'));
    }

    /**
     * Delete method
     *
     * @param string|null $id System Price Level id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $systemPriceLevel = $this->SystemPriceLevels->get($id);
        if ($this->SystemPriceLevels->delete($systemPriceLevel)) {
            $this->Flash->success(__('The system price level has been deleted.'));
        } else {
            $this->Flash->error(__('The system price level could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
