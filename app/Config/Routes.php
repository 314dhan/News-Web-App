<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//view news
$routes->get('/', 'HomeController::index');
$routes->post('/search', 'HomeController::search');
// Comment

$routes->post('comment/add/(:segment)', 'CommentController::addComment/$1');
$routes->get('comment/delete/(:num)', 'CommentController::deleteComment/$1');
// News
$routes->group('news', function ($routes)
{
    $routes->get('detail/(:num)', 'NewsController::detail/$1');
    $routes->get('by_category/(:num)', 'HomeController::newsByCategory/$1');
    $routes->get('category/(:num)', 'NewsController::showByCategory/$1');
});

//auth
$routes->group('auth', function ($routes) {
    $routes->get('create', 'NewsController::create');
    $routes->post('create', 'NewsController::create');
    $routes->get('update/(:num)', 'NewsController::update/$1');
    $routes->post('update/(:num)', 'NewsController::update/$1');
    $routes->post('delete/(:num)', 'NewsController::delete/$1');
    $routes->get('login', 'AuthController::login');
    $routes->post('login', 'AuthController::login');
    $routes->get('manajement', 'HomeController::indexAuthor');
    $routes->get('register', 'AuthController::register');
    $routes->post('register', 'AuthController::register');
    $routes->get('logout', 'AuthController::logout');
    $routes->get('users', 'HomeController::users');
});

$routes->get('delete/(:num)', 'HomeController::deleteUser/$1');