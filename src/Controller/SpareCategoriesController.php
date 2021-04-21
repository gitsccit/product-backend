<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * SpareCategories Controller
 *
 * @property \ProductBackend\Model\Table\SpareCategoriesTable $SpareCategories
 * @method \ProductBackend\Model\Entity\SpareCategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SpareCategoriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $spareCategories = $this->paginate($this->SpareCategories);

        $this->set(compact('spareCategories'));
    }

    /**
     * View method
     *
     * @param string|null $id Spare Category id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $spareCategory = $this->SpareCategories->get($id, [
            'contain' => ['SpareCategoryRelations', 'Spares'],
        ]);

        $this->set(compact('spareCategory'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $spareCategory = $this->SpareCategories->newEmptyEntity();
        if ($this->request->is('post')) {
            $spareCategory = $this->SpareCategories->patchEntity($spareCategory, $this->request->getData());
            if ($this->SpareCategories->save($spareCategory)) {
                $this->Flash->success(__('The spare category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The spare category could not be saved. Please, try again.'));
        }
        $this->set(compact('spareCategory'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Spare Category id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $spareCategory = $this->SpareCategories->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $spareCategory = $this->SpareCategories->patchEntity($spareCategory, $this->request->getData());
            if ($this->SpareCategories->save($spareCategory)) {
                $this->Flash->success(__('The spare category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The spare category could not be saved. Please, try again.'));
        }
        $this->set(compact('spareCategory'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Spare Category id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $spareCategory = $this->SpareCategories->get($id);
        if ($this->SpareCategories->delete($spareCategory)) {
            $this->Flash->success(__('The spare category has been deleted.'));
        } else {
            $this->Flash->error(__('The spare category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
