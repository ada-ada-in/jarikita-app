    <?php

    use App\Controllers\PagesController;
    use CodeIgniter\Router\RouteCollection;

    /**
     * @var RouteCollection $routes
     */

    // admin
    $routes->group('admin', static function($routes) {
        $routes->get('dashboard', 'PagesController::admin', ['as' => 'admin']);
        $routes->get('log', 'PagesController::log', ['as' => 'log']);
        $routes->get('jasa', 'PagesController::jasa', ['as' => 'jasa']);
        $routes->get('disposisi', 'PagesController::disposisi', ['as' => 'disposisi']);
        $routes->get('pengguna', 'PagesController::pengguna', ['as' => 'pengguna']);
        $routes->get('lokasi', 'PagesController::lokasi', ['as' => 'lokasi']);
        $routes->get('profile', 'PagesController::profile', ['as' => 'profile']);
    });

    $routes->group('/', static function($routes){
        $routes->get('', 'PagesController::main', ['as' => 'main']);
    });


    // auth
    $routes->group('auth', static function($routes){
        $routes->get('login', 'PagesController::login', ['as' => 'login']);
        $routes->get('register', 'PagesController::register', ['as' => 'register']);
    });