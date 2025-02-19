<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->options('(:any)', function () {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    exit(0);
});


// rest-api
$routes->get('/products', 'ProductRest::index');
$routes->post('/products', 'ProductRest::addProduct');
$routes->delete('/products/(:num)', 'ProductRest::deleteProduct/$1');
$routes->get('/products/(:num)', 'ProductRest::getProductById/$1');
$routes->get('/dynamic-products/(:num)', 'ProductRest::getDynamicProductById/$1');
$routes->post('/dynamic-products', 'ProductRest::addDynamicProduct');
$routes->put('/dynamic-products/(:num)', 'ProductRest::editDynamicProduct/$1');
$routes->delete('/dynamic-products/(:num)', 'ProductRest::deleteDynamicProduct/$1');
