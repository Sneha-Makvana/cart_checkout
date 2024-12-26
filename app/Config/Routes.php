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
$routes->post('cart/remove/(:num)', 'CartController::removeFromCart/$1');
$routes->post('cart/count', 'CartController::getCartCount');
$routes->post('cart/update', 'CartController::updateCartItem');


$routes->get('/checkout', 'CheckoutController::view');
$routes->post('/checkout/process', 'CheckoutController::process');
$routes->get('/thankyou', 'CheckoutController::display');


// $routes->post('paypal/payPal', 'PayPalController::payPal');
// $routes->get('paypal/success', 'PayPalController::success');
// $routes->get('paypal/cancel', 'PayPalController::cancel');


// $routes->post('/payPal', 'PayPalController::checkout');
// $routes->get('paypal/success', 'PayPalController::success');
// $routes->get('paypal/cancel', 'PayPalController::cancel');

$routes->post('paypal/create-payment', 'PayPalController::createPayment');
$routes->get('paypal/execute-payment', 'PayPalController::executePayment');


$routes->post('stripe/createCheckoutSession', 'StripeController::createCheckoutSession');
$routes->get('success', 'StripeController::success');
$routes->get('cancel', 'StripeController::cancel');
$routes->post('stripe/webhook', 'StripeController::stripeWebhook');
$routes->get('thankyou', 'StripeController::success');


$routes->get('/order/success', 'OrderController::success');
$routes->get('/order/history', 'OrderController::history');
