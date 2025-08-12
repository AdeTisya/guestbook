    <?php

    use CodeIgniter\Router\RouteCollection;

    /**
     * @var RouteCollection $routes
     */ 
    // akses base url,siapapun yang akses baseurl maka diarahkan ke Controller Home fungsi index
    // $routes->get('/', 'Home::index');


    //===========================================================================================
    // user mengakses root URL (/)
    // Menjalankan filter cek_percobaan_login  terlebih dahulu
    // Kemudian ke method index di controller Auth\Login


    $routes->get('/', 'User\UserForm::index');
     // Route untuk menampilkan form
    $routes->get('user/form', 'User\UserForm::index');

    // Route untuk memproses submit form (POST)
   $routes->post('user/form', 'User\UserForm::submitForm');


$routes->group('admin', ['filter' => 'auth'], function($routes) {
    // Dashboard
    $routes->get('/', 'Admin\Dashboard::index');
    
    // Tamu routes
    $routes->group('tamu', function($routes) {
        $routes->get('detail/(:num)', 'Admin\Dashboard::detail/$1');
        $routes->get('delete/(:num)', 'Admin\Dashboard::delete/$1');
        $routes->get('print/(:num)', 'Admin\Dashboard::print/$1');
    });
    
    // Export route
    $routes->post('export', 'Admin\Dashboard::export');
});


    // akses base url,siapapun yang akses baseurl maka diarahkan ke Controller Auth fungsi index
    $routes->get('login', 'Auth\Login::index', ['filter' => 'cek_percobaan_login']);



    //===========================================================================================
    // user submit, POST request ke /trxlogin)
    // Menjalankan filter cek_percobaan_login terlebih dahulu
    // Kemudian mengarahkan ke method eseclogin di controller Auth\Login
    $routes->post('/trxlogin', 'Auth\Login::eseclogin', ['filter' => 'cek_percobaan_login']);
    

    //===========================================================================================
    // RUTE HALAMAN TERKUNCI
    // Ketika user diarahkan ke halaman locked

    $routes->get('/locked', // Pattern URL: /locked
    'Auth\Login::locked'); // Target: Auth/Login controller, method locked()


// Route untuk logout 
$routes->get('logout', 'Auth\Login::logout');
$routes->post('logout', 'Auth\Login::logout');


    // Route untuk memproses submit form
    // $routes->post('user/form/submit', 'User\UserForm::submitForm');

