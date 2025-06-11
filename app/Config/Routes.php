<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// FORM REGISTRATION
$routes->get('/getformregistration', 'Formapply::fn_getdataregistration');
$routes->post('submitdataregistration', 'Formapply::fn_submitdataregistration');
$routes->post('/comfirmemail', 'Formapply::fn_comfirmemail');
$routes->post('/comfirmotp', 'Formapply::fn_comfirmotp');


// Dashboard
$routes->get('/jobs/pages', 'Home::fn_getpages');


//Admin
// $routes->get('/admin', 'Admin::fn_getadminpanel');






// Login

$routes->group('', ['filter' => 'afterlogin'], function ($routes) {
$routes->get('/login', 'Login::fn_getlogin');
$routes->get('auth/callback', 'Oauth::callback');
$routes->get('auth/login', 'Oauth::login');
$routes->post('auth/login', 'Oauth::fn_loginform');




});




// OAuth
$routes->get('/', 'Oauth::index');
$routes->get('logout', 'Oauth::logout');


$routes->group('/admin', ['filter' => 'beforelogin'], function ($routes) {
  $routes->get('dashboard', 'Admin::fn_getdashboard');
  $routes->get('defaultdashboard', 'Admin::fn_getdashboarddefault');
  $routes->get('newjobs', 'Admin::fn_getnewjobs');
  $routes->get('candidate', 'Admin::fn_getcandidate');
  $routes->get('candidate/getcandidate', 'Admin::getcandidate');
  $routes->post('candidate/view', 'Admin::fn_viewcandidate');
  $routes->get('file/viewbyfilename/(:any)', 'Admin::previewCandidateFile/$1');
  $routes->post('candidate/approve', 'Admin::fn_approvecandidate');
  $routes->post('candidate/reject', 'Admin::fn_rejectcandidate');
  $routes->post('candidate/detail', 'Admin::fn_detailcandidate');
  $routes->get('dashboard/getApplicationChartData', 'Admin::getApplicationChartData');
  $routes->get('dashboard/getGenderStats', 'Admin::getGenderStats');
  $routes->post('candidate/deletecandidate', 'Admin::fn_deletecandidate');
  $routes->get('changepw', 'Admin::fn_getchangepw');
  $routes->get('profile', 'Admin::fn_getprofile');
  $routes->get('managejobs', 'Admin::fn_getmanagejobs');
  $routes->get('managejobs/getmanagejob', 'Admin::fn_loadmanagejob');
  $routes->get('managejobs/getmanagedata', 'Admin::fn_getmanagedata');
  $routes->post('addnewjobs', 'Admin::fn_addnewjobs');
  $routes->post('managejobs/editjobs', 'Admin::fn_editJob');
  $routes->post('managejobs/updatejobs', 'Admin::fn_updateJob');
  $routes->post('managejobs/deleteJob', 'Admin::fn_deleteJob');
  $routes->post('managejobs/previewjobs', 'Admin::fn_previewJob');
  $routes->get('managejobs/searchjobs', 'Admin::fn_searchjobs');
  $routes->post('managejobs/updatestatus', 'Admin::updateJobStatus');
  $routes->post('candidate/bulk-action', 'Admin::fn_action');
  $routes->get('reports', 'Report::fn_report');
  $routes->get('report/getreport' , 'Report::fn_getreport');
  $routes->get('getCategoriesByGroup/(:num)', 'Admin::getCategoriesByGroup/$1');
  $routes->get('logo-base64', 'Report::logoBase64');

  $routes->get('administrator', 'Admin::fn_getadministrator');
  $routes->get('users-json', 'Oauth::fetchAzureUsers');
  $routes->post('addnewadmin', 'Admin::fn_addadministrator');

});











$routes->post('admin/login', 'Admin::fn_login');





