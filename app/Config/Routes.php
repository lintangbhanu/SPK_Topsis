<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/auth/prosesLogin', 'Auth::prosesLogin');
$routes->get('/logout', 'Auth::logout');
$routes->get('/dashboard', 'Dashboard::index');

$routes->get('/user', 'User::index');
$routes->get('/user/create', 'User::create');
$routes->post('/user/store', 'User::store');
$routes->get('/user/edit/(:num)', 'User::edit/$1');
$routes->post('/user/update/(:num)', 'User::update/$1');
$routes->get('/user/delete/(:num)', 'User::delete/$1');

$routes->get('/role', 'Role::index');
$routes->get('/role/create', 'Role::create');
$routes->post('/role/store', 'Role::store');
$routes->get('/role/edit/(:segment)', 'Role::edit/$1');
$routes->post('/role/update/(:segment)', 'Role::update/$1');
$routes->get('/role/delete/(:segment)', 'Role::delete/$1');

$routes->get('/pemain', 'Pemain::index');
$routes->get('/pemain/create', 'Pemain::create');
$routes->post('/pemain/store', 'Pemain::store');
$routes->get('/pemain/edit/(:segment)', 'Pemain::edit/$1');
$routes->post('/pemain/update/(:segment)', 'Pemain::update/$1');
$routes->get('/pemain/delete/(:segment)', 'Pemain::delete/$1');

$routes->get('/heropool/index/(:segment)', 'HeroPool::index/$1');
$routes->get('/heropool/edit/(:num)', 'HeroPool::edit/$1');
$routes->post('/heropool/update/(:num)', 'HeroPool::update/$1');

$routes->get('/kriteria', 'Kriteria::index');
$routes->get('/kriteria/create', 'Kriteria::create');
$routes->post('/kriteria/store', 'Kriteria::store');
$routes->get('/kriteria/edit/(:segment)', 'Kriteria::edit/$1');
$routes->post('/kriteria/update/(:segment)', 'Kriteria::update/$1');
$routes->get('/kriteria/delete/(:segment)', 'Kriteria::delete/$1');

$routes->get('/bobot', 'Bobot::index');
$routes->post('/bobot/update', 'Bobot::update');

$routes->get('/scrim', 'Scrim::index');
$routes->get('/scrim/create', 'Scrim::create');
$routes->post('/scrim/store', 'Scrim::store');
$routes->get('/scrim/detail/(:num)', 'Scrim::detail/$1');
$routes->get('/scrim/edit/(:num)', 'Scrim::edit/$1');
$routes->post('/scrim/update/(:num)', 'Scrim::update/$1');
$routes->get('/scrim/delete/(:num)', 'Scrim::delete/$1');

$routes->get('/nilai', 'Nilai::index');
$routes->get('/nilai/detail/(:num)', 'Nilai::detail/$1');
$routes->get('/perhitungan', 'Topsis::Topsis');

$routes->get('/test-role', 'TestRole::index');
