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
use ProductBackend\Model\Entity\System;

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
            'specs',
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
     * @param string $opportunityKey config ID (opportunity_system_id) or base64 encoded opportunity detail line number.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(
        string $url,
        string $opportunityKey = null,
        string $configKey = null,
        string $subKitPath = null
    )
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
        $session = $this->request->getSession();

        if (!Configure::read('ProductBackend.showCost')) {
            $opportunityKey = $opportunityKey ?? array_keys($session->read('opportunities', []))[0] ?? null;
        }

        if ($opportunityKey && !$session->check("opportunities.$opportunityKey.current")) {
            return $this->redirect(['action' => 'view', '?' => $this->request->getQueryParams(), $systemUrl]);
        }

        if ($configKey) {
            $configuration = $session->read("configurations.$configKey");

            if (!is_numeric($configKey) && !$configuration) {
                return $this->redirect(['action' => 'view', '?' => $this->request->getQueryParams(), $systemUrl]);
            }

            if (is_numeric($configKey) && !$configuration) { // load system by config ID
                try {
                    $opportunitySystem = Configure::read('Functions.getOpportunitySystem')($configKey);
                } catch (NotFoundException $exception) {
                    return $this->redirect(['action' => 'view', '?' => $this->request->getQueryParams(), $systemUrl]);
                }

                if ($rootSystem['id'] !== $opportunitySystem['system_id']) {
                    return $this->redirect(['action' => 'view', '?' => $this->request->getQueryParams(), $systemUrl]);
                }

                $configuration = json_decode($opportunitySystem['opportunity_system_data']['data'], true);
                $session->write("configurations.$configKey", $configuration);
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
                        $opportunityKey,
                        $configKey,
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

        if (!$opportunityKey) {
            $opportunityKey = random_string(6);
            $session->write("opportunities.$opportunityKey.current", []);
        }

        $options['store'] = $session->read("opportunities.$opportunityKey.store.id") ?? $session->read('store.id');
        $system = $this->Systems->find('details', $options)
            ->where(['IFNULL(SystemPerspectives.url, Systems.url) =' => $systemUrl])
            ->first();

        $configKey = $configKey ?: random_string(6);

        (new System($system))->loadConfiguration($configuration);

        $tabs = TableRegistry::getTableLocator()->get('ProductBackend.Tabs')->find()->order('sort')->toArray();

        if (Configure::read('ProductBackend.showCost')) {
            $priceLevels = TableRegistry::getTableLocator()->get('ProductBackend.PriceLevels')
                ->find()
                ->select(['id', 'name'])
                ->innerJoinWith('PriceLevelPerspectives')
                ->where([
                    'PriceLevelPerspectives.perspective_id' => $session->read('store.perspective'),
                    'PriceLevelPerspectives.active' => 'yes',
                ])
                ->orderAsc('sort')
                ->all()
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
                            ->find()->where(['store_id' => $options['store']])
                            ->first()->company_code ?? 'SCC',
                ],
                'ssl_verify_peer' => false,
            ]);
            $result = $thinkAPI->get('/sage100/warehouses/list.json?warehousestatus=eq:A&limit=999');
            $warehouses = Hash::combine($result->getJson()['warehouses'], '{n}.WarehouseCode', '{n}.WarehouseDesc');
            $this->set(compact('warehouses'));
        }

        if (!$this->request->is('ajax')) {
            $breadcrumbs = $rootSystem->getBreadcrumbs("$opportunityKey/$configKey");

            if ($subKitPath) {
                $breadcrumbs[] = [
                    'title' => $system->name,
                    'url' => $this->request->getPath(),
                ];
            }

            $this->set(compact('breadcrumbs'));
        }

        $this->set(compact('system', 'tabs', 'opportunityKey', 'configKey', 'subKitPath'));
        $this->set(['systemUrl' => $url]);

        $layout = $session->read("opportunities.$opportunityKey.store.layout_system") ?? $session->read('store.layout_system');
        $this->viewBuilder()->setTemplate("view_$layout");
    }

    public function specs()
    {
        $systemID = $this->request->getQuery('system');
        $opportunityKey = $this->request->getQuery('opportunityKey');
        $configKey = $this->request->getQuery('configKey');
        $subKitPath = $this->request->getQuery('subKitPath');
        $session = $this->request->getSession();
        $configuration = $session->read("configurations.$configKey" . ($subKitPath ? ('.' . base64_decode($subKitPath)) : ''));
        $configurationJson = json_encode($configuration);

        $system = $this->Systems->find('banner')->where(['Systems.id' => $systemID])->first();
        $banner = $system['banner'];

        $defaultOpportunityDetail = [
            'opportunity_detail_type_id' => 4,
            'opportunity_system' => [
                'system_id' => $systemID,
                'opportunity_system_data' => [
                    'data' => $configurationJson,
                ],
            ],
            'display_specs' => 'yes',
        ];
        $opportunity = [
            'store_id' => $session->read("opportunities.$opportunityKey.store.id") ?? $session->read('store.id'),
            'opportunity_details' => [
                $defaultOpportunityDetail
            ],
        ];
        $opportunity = Configure::read("Functions.prepareOpportunity")($opportunity);

        $specificationGroups = null;
        $system = null;
        foreach ($opportunity['opportunity_details'] as $opportunityDetail) {
            if ($opportunitySystem = $opportunityDetail['opportunity_system'] ?? null) {
                if ($opportunitySystem['opportunity_system_data']['data'] === $configurationJson) {
                    $specificationGroups = $opportunityDetail['specs'];
                    $system = $opportunityDetail['opportunity_system'];
                    break;
                }
            }
        }

        $this->set(compact('system', 'specificationGroups', 'banner'));
    }

    public function validateConfiguration()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $kitID = $data['kit'];
            $configuration = $this->formatConfiguration($data['configuration'])['config'];
            $priceLevel = $data['priceLevel'] ?? $this->request->getSession()->read('store.price_level');

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

            $kitOptionCode = $this->Systems->Kits->KitOptionCodes
                ->find('partNumber', [
                    'kitID' => $kitID,
                    'itemIDs' => Hash::extract($configuration, '{n}.{n}.item_id'),
                ])
                ->first();

            if (isset($kitOptionCode['part_number'])) {
                $result['partNumber'] = $kitOptionCode['part_number'];
            }

            return $this->response->withStringBody(json_encode($result))->withType('application/json');
        }
    }

    public function updateConfiguration()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $configKey = $data['config_key'];
            $configuration = $data['configuration'];
            $subKitPath = $data['sub_kit_path'] ?? null;

            $configuration = $this->formatConfiguration($configuration);

            if ($subKitPath) {
                $rootConfiguration = $this->request->getSession()->read("configurations.$configKey");
                $configuration = Hash::insert($rootConfiguration, $subKitPath, $configuration);
            }

            $this->request->getSession()->write("configurations.$configKey", $configuration);

            $result = compact('configuration');

            return $this->response->withStringBody(json_encode($result))->withType('application/json');
        }
    }

    public function saveConfiguration()
    {
        if ($this->request->is('post')) {
            $session = $this->request->getSession();
            $data = $this->request->getData();
            $systemID = $data['system'];
            $opportunityKey = $data['opportunity_key'];
            $configKey = $data['config_key'];
            $oldConfig = $session->read("configurations.$configKey");
            $response = $this->updateConfiguration();

            if (isset($data['sub_kit_path'])) {
                return $response;
            }

            $configuration = $session->read("configurations.$configKey");

            $defaultOpportunityDetail = [
                'opportunity_detail_type_id' => 4,
                'opportunity_system' => [
                    'system_id' => $systemID,
                    'opportunity_system_data' => [
                        'data' => json_encode($configuration),
                    ],
                ],
            ];

            $opportunitySessionDataKey = "opportunities.$opportunityKey.current";
            $opportunity = [
                'store_id' => $session->read("opportunities.$opportunityKey.store.id") ?? $session->read('store.id'),
                'opportunity_details' => [$defaultOpportunityDetail],
            ];

            if ($currentOpportunity = $session->read($opportunitySessionDataKey)) {
                $opportunity = $currentOpportunity;
                $updatingExistingSystem = false;

                foreach ($opportunity['opportunity_details'] as $opportunityDetail) {
                    if ($opportunitySystem = $opportunityDetail['opportunity_system'] ?? null) {
                        if ($opportunitySystem['opportunity_system_data']['data'] === json_encode($oldConfig)) {
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
            $session->write($opportunitySessionDataKey, $opportunity);

            $result = compact('configuration');

            return $this->response->withStringBody(json_encode($result))->withType('application/json');
        }
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
