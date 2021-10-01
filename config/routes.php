<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::plugin('ProductBackend', ['path' => '/'], function (RouteBuilder $builder) {

    $builder->scope('/email', ['controller' => 'Email'], function (RouteBuilder $builder) {
        $builder->connect('/product', ['action' => 'product']);
        $builder->connect('/system', ['action' => 'system']);
    });

    $builder->connect('/hardware', ['controller' => 'ProductCategories', 'action' => 'index']);
    $builder->connect('/hardware/compare/*', ['controller' => 'ProductCategories', 'action' => 'compare']);
    $builder->connect('/hardware/*', ['controller' => 'ProductCategories', 'action' => 'view']);

    $builder->connect('/product/**', ['controller' => 'Products', 'action' => 'view']);

    $builder->connect('/systems', ['controller' => 'SystemCategories', 'action' => 'index']);
    $builder->connect('/systems/*', ['controller' => 'SystemCategories', 'action' => 'view']);

    $builder->connect('/system/configuration/{action}', ['controller' => 'Systems', 'action' => 'configureSubKit'],
        ['action' => 'prepare|commit']);
    $builder->connect('/system/validate', ['controller' => 'Systems', 'action' => 'validate']);
    $builder->connect('/system/*', ['controller' => 'Systems', 'action' => 'view']);
});
