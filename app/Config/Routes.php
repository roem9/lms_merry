<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

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
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index', ['filter' => 'auth']);
$routes->get('/home', 'Home::index', ['filter' => 'auth']);
$routes->get('/laporan', 'Home::laporan', ['filter' => 'auth']);
$routes->get('/exportLaporan/(.*)/(.*)', 'Home::exportLaporan/$1/$2', ['filter' => 'auth']);
$routes->get('/exportLaporanSubscription/(.*)/(.*)', 'Home::exportLaporanSubscription/$1/$2', ['filter' => 'auth']);
$routes->get('/home/laporanStatistik', 'Home::laporanStatistik', ['filter' => 'auth']);

$routes->get('/login', 'Login::index');
$routes->get('/logout', 'Login::logout');
$routes->get('/login/makeCookie/(.*)/(.*)', 'Login::makeCookie/$1/$2');
$routes->post('/login/auth', 'Login::auth');

$routes->get('/program', 'Program::index', ['filter' => 'auth']);
$routes->get('/program/getAllProgram', 'Program::getAllProgram', ['filter' => 'auth']);
$routes->get('/program/getListProgram/(.*)', 'Program::getListProgram/$1', ['filter' => 'auth']);
$routes->get('/program/getProgram/(.*)', 'Program::getProgram/$1', ['filter' => 'auth']);
$routes->get('/program/hapusProgram/(.*)', 'Program::hapusProgram/$1', ['filter' => 'auth']);
$routes->post('/program/simpan', 'Program::simpan', ['filter' => 'auth']);

$routes->get('/program/designProgram/(.*)', 'Program::designProgram/$1', ['filter' => 'auth']);
$routes->get('/program/getAllPertemuan/(.*)', 'Program::getAllPertemuan/$1', ['filter' => 'auth']);
$routes->post('/program/simpanPertemuanProgram', 'Program::simpanPertemuanProgram', ['filter' => 'auth']);
$routes->get('/program/getPertemuanProgram/(.*)', 'Program::getPertemuanProgram/$1', ['filter' => 'auth']);
$routes->get('/program/hapusPertemuanProgram/(.*)', 'Program::hapusPertemuanProgram/$1', ['filter' => 'auth']);
$routes->post('/program/ubahUrutan', 'Program::ubahUrutan', ['filter' => 'auth']);

$routes->get('/program/materiPertemuan/(.*)', 'Program::materiPertemuan/$1', ['filter' => 'auth']);
$routes->post('/program/simpanMateriPertemuan', 'Program::simpanMateriPertemuan', ['filter' => 'auth']);
$routes->get('/program/getAllMateriPertemuan/(.*)', 'Program::getAllMateriPertemuan/$1', ['filter' => 'auth']);
$routes->post('/program/ubahUrutanMateri', 'Program::ubahUrutanMateri', ['filter' => 'auth']);
$routes->get('/program/hapusMateriPertemuan/(.*)', 'Program::hapusMateriPertemuan/$1', ['filter' => 'auth']);
$routes->get('/program/getMateriPertemuan/(.*)', 'Program::getMateriPertemuan/$1', ['filter' => 'auth']);

$routes->get('/program/latihanPertemuan/(.*)', 'Program::latihanPertemuan/$1', ['filter' => 'auth']);
$routes->post('/program/simpanLatihanPertemuan', 'Program::simpanLatihanPertemuan', ['filter' => 'auth']);
$routes->get('/program/getAllLatihanPertemuan/(.*)', 'Program::getAllLatihanPertemuan/$1', ['filter' => 'auth']);
$routes->post('/program/ubahUrutanLatihan', 'Program::ubahUrutanLatihan', ['filter' => 'auth']);
$routes->get('/program/hapusLatihanPertemuan/(.*)', 'Program::hapusLatihanPertemuan/$1', ['filter' => 'auth']);
$routes->get('/program/getLatihanPertemuan/(.*)', 'Program::getLatihanPertemuan/$1', ['filter' => 'auth']);

$routes->get('/pengajar', 'Pengajar::index', ['filter' => 'auth']);
$routes->get('/pengajar/getListPengajar', 'Pengajar::getListPengajar', ['filter' => 'auth']);
$routes->get('/pengajar/getPengajar/(.*)', 'Pengajar::getPengajar/$1', ['filter' => 'auth']);
$routes->get('/pengajar/hapusPengajar/(.*)', 'Pengajar::hapusPengajar/$1', ['filter' => 'auth']);
$routes->post('/pengajar/simpan', 'Pengajar::simpan', ['filter' => 'auth']);
$routes->post('/pengajar/editStatusPengajar', 'Pengajar::editStatusPengajar', ['filter' => 'auth']);


$routes->get('/member', 'Member::index', ['filter' => 'auth']);
$routes->get('/member/subscription', 'Member::subscription', ['filter' => 'auth']);
$routes->get('/member/kelas', 'Member::kelas', ['filter' => 'auth']);
// $routes->get('/member/list/(.*)', 'Member::list/$1', ['filter' => 'auth']);
$routes->get('/member/getListMember', 'Member::getListMember', ['filter' => 'auth']);
$routes->get('/member/getListMemberSubscription', 'Member::getListMemberSubscription', ['filter' => 'auth']);
$routes->get('/member/getListMemberKelas', 'Member::getListMemberKelas', ['filter' => 'auth']);
$routes->get('/member/getMember/(.*)', 'Member::getMember/$1', ['filter' => 'auth']);
$routes->get('/member/hapusMember/(.*)', 'Member::hapusMember/$1', ['filter' => 'auth']);
$routes->get('/member/getKelasOfMember/(.*)', 'Member::getKelasOfMember/$1', ['filter' => 'auth']);
$routes->get('/member/getSubscriptionMember/(.*)', 'Member::getSubscriptionMember/$1', ['filter' => 'auth']);
$routes->post('/member/simpan', 'Member::simpan', ['filter' => 'auth']);
$routes->post('/member/simpanSubscriptionOfMember', 'Member::simpanSubscriptionOfMember', ['filter' => 'auth']);
$routes->post('/member/tambahKelasOfMember', 'Member::tambahKelasOfMember', ['filter' => 'auth']);
$routes->get('/member/hapusKelasOfMember/(.*)', 'Member::hapusKelasOfMember/$1', ['filter' => 'auth']);
$routes->get('/member/hapusSubscriptionOfMember/(.*)', 'Member::hapusSubscriptionOfMember/$1', ['filter' => 'auth']);
$routes->post('/member/editStatusMember', 'Member::editStatusMember', ['filter' => 'auth']);

$routes->post('kelas/changePeriode', 'Kelas::changePeriode', ['filter' => 'auth']); 
$routes->get('/kelas', 'Kelas::index', ['filter' => 'auth']);
// $routes->get('/kelas/list/(.*)', 'Kelas::list/$1', ['filter' => 'auth']);
$routes->get('/kelas/getListKelas', 'Kelas::getListKelas', ['filter' => 'auth']);
$routes->post('/kelas/simpan', 'Kelas::simpan', ['filter' => 'auth']);
$routes->get('/kelas/getKelas/(.*)', 'Kelas::getKelas/$1', ['filter' => 'auth']);
$routes->get('/kelas/hapusKelas/(.*)', 'Kelas::hapusKelas/$1', ['filter' => 'auth']);
$routes->post('/kelas/editStatusKelas', 'Kelas::editStatusKelas', ['filter' => 'auth']);
$routes->get('/kelas/getMemberOfKelas/(.*)', 'Kelas::getMemberOfKelas/$1', ['filter' => 'auth']);
$routes->get('/kelas/hapusMemberOfKelas/(.*)', 'Kelas::hapusMemberOfKelas/$1', ['filter' => 'auth']);
$routes->get('/kelas/getListKelasOption', 'Kelas::getListKelasOption', ['filter' => 'auth']);

$routes->get('/myClass', 'MemberArea::myClass', ['filter' => 'authMember']);
$routes->get('/mySubscription', 'MemberArea::mySubscription', ['filter' => 'authMember']);
$routes->get('/myProfile', 'MemberArea::myProfile', ['filter' => 'authMember']);
$routes->get('/memberArea/getAllKelas', 'MemberArea::getAllKelas', ['filter' => 'authMember']);
$routes->get('/memberArea/getAllSubscription', 'MemberArea::getAllSubscription', ['filter' => 'authMember']);
$routes->get('/class/(.*)', 'MemberArea::class/$1', ['filter' => 'authMember']);
$routes->get('/subscription/(.*)', 'MemberArea::subscription/$1', ['filter' => 'authMember']);
$routes->get('/materi/(.*)', 'MemberArea::materi/$1', ['filter' => 'authMember']);
$routes->get('/materisubscription/(.*)', 'MemberArea::materiSubscription/$1', ['filter' => 'authMember']);
$routes->get('/latihan/(.*)/(.*)', 'MemberArea::latihan/$1/$2', ['filter' => 'authMember']);
$routes->get('/latihansubscription/(.*)/(.*)', 'MemberArea::latihanSubscription/$1/$2', ['filter' => 'authMember']);
$routes->post('/addLatihan', 'MemberArea::addLatihan', ['filter' => 'authMember']);
$routes->post('/addLatihanSubscription', 'MemberArea::addLatihanSubscription', ['filter' => 'authMember']);
$routes->get('/materiSelesai/(.*)', 'MemberArea::materiSelesai/$1', ['filter' => 'authMember']);
$routes->get('/materiSubscriptionSelesai/(.*)', 'MemberArea::materiSubscriptionSelesai/$1', ['filter' => 'authMember']);
$routes->get('/sertifikat/(.*)', 'MemberArea::sertifikat/$1', ['filter' => 'authMember']);
$routes->get('/sertifikatsubscription/(.*)', 'MemberArea::sertifikatSubscription/$1', ['filter' => 'authMember']);
$routes->get('/report/(.*)', 'MemberArea::report/$1');
$routes->get('/reportsubscription/(.*)', 'MemberArea::reportSubscription/$1');

$routes->get('/p/myClass', 'PengajarArea::myClass', ['filter' => 'authPengajar']);
$routes->get('/p/myProfile', 'PengajarArea::myProfile', ['filter' => 'authPengajar']);
$routes->get('/pengajarArea/getAllKelas', 'PengajarArea::getAllKelas', ['filter' => 'authPengajar']);
$routes->post('pengajarArea/changePeriode', 'PengajarArea::changePeriode', ['filter' => 'authPengajar']); 

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
