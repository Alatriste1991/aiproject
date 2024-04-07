<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->set404Override(function (){
    return view('frontend/header')
        .view('error/404')
        .view('frontend/footer');
});
$routes->get('/', 'Home::index');
$routes->get('login', 'Home::login');
$routes->post('login', 'Home::login');
$routes->get('logout', 'Home::logout');
$routes->get('registration', 'User::registration');
$routes->post('registration', 'User::registration');
$routes->get('profile/(:any)', 'User::profile/$1');
$routes->get('/billing_address/(:any)', 'User::billing_address/$1');
$routes->get('/add_billing_address', 'User::add_billing_address');
$routes->post('/add_billing_address', 'User::add_billing_address');
$routes->get('/edit_billing_address/(:any)', 'User::edit_billing_address/$1');
$routes->get('/delete_billing_address/(:any)', 'User::delete_billing_address/$1');
$routes->get('/packages', 'Package::packages');
$routes->get('/get_package/(:any)', 'Package::get_package/$1');
$routes->post('/add_order', 'Order::add_order');
$routes->post('/select_addresses', 'Package::select_addresses');
