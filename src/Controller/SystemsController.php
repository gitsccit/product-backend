<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

use Cake\Core\Configure;
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
     * @param string $identifier config ID (opportunity_system_id) or base64 encoded opportunity detail line number.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(string $url, string $identifier = null, string $subKitPosition = null)
    {
        $systemUrl = str_replace(' ', '+', $url);

        $options = [];
        if ($priceLevel = $this->request->getQuery('priceLevel')) {
            $options['priceLevel'] = $priceLevel;
        }
        if ($warehouse = $this->request->getQuery('warehouse')) {
            $options['warehouse'] = $warehouse;
        }

        $system = $this->Systems->find('active', $options)
            ->where(['IFNULL(SystemPerspectives.url, Systems.url) =' => $systemUrl])
            ->first();

        if (is_null($system)) {
            throw new NotFoundException();
        }

        $configJson = null;

        if ($identifier) {
            $configJson = $this->request->getSession()->read("configurations.$identifier");

            if (!is_numeric($identifier) && !$configJson) {
                return $this->request->redirect(['action' => 'view', $url]);
            }

            if (is_numeric($identifier) && !$configJson) { // load system by config ID
                try {
                    $opportunitySystem = Configure::read('Functions.getOpportunitySystem')($identifier);
                } catch (NotFoundException $exception) {
                    return $this->request->redirect(['action' => 'view', $url]);
                }

                if ($system['id'] !== $opportunitySystem['system_id']) {
                    return $this->request->redirect(['action' => 'view', $url]);
                }

                $configJson = json_decode($opportunitySystem['opportunity_system_data']['data'], true);
                $this->request->getSession()->write("configurations.$identifier", $configJson);
            }

            if ($subKitPosition) {
                $subKitPosition = base64_decode($subKitPosition);
                $subKitConfigFound = true;

                try {
                    $configJson = Hash::get($configJson, $subKitPosition);

                    if (!$configJson) {
                        $subKitConfigFound = false;
                    }
                } catch (\Exception $exception) {
                    $subKitConfigFound = false;
                }

                if (!$subKitConfigFound) {
                    return $this->request->redirect(['action' => 'view', $url, $identifier]);
                }

                $systemUrl = $this->Systems->find('active', $options)
                    ->select(['url' => 'IFNULL(SystemPerspectives.url, Systems.url)'])
                    ->innerJoinWith('GroupItems')
                    ->where(['GroupItems.id' => $configJson['item_id']])
                    ->first()
                    ->get('url');
            }
        }

        $identifier = $identifier ?: random_string(16);

        $system = $this->Systems->find('details', $options)
            ->where(['IFNULL(SystemPerspectives.url, Systems.url) =' => $systemUrl])
            ->first();

        $system->loadConfiguration($configJson);

        $tabs = TableRegistry::getTableLocator()->get('ProductBackend.Tabs')->find()->order('sort')->toArray();

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
                ->find('basic', $options)
                ->where([
                    'IFNULL(SystemPerspectives.url, Systems.url) =' => $url,
                ])
                ->first()
                ->getBreadcrumbs($identifier);

            $breadcrumbs[] = [
                'title' => $system->name,
                'url' => $this->request->getPath(),
            ];

            $this->set(compact('breadcrumbs'));
        }

        $this->set(compact('system', 'tabs', 'identifier'));

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

    public function configuration($action)
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $systemID = $data['system_id'];
            $configJsonString = json_encode($data['config_json']);
            $systemLineNumber = $data['system_line_number'] ?? 1;
            $subKitConfigJsonString = json_encode($data['sub_kit_config_json'] ?? null);
            $subKitSystemID = $data['sub_kit_system_id'] ?? null;

            $defaultOpportunity = [
                'store_id' => $this->request->getQuery('store_id', $this->request->getSession()->read('store.id')),
                'environment_id' => $this->request->getQuery('environment_id',
                    $this->request->getSession()->read('environment.id')),
                'opportunity_details' => [
                    [
                        'opportunity_detail_type_id' => 4,
                        'opportunity_system' => [
                            'system_id' => $systemID,
                        ],
                    ],
                ],
            ];

            $opportunity = $this->request->getSession()->read('opportunity', $defaultOpportunity);
            $opportunity['opportunity_details'][$systemLineNumber - 1]['opportunity_system']['opportunity_system_data']['data'] = $configJsonString;
            $opportunity = Configure::read("Functions.{$action}Opportunity")($opportunity);
            $this->request->getSession()->write('opportunity', $opportunity);

            $systemLine = array_filter($opportunity['opportunity_details'],
                function ($opportunityDetail) use ($configJsonString) {
                    return $opportunityDetail['opportunity_detail_type']['name'] === 'system' &&
                        $opportunityDetail['opportunity_system']['opportunity_system_data']['data'] === $configJsonString;
                })[0];

            // sub-kit selected but not configured yet
            if ($subKitSystemID) {
                $subKitLine = array_filter($opportunity['opportunity_details'],
                    function ($opportunityDetail) use ($subKitSystemID) {
                        return $opportunityDetail['opportunity_detail_type']['name'] === 'subkit' &&
                            $opportunityDetail['opportunity_system']['system_id'] === $subKitSystemID &&
                            !isset(json_decode($opportunityDetail['opportunity_system']['opportunity_system_data']['data'],
                                    true)['configured_at']);
                    })[0];
            }

            // configured sub-kit
            if ($subKitConfigJsonString) {
                $subKitLine = array_filter($opportunity['opportunity_details'],
                    function ($opportunityDetail) use ($subKitConfigJsonString) {
                        return $opportunityDetail['opportunity_detail_type']['name'] === 'subkit' &&
                            $opportunityDetail['opportunity_system']['opportunity_system_data']['data'] === $subKitConfigJsonString;
                    })[0];
            }

            $result = compact('systemLineNumber');
            if ($configID = $systemLine['opportunity_system']['id'] ?? null) {
                $result['configId'] = $configID;
            }

            if (isset($subKitLine)) {
                $result['subKitLineNumber'] = $subKitLine['line_number'];
            }

            return $this->response->withStringBody(json_encode($result))->withType('application/json');
        }
    }

    public function saveConfiguration()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $configJsonString = json_encode($data['config_json']);

            $result = [];

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
