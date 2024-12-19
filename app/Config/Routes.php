<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/', 'LoginController::view');
$routes->get('/main', 'productController::view');
$routes->get('/login', 'LoginController::display');
$routes->post('/login', 'LoginController::login');
$routes->get('/logout', 'LoginController::logout');
$routes->get('/register', 'LoginController::formPage');
$routes->post('/register/create', 'LoginController::create');
$routes->get('/singleProduct', 'productController::display');

