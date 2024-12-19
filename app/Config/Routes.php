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
$routes->get('product/display/(:num)', 'ProductController::display/$1');
$routes->get('/cart', 'CartController::view');
$routes->post('cart/add', 'CartController::addToCart');
$routes->post('cart/totals', 'CartController::getCartTotals');
$routes->post('cart/remove', 'CartController::removeFromCart');
$routes->post('cart/count', 'CartController::getCartCount');
$routes->post('cart/update', 'CartController::updateCartItem');
$routes->get('/checkout', 'CheckoutController::view');


