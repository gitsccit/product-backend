<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * PriceLevels Controller
 *
 * @property \ProductBackend\Model\Table\PriceLevelsTable $PriceLevels
 * @method \ProductBackend\Model\Entity\PriceLevel[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PriceLevelsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $priceLevels = $this->paginate($this->PriceLevels);

        $this->set(compact('priceLevels'));
    }

    /**
     * View method
     *
     * @param string|null $id Price Level id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $priceLevel = $this->PriceLevels->get($id, [
            'contain' => ['PriceLevelPerspectives', 'ProductPriceLevels', 'SystemPriceLevels'],
        ]);

        $this->set(compact('priceLevel'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $priceLevel = $this->PriceLevels->newEmptyEntity();
        if ($this->request->is('post')) {
            $priceLevel = $this->PriceLevels->patchEntity($priceLevel, $this->request->getData());
            if ($this->PriceLevels->save($priceLevel)) {
                $this->Flash->success(__('The price level has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The price level could not be saved. Please, try again.'));
        }
        $this->set(compact('priceLevel'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Price Level id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $priceLevel = $this->PriceLevels->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $priceLevel = $this->PriceLevels->patchEntity($priceLevel, $this->request->getData());
            if ($this->PriceLevels->save($priceLevel)) {
                $this->Flash->success(__('The price level has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The price level could not be saved. Please, try again.'));
        }
        $this->set(compact('priceLevel'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Price Level id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $priceLevel = $this->PriceLevels->get($id);
        if ($this->PriceLevels->delete($priceLevel)) {
            $this->Flash->success(__('The price level has been deleted.'));
        } else {
            $this->Flash->error(__('The price level could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
