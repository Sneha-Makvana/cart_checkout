<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/', 'productController::view');
$routes->get('/main', 'productController::view');


$routes->get('/login', 'LoginController::display');
$routes->post('/login', 'LoginController::login');
$routes->get('/logout', 'LoginController::logout');
$routes->get('/register', 'LoginController::formPage');
$routes->post('/register/create', 'LoginController::create');


$routes->get('/singleProduct', 'productController::display');
$routes->get('product/display/(:num)', 'ProductController::display/$1');
$routes->get('/product', 'productController::product');
$routes->get('/product/product', 'productController::create');
$routes->post('/product/fetchProducts', 'productController::fetchProducts');


$routes->get('/cart', 'CartController::view');
$routes->post('cart/add', 'CartController::addToCart');
$routes->post('cart/totals', 'CartController::getCartTotals');
$routes->post('cart/remove', 'CartController::removeFromCart');
$routes->post('cart/count', 'CartController::getCartCount');
$routes->post('cart/update', 'CartController::updateCartItem');


$routes->get('/checkout', 'CheckoutController::view');
$routes->post('/checkout/process', 'CheckoutController::process'); 
$routes->get('/thankyou', 'CheckoutController::display');


$routes->get('/order/success', 'OrderController::success'); 
$routes->get('/order/history', 'OrderController::history');


