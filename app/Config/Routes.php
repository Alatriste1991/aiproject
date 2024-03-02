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
