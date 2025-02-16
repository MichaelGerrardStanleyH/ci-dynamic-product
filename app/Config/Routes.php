<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/(:num)', 'Home::getById/$1');
$routes->post('/', 'Home::addDynamicProduct/$1');
$routes->put('/(:num)', 'Home::editDynamicProduct/$1');
$routes->delete('/(:num)', 'Home::deleteDynamicProduct/$1');
