<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('auth/logout', 'Auth::logout');

$routes->group('user',['filter'=>'AuthCheckFilter'], function($routes){
    $routes->get('home','UserController::index',['as'=>'user.home']);
    $routes->get('profile','UserController::profile',['as'=>'user.profile']);
    //회원 리스트
    $routes->get('members','UserController::members',['as'=>'members']);
    //국가 리스트 CRUD API
    $routes->get('countries','UserController::countries',['as'=>'countries']);
    $routes->post('addCountry','UserController::addCountry',['as'=>'add.country']);
    $routes->get('getAllCountries','UserController::getAllCountries',['as'=>'get.all.countries']);
    $routes->post('getCountryInfo','UserController::getCountryInfo',['as'=>'get.country.info']);
    $routes->post('updateCountry','UserController::updateCountry',['as'=>'update.country']);
    $routes->post('deleteCountry','UserController::deleteCountry',['as'=>'delete.country']);
});

//로그인 Routing 
$routes->group('',['filter'=>'AlreadyLoggedInFilter'], function($routes){
    $routes->get('/', 'Auth::index');
    $routes->get('login', 'Auth::login');
    $routes->get('/auth', 'Auth::login');
    $routes->get('/auth/login', 'Auth::login');
    $routes->get('/auth/register', 'Auth::register');
    $routes->post('check', 'Auth::check');
    $routes->post('create', 'Auth::create');
});


// $routes->group('api', ['filter' => 'api-auth'], static function ($routes) {
//     $routes->resource('users');
// });
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
