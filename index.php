<?php

require 'vendor/autoload.php';

$router = new App\Router\Router($_GET['url']);

// ROUTER FRONT
$router->get('/', 'HomeController@home');
$router->get('/posts', 'PostsController@all');
$router->get('/contact', 'GlobalController@contact');
$router->get('/404', 'GlobalController@notFound');
$router->get('/posts/:id', 'PostsController@show', 'posts.show')->with('id', '[0-9]+');
$router->post('/posts/:id', 'PostsController@addComment', 'posts.addComment')->with('id', '[0-9]+');

// ROUTER ADMIN - global
$router->get('/404-admin', 'AdminController@notFound');
$router->get('/login', 'AdminController@login');
$router->post('/login', 'AdminController@connect', 'admin.connect');
$router->get('/register', 'AdminController@register');
$router->get('/forgot-password', 'AdminController@forgotpassword');
$router->get('/admin', 'AdminController@admin');

$router->get('/admin/:type', 'AdminController@list', 'admin.list')->with('type', '([a-z\-0-9]+)');
$router->get('/admin/:type/:id', 'AdminController@edit', 'admin.edit')->with('type', '([a-z\-0-9]+)')->with('id', '[0-9]+');
$router->post('/admin/:type/:id', 'AdminController@update', 'admin.update')->with('type', '([a-z\-0-9]+)')->with('id', '[0-9]+');
$router->get('/admin/:type/:action', 'AdminController@new', 'admin.new')->with('type', '([a-z\-0-9]+)')->with('action', '([a-z\-0-9]+)');
$router->post('/admin/:type/:action', 'AdminController@insert', 'admin.insert')->with('type', '([a-z\-0-9]+)')->with('action', '([a-z\-0-9]+)');

//$router->get('/admin/posts', 'AdminController@listPosts', 'admin.listPosts');

$router->run();
exit;