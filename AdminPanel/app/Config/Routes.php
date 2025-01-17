<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


$routes->get('/', 'Home::index');
$routes->post('/saveUser','Home::saveUser');
$routes->get('/getUser/(:num)','Home::getUser/$1');
$routes->post('/updateUser','Home::updateUser');
$routes->post('/deleteUser','Home::deleteUser');
$routes->post('/deleteAll','Home::deleteAll');
$routes->post('/filter','Home::filterUser');//?filter
$routes->post('/file_upload', 'Home::file_upload');
$routes->post('/upload','Home::upload');


//!login
$routes->get('login', 'Validation::login');//!first parameter is url name and second parameter function name
$routes->post('login','Validation::do_login');
$routes->get('register', 'Validation::register');
$routes->post('register','Validation::do_register');
$routes->post('dashboard','Validation::dashboard');
$routes->post('dashboard','Validation::dashboard');

//!campaign
$routes->get('/campaign', 'Campaign::index');
$routes->post('/saveCampaign','Campaign::saveCampaign');
$routes->get('/getCampaign/(:num)','Campaign::getCampaign/$1');
$routes->post('/updateCampaign','Campaign::updateCampaign');
$routes->post('/deleteCampaign','Campaign::deleteCampaign');
$routes->post('/deleteAllCampaign','Campaign::deleteAllCampaign');
$routes->post('/filterCampaign','Campaign::filterCampaign');

//!chat
$routes->get('/chat', 'Chat::index');

//! sql reports
$routes->get('/report_sql', 'Report::index'); // Route for SQL report
$routes->get('/apiSummary', 'Report::apiSummary'); // Route for API summary
$routes->get('/spreadsheet', 'Report::spreadsheet');
$routes->get('/spreadsheet_1','Report::summaryReport');
$routes->get('/summary_data','Report::view');
$routes->get('/filter','Report::filter');

//!elastic reports
$routes->get('/report_elastic', 'Elastic::index');
$routes->get('/apiSummary', 'Elastic::apiSummary'); // Route for API summary
$routes->get('/spreadsheet_elastic', 'Elastic::spreadsheet');
$routes->get('/spreadsheet_elastic_1','Elastic::summaryReport');
$routes->get('/summary_data_elastic','Elastic::view');
$routes->get('/filter','Elastic::filter');

//! mongo reports
$routes->get('/report_mongo', 'Mongo::index'); // Route for SQL report
$routes->get('/apiSummary', 'Mongo::apiSummary'); // Route for API summary
$routes->get('/spreadsheet_mongo', 'Mongo::spreadsheet');
$routes->get('/spreadsheet_mongo_1','Mongo::summaryReport');
$routes->get('/summary_data_mongo','Mongo::view');
$routes->get('/filter','Mongo::filter');

