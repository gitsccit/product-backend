<?php
declare(strict_types=1);

use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

/*
 * Read configuration file and inject configuration into various
 * CakePHP classes.
 *
 * By default there is only one configuration file. It is often a good
 * idea to create multiple configuration files, and separate the configuration
 * that changes from configuration that does not. This makes deployment simpler.
 */
try {
    Configure::load('ProductBackend.app', 'default', true);
} catch (\Exception $e) {
    exit($e->getMessage() . "\n");
}

// switch connection to the mirrored DB
if (PHP_SAPI !== 'cli') {
    $tableLocator = TableRegistry::getTableLocator();
    $activeDB = $tableLocator->get('ProductBackend.ActiveBackendDatabase')->find()->first();
    if ($activeDB) {
        $activeDbName = $activeDB->name;
        $tableLocator->clear();
        $mirrorConfig = array_merge(ConnectionManager::getConfig('product_backend'), ['database' => $activeDbName]);
        $mirrorReplicaConfig = array_merge(ConnectionManager::getConfig('product_backend_replica'), ['database' => $activeDbName]);
        ConnectionManager::drop('product_backend');
        ConnectionManager::drop('product_backend_replica');
        ConnectionManager::setConfig('product_backend', $mirrorConfig);
        ConnectionManager::setConfig('product_backend_replica', $mirrorReplicaConfig);
    }
}