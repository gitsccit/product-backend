<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

use Cake\Collection\Collection;
use Cake\Core\Configure;
use Cake\Event\EventInterface;
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
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Authentication->addUnauthenticatedActions([
            'validateConfiguration',
            'updateConfiguration',
            'saveConfiguration',
        ]);
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
     * @param string $identifier config ID (opportunity_system_id) or base64 encoded opportunity detail line number.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(string $url, string $identifier = null, string $subKitPath = null)
    {
        $url = str_replace(' ', '+', $url);
        $systemUrl = $url;

        $options = [];
        if ($priceLevel = $this->request->getQuery('priceLevel')) {
            $options['priceLevel'] = $priceLevel;
        }
        if ($warehouse = $this->request->getQuery('warehouse')) {
            $options['warehouse'] = $warehouse;
        }

        $rootSystem = $this->Systems->find('active', $options)
            ->where(['IFNULL(SystemPerspectives.url, Systems.url) =' => $systemUrl])
            ->first();

        if (is_null($rootSystem)) {
            throw new NotFoundException();
        }

        $configuration = null;

        if ($identifier) {
            $configuration = $this->request->getSession()->read("configurations.$identifier");

            if (!is_numeric($identifier) && !$configuration) {
                return $this->redirect(['action' => 'view', '?' => $this->request->getQueryParams(), $systemUrl]);
            }

            if (is_numeric($identifier) && !$configuration) { // load system by config ID
                try {
                    $opportunitySystem = Configure::read('Functions.getOpportunitySystem')($identifier);
                } catch (NotFoundException $exception) {
                    return $this->redirect(['action' => 'view', '?' => $this->request->getQueryParams(), $systemUrl]);
                }

                if ($rootSystem['id'] !== $opportunitySystem['system_id']) {
                    return $this->redirect(['action' => 'view', '?' => $this->request->getQueryParams(), $systemUrl]);
                }

                $configuration = json_decode($opportunitySystem['opportunity_system_data']['data'], true);
                $this->request->getSession()->write("configurations.$identifier", $configuration);
            }

            if ($subKitPath) {
                $subKitPath = base64_decode($subKitPath);
                $subKitConfigFound = true;

                try {
                    $subKitLine = Hash::get($configuration, preg_replace('/\.subkit$/', '', $subKitPath));
                    $configuration = $subKitLine['subkit'];

                    if (!$configuration) {
                        $subKitConfigFound = false;
                    }
                } catch (\Exception $exception) {
                    $subKitConfigFound = false;
                }

                if (!$subKitConfigFound) {
                    return $this->redirect([
                        'action' => 'view',
                        '?' => $this->request->getQueryParams(),
                        $systemUrl,
                        $identifier
                    ]);
                }

                $systemUrl = $this->Systems->find('active', $options)
                    ->select(['url' => 'IFNULL(SystemPerspectives.url, Systems.url)'])
                    ->innerJoinWith('GroupItems')
                    ->where(['GroupItems.id' => $subKitLine['item_id']])
                    ->first()
                    ->get('url');
            }
        }

        $identifier = $identifier ?: random_string(8);

        $system = $this->Systems->find('details', $options)
            ->where(['IFNULL(SystemPerspectives.url, Systems.url) =' => $systemUrl])
            ->first();

        $system->loadConfiguration($configuration);

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
                        ->find()->where(['store_id' => $this->request->getSession()->read('store.id')])
                        ->first()->company_code,
                ],
                'ssl_verify_peer' => false,
            ]);
            $result = $thinkAPI->get('/sage100/warehouses/list.json?warehousestatus=eq:A&limit=999');
            $warehouses = Hash::combine($result->getJson()['warehouses'], '{n}.WarehouseCode', '{n}.WarehouseDesc');
            $this->set(compact('warehouses'));
        }

        if (!$this->request->is('ajax')) {
            $breadcrumbs = $rootSystem->getBreadcrumbs($identifier);

            if ($subKitPath) {
                $breadcrumbs[] = [
                    'title' => $system->name,
                    'url' => $this->request->getPath(),
                ];
            }

            $this->set(compact('breadcrumbs'));
        }

        $this->set(compact('system', 'tabs', 'identifier', 'subKitPath'));
        $this->set(['systemUrl' => $url]);

        $layout = $this->request->getSession()->read('options.store.layout.system');
        $this->viewBuilder()->setTemplate("view_$layout");
    }

    public function validateConfiguration()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $kitID = $data['kit'];
            $configuration = $this->formatConfiguration($data['configuration'])['config'];
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

    public function updateConfiguration()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $identifier = $data['identifier'];
            $configuration = $data['configuration'];
            $subKitPath = $data['sub_kit_path'] ?? null;

            $configuration = $this->formatConfiguration($configuration);

            if ($subKitPath) {
                $rootConfiguration = $this->request->getSession()->read("configurations.$identifier");
                $configuration = Hash::insert($rootConfiguration, $subKitPath, $configuration);
            }

            $this->request->getSession()->write("configurations.$identifier", $configuration);

            $result = compact('configuration');

            return $this->response->withStringBody(json_encode($result))->withType('application/json');
        }
    }

    public function saveConfiguration()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $systemID = $data['system'];
            $identifier = $data['identifier'];
            $response = $this->updateConfiguration();

            if (isset($data['sub_kit_path'])) {
                return $response;
            }

            $session = $this->request->getSession();
            $configuration = $session->read("configurations.$identifier");

            $defaultOpportunityDetail = [
                'opportunity_detail_type_id' => 4,
                'opportunity_system' => [
                    'system_id' => $systemID,
                    'opportunity_system_data' => [
                        'data' => json_encode($configuration),
                    ],
                ],
            ];

            $opportunity = [
                'store_id' => $session->read('store.id'),
                'environment_id' => $session->read('environment.id'),
                'opportunity_details' => [$defaultOpportunityDetail],
            ];

            if ($session->check('opportunity')) {
                $opportunity = $session->read('opportunity');
                $updatingExistingSystem = false;

                foreach ($opportunity['opportunity_details'] as $opportunityDetail) {
                    if ($opportunitySystem = $opportunityDetail['opportunity_system'] ?? null) {
                        if ($opportunityDetail['opportunity_detail_type']['name'] === 'system' && $opportunitySystem['id'] === $identifier) {
                            $opportunitySystem['opportunity_system_data']['data'] = json_encode($configuration);
                            $updatingExistingSystem = true;

                            break;
                        }
                    }
                }

                if (!$updatingExistingSystem) {
                    $opportunity['opportunity_details'][] = $defaultOpportunityDetail;
                }
            }

            $action = isset($opportunity['id']) ? 'commit' : 'prepare';
            $opportunity = Configure::read("Functions.{$action}Opportunity")($opportunity);
            $session->write("opportunity", $opportunity);

            $result = compact('configuration');

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

    protected function formatConfiguration($configuration)
    {
        $configItems = Hash::extract($configuration, 'config.{n}.{n}');
        $configItemsWithoutSubKit = Hash::filter($configItems, function ($item) {
            return !isset($item['subkit']);
        });

        if (empty($configItemsWithoutSubKit)) {
            return $configuration;
        }

        $configItemIDsWithoutSubKit = Hash::extract($configItemsWithoutSubKit, '{n}.item_id');
        $placeholders = implode(', ', array_fill(0, count($configItemIDsWithoutSubKit), '?'));
        $subKitItems = TableRegistry::getTableLocator()->get('ProductBackend.GroupItems')->getConnection()
            ->execute("
                    SELECT
                        group_items.id,
                        buckets_groups.bucket_id,
                        system_items.item_id,
                        system_items.quantity
                    FROM group_items
                        INNER JOIN systems ON systems.id = group_items.system_id
                        INNER JOIN system_items ON system_items.system_id = systems.id
                        INNER JOIN group_items gi ON gi.id = system_items.item_id
                        INNER JOIN `groups` ON `groups`.id = gi.group_id
                        INNER JOIN buckets_groups ON buckets_groups.group_id = `groups`.id
                    WHERE group_items.id IN ($placeholders)", $configItemIDsWithoutSubKit)
            ->fetchAll('assoc');

        $subKitConfiguration = (new Collection($subKitItems))
            ->groupBy('id')
            ->map(function ($systemItems) {
                return (new Collection($systemItems))->groupBy('bucket_id')->map(function ($bucketItems) {
                    return array_map(function ($item) {
                        return [
                            'item_id' => (int)$item['item_id'],
                            'qty' => (int)$item['quantity'],
                        ];
                    }, $bucketItems);
                })->toArray();
            })
            ->toArray();

        foreach ($configuration['config'] as &$bucketItems) {
            foreach ($bucketItems as &$item) {
                if (!isset($item['subkit']) && ($config = $subKitConfiguration[$item['item_id']] ?? null)) {
                    $item['subkit'] = compact('config');
                }
            }
        }

        return $configuration;
    }
}
