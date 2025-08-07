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
    


    // API
    $routes->group('api/v1', static function($routes) {
        $routes->group('auth', static function($routes) {
            $routes->post('login', 'Api\V1\AuthController::login', ['as' => 'api.auth.login']);
            $routes->post('register', 'Api\V1\AuthController::register', ['as' => 'api.auth.register']);
            $routes->post('logout', 'Api\V1\AuthController::logout', ['as' => 'api.auth.logout']);
        });

        $routes->group('users', static function($routes) {
            $routes->get('', 'Api\V1\UsersController::getDataUser', ['as' => 'api.users.getDataUser']);
            $routes->get('profile', 'Api\V1\UsersController::getDataUserProfile', ['as' => 'api.users.getDataUserProfile']);
            $routes->put('profile/update', 'Api\V1\UsersController::getDataUserProfileById', ['as' => 'api.users.getDataUserProfileById']);
            $routes->get('countuser', 'Api\V1\UsersController::countUser', ['as' => 'api.users.countUser']);
            $routes->get('(:num)', 'Api\V1\UsersController::getDataUserById/$1', ['as' => 'api.users.getDataUserById']);
            $routes->delete('(:num)', 'Api\V1\UsersController::deleteDataUserById/$1', ['as' => 'api.userss.deleteDataUserById']);
            $routes->post('(:num)', 'Api\V1\UsersController::updateDataUserById/$1', ['as' => 'api.users.updateDataUserById']);
        });

        $routes->group('log', static function($routes) {
            $routes->post('', 'Api\V1\LogController::createLog', ['as' => 'api.log.createLog']);
            $routes->get('', 'Api\V1\LogController::getDataLog', ['as' => 'api.log.getDataLog']);
            $routes->get('countlog', 'Api\V1\LogController::countLog', ['as' => 'api.log.countLog']);
            $routes->get('(:num)', 'Api\V1\LogController::getDataLogById/$1', ['as' => 'api.log.getDataLogById']);
            $routes->delete('(:num)', 'Api\V1\LogController::deleteDataLogById/$1', ['as' => 'api.log.deleteDataLogById']);
            $routes->put('(:num)', 'Api\V1\LogController::updateDataLogById/$1', ['as' => 'api.log.updateDataLogById']);
        });


         $routes->group('lokasi', static function($routes) {
            $routes->post('', 'Api\V1\LokasiController::createLokasi', ['as' => 'api.lokasi.createLokasi']);
            $routes->get('', 'Api\V1\LokasiController::getDataLokasi', ['as' => 'api.lokasi.getDataLokasi']);
            $routes->get('countlokasi', 'Api\V1\LokasiController::countLokasi', ['as' => 'api.lokasi.countLokasi']);
            $routes->get('(:num)', 'Api\V1\LokasiController::getDataLokasiById/$1', ['as' => 'api.lokasi.getDataLokasiById']);
            $routes->delete('(:num)', 'Api\V1\LokasiController::deleteDataLokasiById/$1', ['as' => 'api.lokasi.deleteDataLokasiById']);
            $routes->put('(:num)', 'Api\V1\LokasiController::updateDataLokasiById/$1', ['as' => 'api.lokasi.updateDataLokasiById']);
        });

         $routes->group('review', static function($routes) {
            $routes->post('', 'Api\V1\ReviewController::createReview', ['as' => 'api.review.createReview']);
            $routes->get('', 'Api\V1\ReviewController::getDataReview', ['as' => 'api.review.getDataReview']);
            $routes->get('countreview', 'Api\V1\ReviewController::countReview',     ['as' => 'api.review.countReview']);
            $routes->get('(:num)', 'Api\V1\ReviewController::getDataReviewById/$1', ['as' => 'api.review.getDataReviewById']);
            $routes->delete('(:num)', 'Api\V1\ReviewController::deleteDataReviewById/$1', ['as' => 'api.review.deleteDataReviewById']);
            $routes->put('(:num)', 'Api\V1\ReviewController::updateDataReviewById/$1', ['as' => 'api.review.updateDataReviewById']);
        });

         $routes->group('layanan', static function($routes) {
            $routes->post('', 'Api\V1\LayananController::createLayanan', ['as' => 'api.layanan.createLayanan']);
            $routes->get('', 'Api\V1\LayananController::getDataLayanan', ['as' => 'api.layanan.getDataLayanan']);
            $routes->get('countlayanan', 'Api\V1\LayananController::countLayanan',     ['as' => 'api.layanan.countLayanan']);
            $routes->get('(:num)', 'Api\V1\LayananController::getDataLayananById/$1', ['as' => 'api.layanan.getDataLayananById']);
            $routes->delete('(:num)', 'Api\V1\LayananController::deleteDataLayananById/$1', ['as' => 'api.layanan.deleteDataLayananById']);
            $routes->post('(:num)', 'Api\V1\LayananController::updateDataLayananById/$1', ['as' => 'api.layanan.updateDataLayananById']);
        });

    });