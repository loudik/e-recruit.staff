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


//Admin
$routes->get('/admin', 'Admin::fn_getadminpanel');
$routes->get('/admin/dashboard', 'Admin::fn_getdashboard');
$routes->get('/admin/newjobs', 'Admin::fn_getnewjobs');
$routes->get('/admin/candidate', 'Admin::fn_getcandidate');
$routes->get('/admin/candidate/getcandidate', 'Admin::getcandidate');
$routes->post('/admin/candidate/view', 'Admin::fn_viewcandidate');
$routes->get('file/view/(:num)/(:segment)', 'Admin::viewFile/$1/$2');
$routes->post('/admin/candidate/deletecandidate', 'Admin::fn_deletecandidate');
$routes->get('/admin/changepw', 'Admin::fn_getchangepw');
$routes->get('/admin/profile', 'Admin::fn_getprofile');
$routes->get('/admin/managejobs', 'Admin::fn_getmanagejobs');
$routes->get('/admin/managejobs/getmanagejob', 'Admin::fn_loadmanagejob');

$routes->post('admin/addnewjobs', 'Admin::fn_addnewjobs');
$routes->post('admin/managejobs/editjobs', 'Admin::fn_editJob');
$routes->post('admin/managejobs/updatejobs', 'Admin::fn_updateJob');
$routes->post('admin/managejobs/deleteJob', 'Admin::fn_deleteJob');
$routes->post('admin/managejobs/previewjobs', 'Admin::fn_previewJob');



$routes->post('admin/login', 'Admin::fn_login');





