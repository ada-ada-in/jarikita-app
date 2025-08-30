    <?php

    use App\Controllers\PagesController;
    use CodeIgniter\Router\RouteCollection;

    /**
     * @var RouteCollection $routes
     */

    // admin pages
    $routes->group('admin', ['filter' => 'admin'], static function($routes) {
        $routes->get('dashboard', 'PagesController::admin', ['as' => 'admin']);
        $routes->get('log', 'PagesController::log', ['as' => 'log']);
        $routes->get('jasa', 'PagesController::jasa', ['as' => 'jasa']);
        $routes->get('disposisi', 'PagesController::disposisi', ['as' => 'disposisi']);
        $routes->get('pengguna', 'PagesController::pengguna', ['as' => 'pengguna']);
        $routes->get('lokasi', 'PagesController::lokasi', ['as' => 'lokasi']);
        $routes->get('bannerpromo', 'PagesController::bannerpromo', ['as' => 'bannerpromo']);
        $routes->get('profile', 'PagesController::profile', ['as' => 'profile']);
        $routes->get('tanggungan', 'PagesController::tanggungan', ['as' => 'tanggungan']);
    });

    // seller pages
    $routes->group('users', ['filter' => 'seller'], static function($routes) {
        $routes->get('dashboard', 'PagesController::dashboardSeller', ['as' => 'dashboardSeller']);
        $routes->get('jasa', 'PagesController::jasaSeller', ['as' => 'jasaSeller']);
        $routes->get('profile', 'PagesController::profileSeller', ['as' => 'profileSeller']);
    });

    // staff pages
    $routes->group('staff', ['filter' => 'staff'], static function($routes) {
        $routes->get('dashboard', 'PagesController::dashboardStaff', ['as' => 'dashboardStaff']);
        $routes->get('tanggungan', 'PagesController::tanggunganStaff', ['as' => 'tanggunganStaff']);
        $routes->get('log', 'PagesController::logStaff', ['as' => 'logStaff']);
        $routes->get('jasa', 'PagesController::jasaStaff', ['as' => 'jasaStaff']);
    });

    // users pages
    $routes->group('/', static function($routes){
        $routes->get('', 'PagesController::main', ['as' => 'main']);
        $routes->get('profile/(:num)', 'PagesController::profilejasa/$ ', ['as' => 'profilejasa']);
        $routes->get('lokasi/(:num)', 'PagesController::lokasijasa/$1', ['as' => 'lokasijasa']);
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
            $routes->get('(:num)', 'Api\V1\UsersController::getDataUserById/$1', ['as' => 'api.users.getDataUserById']);
            $routes->get('countuser', 'Api\V1\UsersController::countUser', ['as' => 'api.users.countUser']);
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
            $routes->get('rating/(:num)', 'Api\V1\ReviewController::getDataRatingByLayanan/$1', ['as' => 'api.review.getDataRatingByLayanan']);
            $routes->get('layanan/(:num)', 'Api\V1\ReviewController::getDataReviewByLayanan/$1', ['as' => 'api.review.getDataReviewByLayanan']);
            $routes->get('countreview', 'Api\V1\ReviewController::countReview',     ['as' => 'api.review.countReview']);
            $routes->get('(:num)', 'Api\V1\ReviewController::getDataReviewById/$1', ['as' => 'api.review.getDataReviewById']);
            $routes->delete('(:num)', 'Api\V1\ReviewController::deleteDataReviewById/$1', ['as' => 'api.review.deleteDataReviewById']);
            $routes->put('(:num)', 'Api\V1\ReviewController::updateDataReviewById/$1', ['as' => 'api.review.updateDataReviewById']);
        });

         $routes->group('layanan', static function($routes) {
            $routes->post('', 'Api\V1\LayananController::createLayanan', ['as' => 'api.layanan.createLayanan']);
            $routes->get('', 'Api\V1\LayananController::getDataLayanan', ['as' => 'api.layanan.getDataLayanan']);
            $routes->get('users', 'Api\V1\LayananController::getDataLayananByUsers', ['as' => 'api.layanan.getDataLayananByUsers']);
            $routes->get('lokasi/(:num)', 'Api\V1\LayananController::getDataLayananByLokasiId/$1', ['as' => 'api.layanan.getDataLayananByLokasiId']);
            $routes->get('countlayanan', 'Api\V1\LayananController::countLayanan',     ['as' => 'api.layanan.countLayanan']);
            $routes->get('countlayanan/users', 'Api\V1\LayananController::countLayananByUsers',     ['as' => 'api.layanan.countLayananByUsers']);
            $routes->get('(:num)', 'Api\V1\LayananController::getDataLayananById/$1', ['as' => 'api.layanan.getDataLayananById']);
            $routes->delete('(:num)', 'Api\V1\LayananController::deleteDataLayananById/$1', ['as' => 'api.layanan.deleteDataLayananById']);
            $routes->post('(:num)', 'Api\V1\LayananController::updateDataLayananById/$1', ['as' => 'api.layanan.updateDataLayananById']);
        });

         $routes->group('jenisjasa', static function($routes) {
            $routes->post('', 'Api\V1\JenisJasaController::createJenisJasa', ['as' => 'api.jenisjasa.createJenisJasa']);
            $routes->get('', 'Api\V1\JenisJasaController::getDataJenisJasa', ['as' => 'api.jenisjasa.getDataJenisJasa']);
            $routes->get('lokasi/(:num)', 'Api\V1\JenisJasaController::getDataJenisJasaByLokasiId/$1', ['as' => 'api.jenisjasa.getDataJenisJasaByLokasiId']);
            $routes->get('countjenisjasa', 'Api\V1\JenisJasaController::countJenisJasa',     ['as' => 'api.jenisjasa.countJenisJasa']);
            $routes->get('countjenisjasa/users', 'Api\V1\JenisJasaController::countJenisJasaByUsers',     ['as' => 'api.jenisjasa.countJenisJasaByUsers']);
            $routes->get('(:num)', 'Api\V1\JenisJasaController::getDataJenisJasaById/$1', ['as' => 'api.jenisjasa.getDataJenisJasaById']);
            $routes->delete('(:num)', 'Api\V1\JenisJasaController::deleteDataJenisJasaById/$1', ['as' => 'api.jenisjasa.deleteDataJenisJasaById']);
            $routes->post('(:num)', 'Api\V1\JenisJasaController::updateDataJenisJasaById/$1', ['as' => 'api.jenisjasa.updateDataJenisJasaById']);
        });

         $routes->group('bannerpromo', static function($routes) {
            $routes->post('', 'Api\V1\BannerPromoController::createBannerPromo', ['as' => 'api.bannerpromo.createBannerPromo']);
            $routes->get('', 'Api\V1\BannerPromoController::getDataBannerPromo', ['as' => 'api.bannerpromo.getDataBannerPromo']);
            $routes->get('countbannerpromo', 'Api\V1\BannerPromoController::countBannerPromo',     ['as' => 'api.bannerpromo.countBannerPromo']);
            $routes->get('countbannerpromo/users', 'Api\V1\BannerPromoController::countBannerPromoByUsers',     ['as' => 'api.bannerpromo.countBannerPromoByUsers']);
            $routes->get('(:num)', 'Api\V1\BannerPromoController::getDataBannerPromoById/$1', ['as' => 'api.bannerpromo.getDataBannerPromoById']);
            $routes->delete('(:num)', 'Api\V1\BannerPromoController::deleteDataBannerPromoById/$1', ['as' => 'api.bannerpromo.deleteDataBannerPromoById']);
            $routes->post('(:num)', 'Api\V1\BannerPromoController::updateDataBannerPromoById/$1', ['as' => 'api.bannerpromo.updateDataBannerPromoById']);
        });

    }); 