<?php
/** @var \Cake\Routing\RouteBuilder $routes */

use Cake\Routing\RouteBuilder;

$routes->plugin('ProductBackend', ['path' => '/'], function (RouteBuilder $route) {

    $route->scope('/email', ['controller' => 'Email'], function (RouteBuilder $builder) {
        $builder->connect('/product', ['action' => 'product']);
        $builder->connect('/system', ['action' => 'system']);
    });

    $route->connect('/hardware', ['controller' => 'ProductCategories', 'action' => 'index']);
    $route->connect('/hardware/compare/*', ['controller' => 'ProductCategories', 'action' => 'compare']);
    $route->connect('/hardware/*', ['controller' => 'ProductCategories', 'action' => 'view']);

    $route->connect('/product/save/*', ['controller' => 'Products', 'action' => 'save']);
    $route->connect('/product/**', ['controller' => 'Products', 'action' => 'view']);

    $route->connect('/systems', ['controller' => 'SystemCategories', 'action' => 'index']);
    $route->connect('/systems/*', ['controller' => 'SystemCategories', 'action' => 'view']);

    $route->connect('/system/specs', ['controller' => 'Systems', 'action' => 'specs']);
    $route->connect('/system/configuration/update', ['controller' => 'Systems', 'action' => 'updateConfiguration']);
    $route->connect('/system/configuration/save', ['controller' => 'Systems', 'action' => 'saveConfiguration']);
    $route->connect('/system/configuration/validate',
        ['controller' => 'Systems', 'action' => 'validateConfiguration']);
    $route->connect('/system/*', ['controller' => 'Systems', 'action' => 'view']);

    $route->prefix('Api', function (RouteBuilder $route) {
        $route->connect('/hardware', ['controller' => 'ProductCategories', 'action' => 'index']);
        $route->connect('/hardware/*', ['controller' => 'ProductCategories', 'action' => 'view']);
        $route->connect('/all-products', ['controller' => 'Products', 'action' => 'index']);
        $route->connect('/product/**', ['controller' => 'Products', 'action' => 'view']);

        $route->connect('/systems', ['controller' => 'SystemCategories', 'action' => 'index']);
        $route->connect('/systems/*', ['controller' => 'SystemCategories', 'action' => 'view']);
        $route->connect('/all-systems', ['controller' => 'Systems', 'action' => 'index']);
        $route->connect('/system/banner/*', ['controller' => 'Systems', 'action' => 'banner']);
        $route->connect('/system/*', ['controller' => 'Systems', 'action' => 'view']);
    });
});
