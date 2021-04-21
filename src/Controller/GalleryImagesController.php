<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * GalleryImages Controller
 *
 * @property \ProductBackend\Model\Table\GalleryImagesTable $GalleryImages
 * @method \ProductBackend\Model\Entity\GalleryImage[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GalleryImagesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Galleries', 'Files'],
        ];
        $galleryImages = $this->paginate($this->GalleryImages);

        $this->set(compact('galleryImages'));
    }

    /**
     * View method
     *
     * @param string|null $id Gallery Image id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $galleryImage = $this->GalleryImages->get($id, [
            'contain' => ['Galleries', 'Files'],
        ]);

        $this->set(compact('galleryImage'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $galleryImage = $this->GalleryImages->newEmptyEntity();
        if ($this->request->is('post')) {
            $galleryImage = $this->GalleryImages->patchEntity($galleryImage, $this->request->getData());
            if ($this->GalleryImages->save($galleryImage)) {
                $this->Flash->success(__('The gallery image has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The gallery image could not be saved. Please, try again.'));
        }
        $galleries = $this->GalleryImages->Galleries->find('list', ['limit' => 200]);
        $files = $this->GalleryImages->Files->find('list', ['limit' => 200]);
        $this->set(compact('galleryImage', 'galleries', 'files'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Gallery Image id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $galleryImage = $this->GalleryImages->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $galleryImage = $this->GalleryImages->patchEntity($galleryImage, $this->request->getData());
            if ($this->GalleryImages->save($galleryImage)) {
                $this->Flash->success(__('The gallery image has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The gallery image could not be saved. Please, try again.'));
        }
        $galleries = $this->GalleryImages->Galleries->find('list', ['limit' => 200]);
        $files = $this->GalleryImages->Files->find('list', ['limit' => 200]);
        $this->set(compact('galleryImage', 'galleries', 'files'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Gallery Image id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $galleryImage = $this->GalleryImages->get($id);
        if ($this->GalleryImages->delete($galleryImage)) {
            $this->Flash->success(__('The gallery image has been deleted.'));
        } else {
            $this->Flash->error(__('The gallery image could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
