<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ===========================================================================================
// Akses base URL diarahkan ke Controller User\UserForm fungsi index
$routes->get('/', 'User\UserForm::index');

// Route untuk menampilkan form
$routes->get('user/form', 'User\UserForm::index');

// Route untuk memproses submit form (POST)
$routes->post('user/form/submit', 'User\UserForm::submitForm');


// ===========================================================================================
// Akses halaman login dengan filter 'cek_percobaan_login'
$routes->get('login', 'Auth\Login::index', ['filter' => 'cek_percobaan_login']);

// ===========================================================================================
// User submit POST ke /trxlogin dengan filter 'cek_percobaan_login'
$routes->post('/trxlogin', 'Auth\Login::eseclogin', ['filter' => 'cek_percobaan_login']);

// ===========================================================================================
// Rute halaman terkunci
$routes->get('/locked', 'Auth\Login::locked');

// ===========================================================================================
// Route logout (GET & POST)
$routes->get('logout', 'Auth\Login::logout');
$routes->post('logout', 'Auth\Login::logout');


// ===========================================================================================
// Grup route admin dengan filter 'auth'
$routes->group('admin', ['filter' => 'auth'], function($routes) {

    // Dashboard
    $routes->get('/', 'Admin\Dashboard::index');

    // Grup route tamu
    $routes->group('tamu', function($routes) {
        $routes->get('detail/(:num)', 'Admin\Dashboard::detail/$1');
        $routes->get('delete/(:num)', 'Admin\Dashboard::delete/$1');
        $routes->get('print/(:num)', 'Admin\Dashboard::print/$1');
    });

    // Export route
    $routes->post('export', 'Admin\Dashboard::export');
});

// ===========================================================================================
// Route cadangan untuk submit form user (dikomentari)
// $routes->post('user/form/submit', 'User\UserForm::submitForm');
