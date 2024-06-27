<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->resource('pegawai',['controller'=>'PegawaiController']);
$routes->post('/pegawai/update/(:num)','PegawaiController::update/$1');

// $routes->get('/pegawai','PegawaiController::index');
// $routes->post('/pegawai','PegawaiController::create');
// $routes->put('/pegawai/(:num)','PegawaiController::update/$1');
// $routes->delete('/pegawai/(:num)','PegawaiController::delete/$1');
// $routes->get('/pegawai/(:num)','PegawaiController::show/$1');