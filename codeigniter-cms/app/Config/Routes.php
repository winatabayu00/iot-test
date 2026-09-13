<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'DashboardController::index');

$routes->group('products', static function ($routes) {
    $routes->get('/', 'ProductController::index');
    $routes->get('new', 'ProductController::new');
    $routes->post('/', 'ProductController::create');
    $routes->get('(:num)/edit', 'ProductController::edit/$1');
    $routes->post('(:num)', 'ProductController::update/$1');
    $routes->post('(:num)/delete', 'ProductController::delete/$1');
});

$routes->group('customers', static function ($routes) {
    $routes->get('/', 'CustomerController::index');
    $routes->get('new', 'CustomerController::new');
    $routes->post('/', 'CustomerController::create');
    $routes->get('(:num)/edit', 'CustomerController::edit/$1');
    $routes->post('(:num)', 'CustomerController::update/$1');
    $routes->post('(:num)/delete', 'CustomerController::delete/$1');
});

$routes->group('transactions', static function ($routes) {
    $routes->get('/', 'TransactionController::index');
    $routes->get('new', 'TransactionController::new');
    $routes->post('/', 'TransactionController::create');
    $routes->get('(:num)', 'TransactionController::show/$1');
});
