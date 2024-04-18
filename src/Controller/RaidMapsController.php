<?php
declare(strict_types=1);

namespace ProductBackend\Controller;

/**
 * RaidMaps Controller
 *
 * @property \ProductBackend\Model\Table\RaidMapsTable $RaidMaps
 * @method \ProductBackend\Model\Entity\RaidMap[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RaidMapsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ProductCategories', 'InterfaceSpecs', 'Interface2Specs', 'NameSpecs', 'RaidSpecs', 'PortsSpecs', 'DevicesSpecs', 'PergroupSpecs', 'CapacitySpecs', 'BackplaneSpecs'],
        ];
        $raidMaps = $this->paginate($this->RaidMaps);

        $this->set(compact('raidMaps'));
    }

    /**
     * View method
     *
     * @param string|null $id Raid Map id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $raidMap = $this->RaidMaps->get($id, contain: ['ProductCategories', 'InterfaceSpecs', 'Interface2Specs', 'NameSpecs', 'RaidSpecs', 'PortsSpecs', 'DevicesSpecs', 'PergroupSpecs', 'CapacitySpecs', 'BackplaneSpecs']);

        $this->set(compact('raidMap'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $raidMap = $this->RaidMaps->newEmptyEntity();
        if ($this->request->is('post')) {
            $raidMap = $this->RaidMaps->patchEntity($raidMap, $this->request->getData());
            if ($this->RaidMaps->save($raidMap)) {
                $this->Flash->success(__('The raid map has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The raid map could not be saved. Please, try again.'));
        }
        $productCategories = $this->RaidMaps->ProductCategories->find(limit: 200)->all()->toList();
        $interfaceSpecs = $this->RaidMaps->InterfaceSpecs->find(limit: 200)->all()->toList();
        $interface2Specs = $this->RaidMaps->Interface2Specs->find(limit: 200)->all()->toList();
        $nameSpecs = $this->RaidMaps->NameSpecs->find(limit: 200)->all()->toList();
        $raidSpecs = $this->RaidMaps->RaidSpecs->find(limit: 200)->all()->toList();
        $portsSpecs = $this->RaidMaps->PortsSpecs->find(limit: 200)->all()->toList();
        $devicesSpecs = $this->RaidMaps->DevicesSpecs->find(limit: 200)->all()->toList();
        $pergroupSpecs = $this->RaidMaps->PergroupSpecs->find(limit: 200)->all()->toList();
        $capacitySpecs = $this->RaidMaps->CapacitySpecs->find(limit: 200)->all()->toList();
        $backplaneSpecs = $this->RaidMaps->BackplaneSpecs->find(limit: 200)->all()->toList();
        $this->set(compact('raidMap', 'productCategories', 'interfaceSpecs', 'interface2Specs', 'nameSpecs', 'raidSpecs', 'portsSpecs', 'devicesSpecs', 'pergroupSpecs', 'capacitySpecs', 'backplaneSpecs'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Raid Map id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $raidMap = $this->RaidMaps->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $raidMap = $this->RaidMaps->patchEntity($raidMap, $this->request->getData());
            if ($this->RaidMaps->save($raidMap)) {
                $this->Flash->success(__('The raid map has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The raid map could not be saved. Please, try again.'));
        }
        $productCategories = $this->RaidMaps->ProductCategories->find(limit: 200)->all()->toList();
        $interfaceSpecs = $this->RaidMaps->InterfaceSpecs->find(limit: 200)->all()->toList();
        $interface2Specs = $this->RaidMaps->Interface2Specs->find(limit: 200)->all()->toList();
        $nameSpecs = $this->RaidMaps->NameSpecs->find(limit: 200)->all()->toList();
        $raidSpecs = $this->RaidMaps->RaidSpecs->find(limit: 200)->all()->toList();
        $portsSpecs = $this->RaidMaps->PortsSpecs->find(limit: 200)->all()->toList();
        $devicesSpecs = $this->RaidMaps->DevicesSpecs->find(limit: 200)->all()->toList();
        $pergroupSpecs = $this->RaidMaps->PergroupSpecs->find(limit: 200)->all()->toList();
        $capacitySpecs = $this->RaidMaps->CapacitySpecs->find(limit: 200)->all()->toList();
        $backplaneSpecs = $this->RaidMaps->BackplaneSpecs->find(limit: 200)->all()->toList();
        $this->set(compact('raidMap', 'productCategories', 'interfaceSpecs', 'interface2Specs', 'nameSpecs', 'raidSpecs', 'portsSpecs', 'devicesSpecs', 'pergroupSpecs', 'capacitySpecs', 'backplaneSpecs'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Raid Map id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $raidMap = $this->RaidMaps->get($id);
        if ($this->RaidMaps->delete($raidMap)) {
            $this->Flash->success(__('The raid map has been deleted.'));
        } else {
            $this->Flash->error(__('The raid map could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
