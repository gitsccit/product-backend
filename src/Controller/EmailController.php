<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * Email Controller
 *
 * @method \App\Model\Entity\Email[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmailController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
    }

    public function product()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();
        }
    }

    public function configuration()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();
        }
    }
}
