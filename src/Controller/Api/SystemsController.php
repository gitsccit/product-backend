<?php
declare(strict_types=1);

namespace ProductBackend\Controller\Api;

/**
 * Systems Controller
 *
 * @property \ProductBackend\Model\Table\SystemsTable $Systems
 * @method \ProductBackend\Model\Entity\System[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SystemsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $systems = $this->Systems->find('listing');

        if ($category = $this->request->getQuery('category', '')) {
            $systems = $systems->where(['Systems.system_category_id' => $category]);
        }

        $systems = $this->paginate($systems);

        $this->Crud->serialize(compact('systems'));
    }

    /**
     * View method
     *
     * @param string|null $id Environment id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(string $url)
    {
        $url = str_replace(' ', '+', $url);
        $systemUrl = $url;

        $system = $this->Systems->find('details')
            ->where(['IFNULL(SystemPerspectives.url, Systems.url) =' => $systemUrl])
            ->first();

        $this->Crud->serialize(compact('system'));
    }

    public function banner(string $url)
    {
        $url = str_replace(' ', '+', $url);
        $systemUrl = $url;

        $system = $this->Systems->find('banner')
            ->where(['IFNULL(SystemPerspectives.url, Systems.url) =' => $systemUrl])
            ->first();

        return $this->getResponse()->withStringBody(base64_decode($system['banner']))->withType('image/png');
    }
}
