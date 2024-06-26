<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// view
$routes->get('/', 'FileController::index');
$routes->get('/export', 'FileController::export');

// process
$routes->post('/upload', 'FileController::upload');
$routes->post('/process', 'FileController::prosesSemuaData');

