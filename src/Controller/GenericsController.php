<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * Generics Controller
 *
 * @property \ProductBackend\Model\Table\GenericsTable $Generics
 * @method \ProductBackend\Model\Entity\Generic[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GenericsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $generics = $this->paginate($this->Generics);

        $this->set(compact('generics'));
    }

    /**
     * View method
     *
     * @param string|null $id Generic id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $generic = $this->Generics->get($id, contain: ['Products']);

        $this->set(compact('generic'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $generic = $this->Generics->newEmptyEntity();
        if ($this->request->is('post')) {
            $generic = $this->Generics->patchEntity($generic, $this->request->getData());
            if ($this->Generics->save($generic)) {
                $this->Flash->success(__('The generic has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The generic could not be saved. Please, try again.'));
        }
        $products = $this->Generics->Products->find('list', ['limit' => 200]);
        $this->set(compact('generic', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Generic id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $generic = $this->Generics->get($id, contain: ['Products']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $generic = $this->Generics->patchEntity($generic, $this->request->getData());
            if ($this->Generics->save($generic)) {
                $this->Flash->success(__('The generic has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The generic could not be saved. Please, try again.'));
        }
        $products = $this->Generics->Products->find('list', ['limit' => 200]);
        $this->set(compact('generic', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Generic id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $generic = $this->Generics->get($id);
        if ($this->Generics->delete($generic)) {
            $this->Flash->success(__('The generic has been deleted.'));
        } else {
            $this->Flash->error(__('The generic could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
