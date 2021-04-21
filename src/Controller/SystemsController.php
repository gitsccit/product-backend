<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

use Cake\Datasource\FactoryLocator;
use Cake\Event\EventInterface;
use Cake\Http\Exception\NotFoundException;
use Cake\I18n\Number;

/**
 * Systems Controller
 *
 * @property \ProductBackend\Model\Table\SystemsTable $Systems
 * @method \ProductBackend\Model\Entity\System[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SystemsController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Authentication->addUnauthenticatedActions(['validate']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Kits', 'SystemCategories'],
        ];
        $systems = $this->paginate($this->Systems);

        $this->set(compact('systems'));
    }

    /**
     * View method
     *
     * @param string $url System url
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(string $url)
    {
        $url = str_replace(' ', '+', $url);

        $system = $this->Systems
            ->find('details')
            ->where([
                'IFNULL(SystemPerspectives.url, Systems.url) =' => $url,
            ])
            ->first();

        if (is_null($system)) {
            throw new NotFoundException();
        }

        $breadcrumbs = $system->getBreadcrumbs();
        $tabs = FactoryLocator::get('Table')->get('ProductBackend.Tabs')->find()->order('sort')->toArray();

        $this->set(compact('system', 'tabs', 'breadcrumbs'));

        $layout = $this->request->getSession()->read('options.store.layout.system');
        $this->viewBuilder()->setTemplate("view_$layout");
    }

    public function validate()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $kitID = $data['kit'];
            $configuration = $data['configuration'];
            $quantity = $data['quantity'] ?? 1;

            $errors = $this->Systems->Kits->validateBucketItems($kitID, $configuration);
            [$kitRuleWarnings, $kitRuleErrors] = $this->Systems->Kits->validateKitRules($kitID, $configuration);
            [$productRuleWarnings, $productRuleErrors] = $this->Systems->Kits->validateProductRules($kitID,
                $configuration);
//            [$productRuleWarnings, $productRuleErrors] = $this->Systems->Kits->validateGlobalSpecRules($kitID, $configuration);
            [, $additionalPrice, $additionalItems] = $this->Systems->Kits->validateSkuRules($configuration);
            [, $price] = $this->Systems->getConfigurationCostAndPrice($data['system'], $configuration);
            $warnings = array_merge($kitRuleWarnings, $productRuleWarnings);
            $errors = array_merge($errors, $kitRuleErrors, $productRuleErrors);
            $price = Number::currency(($price + $additionalPrice) * $quantity);

            $result = compact('price', 'warnings', 'errors', 'additionalItems');

            return $this->response->withStringBody(json_encode($result))->withType('application/json');
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $system = $this->Systems->newEmptyEntity();
        if ($this->request->is('post')) {
            $system = $this->Systems->patchEntity($system, $this->request->getData());
            if ($this->Systems->save($system)) {
                $this->Flash->success(__('The system has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The system could not be saved. Please, try again.'));
        }
        $kits = $this->Systems->Kits->find('list', ['limit' => 200]);
        $systemCategories = $this->Systems->SystemCategories->find('list', ['limit' => 200]);
        $this->set(compact('system', 'kits', 'systemCategories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id System id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $system = $this->Systems->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $system = $this->Systems->patchEntity($system, $this->request->getData());
            if ($this->Systems->save($system)) {
                $this->Flash->success(__('The system has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The system could not be saved. Please, try again.'));
        }
        $kits = $this->Systems->Kits->find('list', ['limit' => 200]);
        $systemCategories = $this->Systems->SystemCategories->find('list', ['limit' => 200]);
        $this->set(compact('system', 'kits', 'systemCategories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id System id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $system = $this->Systems->get($id);
        if ($this->Systems->delete($system)) {
            $this->Flash->success(__('The system has been deleted.'));
        } else {
            $this->Flash->error(__('The system could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
