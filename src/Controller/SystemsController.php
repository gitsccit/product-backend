<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

use Cake\Core\Configure;
use Cake\Datasource\FactoryLocator;
use Cake\Http\Client;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

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
    public function view(...$url)
    {
        [$url, $configID, $subKitUrl, $subKitConfigID] = array_pad(array_slice($url, -4), 4, null);
        $systemUrl = $subKitUrl ?? $url;
        $systemConfigID = $subKitConfigID ?? $configID;
        $systemUrl = str_replace(' ', '+', $systemUrl);

        $options = [];
        if ($priceLevel = $this->request->getQuery('priceLevel')) {
            $options['priceLevel'] = $priceLevel;
        }
        if ($warehouse = $this->request->getQuery('warehouse')) {
            $options['warehouse'] = $warehouse;
        }
        if ($systemConfigID) {
            $options['configID'] = $systemConfigID;
        }

        $system = $this->Systems
            ->find('details', $options)
            ->where([
                'IFNULL(SystemPerspectives.url, Systems.url) =' => $systemUrl,
            ])
            ->first();

        if (is_null($system)) {
            throw new NotFoundException();
        }

        $tabs = FactoryLocator::get('Table')->get('ProductBackend.Tabs')->find()->order('sort')->toArray();

        if (Configure::read('ProductBackend.showCost')) {
            $priceLevels = TableRegistry::getTableLocator()->get('ProductBackend.PriceLevels')
                ->find()
                ->select(['id', 'name'])
                ->innerJoinWith('PriceLevelPerspectives')
                ->where([
                    'PriceLevelPerspectives.perspective_id' => $this->request->getSession()->read('options.store.perspective'),
                    'PriceLevelPerspectives.active' => 'yes',
                ])
                ->orderAsc('sort')
                ->combine('id', 'name')
                ->toArray();
            $this->set(compact('priceLevels'));
        }

        if (Configure::read('ProductBackend.showStock')) {
            $thinkAPI = Client::createFromUrl(Configure::read('Urls.thinkAPI'));
            $thinkAPI->setConfig([
                'headers' => [
                    'scctoken' => Configure::read('Security.thinkAPI_token'),
                    'CompanyCode' => TableRegistry::getTableLocator()->get('StoreDivisions')
                        ->find()->where(['store_id' => $this->request->getSession()->read('store', 4)])
                        ->first()->company_code,
                ],
                'ssl_verify_peer' => false,
            ]);
            $result = $thinkAPI->get('/sage100/warehouses/list.json?warehousestatus=eq:A&limit=999');
            $warehouses = Hash::combine($result->getJson()['warehouses'], '{n}.WarehouseCode', '{n}.WarehouseDesc');
            $this->set(compact('warehouses'));
        }

        if (!$this->request->is('ajax')) {
            $breadcrumbs = $this->Systems
                ->find('active')
                ->where([
                    'IFNULL(SystemPerspectives.url, Systems.url) =' => $url,
                ])
                ->first()
                ->getBreadcrumbs($configID);

            $breadcrumbs[] = [
                'title' => $system->name,
                'url' => $this->request->getPath(),
            ];

            $this->set(compact('breadcrumbs'));
        }

        $this->set(compact('system', 'tabs', 'configID', 'subKitConfigID'));

        $layout = $this->request->getSession()->read('options.store.layout.system');
        $this->viewBuilder()->setTemplate("view_$layout");
    }

    public function validate()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $kitID = $data['kit'];
            $configuration = $data['configuration'];
            $priceLevel = $data['priceLevel'] ?? $this->request->getSession()->read('options.store.price-level');

            $errors = $this->Systems->Kits->validateBucketItems($kitID, $configuration);
            [$kitRuleWarnings, $kitRuleErrors] = $this->Systems->Kits->validateKitRules($kitID, $configuration);
            [$productRuleWarnings, $productRuleErrors] = $this->Systems->Kits->validateProductRules(
                $kitID,
                $configuration
            );
            [$globalSpecRuleWarnings, $globalSpecRuleErrors] = $this->Systems->Kits->validateGlobalSpecRules(
                $kitID,
                $configuration
            );
            [
                $additionalCost,
                $additionalPrice,
                $additionalItems,
            ] = $this->Systems->Kits->validateSkuRules($configuration, compact('priceLevel'));
            [$cost, $price] = $this->Systems->getConfigurationCostAndPrice(
                $configuration,
                ['priceLevel' => $priceLevel, 'systemID' => $data['system']]
            );
            $warnings = array_merge($kitRuleWarnings, $productRuleWarnings, $globalSpecRuleWarnings);
            $errors = array_merge($errors, $kitRuleErrors, $productRuleErrors, $globalSpecRuleErrors);
            $cost = $cost + $additionalCost;
            $price = $price + $additionalPrice;

            $result = compact('price', 'warnings', 'errors', 'additionalItems');

            if (Configure::read('ProductBackend.showCost')) {
                $result['cost'] = $cost;
            }

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
