<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// FORM REGISTRATION
$routes->get('/getformregistration', 'Formapply::fn_getdataregistration');
$routes->post('/submitdataregistration', 'Formapply::fn_submitdataregistration');


//Admin
$routes->get('/admin', 'Admin::fn_getadminpanel');
$routes->get('/admin/dashboard', 'Admin::fn_getdashboard');
$routes->get('/admin/newjobs', 'Admin::fn_getnewjobs');
$routes->get('/admin/candidate', 'Admin::fn_getcandidate');
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





