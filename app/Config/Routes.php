<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// rest-api
$routes->get('/products', 'Home::index');
$routes->get('/products/(:num)', 'Home::getById/$1');
$routes->post('/dynamic-products', 'Home::addDynamicProduct/$1');
$routes->put('/dynamic-products/(:num)', 'Home::editDynamicProduct/$1');
$routes->delete('/dynamic-products/(:num)', 'Home::deleteDynamicProduct/$1');
