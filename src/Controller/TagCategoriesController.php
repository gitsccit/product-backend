<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * TagCategories Controller
 *
 * @property \ProductBackend\Model\Table\TagCategoriesTable $TagCategories
 * @method \ProductBackend\Model\Entity\TagCategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TagCategoriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $tagCategories = $this->paginate($this->TagCategories);

        $this->set(compact('tagCategories'));
    }

    /**
     * View method
     *
     * @param string|null $id Tag Category id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tagCategory = $this->TagCategories->get($id, [
            'contain' => ['Tags'],
        ]);

        $this->set(compact('tagCategory'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tagCategory = $this->TagCategories->newEmptyEntity();
        if ($this->request->is('post')) {
            $tagCategory = $this->TagCategories->patchEntity($tagCategory, $this->request->getData());
            if ($this->TagCategories->save($tagCategory)) {
                $this->Flash->success(__('The tag category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tag category could not be saved. Please, try again.'));
        }
        $this->set(compact('tagCategory'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tag Category id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tagCategory = $this->TagCategories->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tagCategory = $this->TagCategories->patchEntity($tagCategory, $this->request->getData());
            if ($this->TagCategories->save($tagCategory)) {
                $this->Flash->success(__('The tag category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tag category could not be saved. Please, try again.'));
        }
        $this->set(compact('tagCategory'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tag Category id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tagCategory = $this->TagCategories->get($id);
        if ($this->TagCategories->delete($tagCategory)) {
            $this->Flash->success(__('The tag category has been deleted.'));
        } else {
            $this->Flash->error(__('The tag category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
