<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * SpareCategoryRelations Controller
 *
 * @property \ProductBackend\Model\Table\SpareCategoryRelationsTable $SpareCategoryRelations
 * @method \ProductBackend\Model\Entity\SpareCategoryRelation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SpareCategoryRelationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['SpareCategories', 'ProductCategories'],
        ];
        $spareCategoryRelations = $this->paginate($this->SpareCategoryRelations);

        $this->set(compact('spareCategoryRelations'));
    }

    /**
     * View method
     *
     * @param string|null $id Spare Category Relation id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $spareCategoryRelation = $this->SpareCategoryRelations->get($id, contain: ['SpareCategories', 'ProductCategories']);

        $this->set(compact('spareCategoryRelation'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $spareCategoryRelation = $this->SpareCategoryRelations->newEmptyEntity();
        if ($this->request->is('post')) {
            $spareCategoryRelation = $this->SpareCategoryRelations->patchEntity($spareCategoryRelation, $this->request->getData());
            if ($this->SpareCategoryRelations->save($spareCategoryRelation)) {
                $this->Flash->success(__('The spare category relation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The spare category relation could not be saved. Please, try again.'));
        }
        $spareCategories = $this->SpareCategoryRelations->SpareCategories->find('list', ['limit' => 200]);
        $productCategories = $this->SpareCategoryRelations->ProductCategories->find('list', ['limit' => 200]);
        $this->set(compact('spareCategoryRelation', 'spareCategories', 'productCategories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Spare Category Relation id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $spareCategoryRelation = $this->SpareCategoryRelations->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $spareCategoryRelation = $this->SpareCategoryRelations->patchEntity($spareCategoryRelation, $this->request->getData());
            if ($this->SpareCategoryRelations->save($spareCategoryRelation)) {
                $this->Flash->success(__('The spare category relation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The spare category relation could not be saved. Please, try again.'));
        }
        $spareCategories = $this->SpareCategoryRelations->SpareCategories->find('list', ['limit' => 200]);
        $productCategories = $this->SpareCategoryRelations->ProductCategories->find('list', ['limit' => 200]);
        $this->set(compact('spareCategoryRelation', 'spareCategories', 'productCategories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Spare Category Relation id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $spareCategoryRelation = $this->SpareCategoryRelations->get($id);
        if ($this->SpareCategoryRelations->delete($spareCategoryRelation)) {
            $this->Flash->success(__('The spare category relation has been deleted.'));
        } else {
            $this->Flash->error(__('The spare category relation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
