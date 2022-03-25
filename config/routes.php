<?php
/** @var \Cake\Routing\RouteBuilder $routes */

use Cake\Routing\RouteBuilder;

$routes->plugin('ProductBackend', ['path' => '/'], function (RouteBuilder $builder) {

    $builder->scope('/email', ['controller' => 'Email'], function (RouteBuilder $builder) {
        $builder->connect('/product', ['action' => 'product']);
        $builder->connect('/system', ['action' => 'system']);
    });

    $builder->connect('/hardware', ['controller' => 'ProductCategories', 'action' => 'index']);
    $builder->connect('/hardware/compare/*', ['controller' => 'ProductCategories', 'action' => 'compare']);
    $builder->connect('/hardware/*', ['controller' => 'ProductCategories', 'action' => 'view']);

    $builder->connect('/product/save/*', ['controller' => 'Products', 'action' => 'save']);
    $builder->connect('/product/**', ['controller' => 'Products', 'action' => 'view']);

    $builder->connect('/systems', ['controller' => 'SystemCategories', 'action' => 'index']);
    $builder->connect('/systems/*', ['controller' => 'SystemCategories', 'action' => 'view']);

    $builder->connect('/system/specs', ['controller' => 'Systems', 'action' => 'specs']);
    $builder->connect('/system/configuration/update', ['controller' => 'Systems', 'action' => 'updateConfiguration']);
    $builder->connect('/system/configuration/save', ['controller' => 'Systems', 'action' => 'saveConfiguration']);
    $builder->connect('/system/configuration/validate',
        ['controller' => 'Systems', 'action' => 'validateConfiguration']);
    $builder->connect('/system/*', ['controller' => 'Systems', 'action' => 'view']);
});
