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
$routes->get('/order_history/(:any)', 'Order::order_history/$1');

$routes->get('/generation', 'Image::generation');
$routes->post('/generate', 'Image::generate');
$routes->get('/image/(:any)', 'Image::image/$1');
$routes->get('/downloadImage/(:any)', 'Image::downloadImage/$1');
$routes->get('/generating_history/(:any)', 'Image::generating_history/$1');

$routes->get('/feedback', 'Feedback::index');
$routes->post('/feedbackpost', 'Feedback::feedbackpost');

//admin
$routes->get('/admin','AdminHome::checkadminpage');
$routes->get('/admin/login','AdminLogin::login');
$routes->post('/admin/login','AdminLogin::login');

$routes->get('/admin/dashboard','AdminHome::dashboard');
$routes->get('/admin/admins','AdminHome::admins');
$routes->get('/admin/admins/add','AdminHome::addUser');
$routes->post('/admin/admins/add','AdminHome::addUser');
$routes->get('/admin/admins/delete/(:any)','AdminHome::removeUser/$1');
$routes->get('/admin/admins/edit/(:any)','AdminHome::editUser/$1');

$routes->post('/admin/admins/edit/(:any)','AdminHome::editUser/$1');