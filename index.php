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
$router->get('/admin', 'AdminController@admin');

// ROUTER LOGIN
$router->get('/login', 'LoginController@login');
$router->post('/login', 'LoginController@connect', 'login.connect');
$router->get('/register', 'LoginController@register');
$router->get('/forgot-password', 'LoginController@forgotpassword');

// ROUTER POSTS - global
$router->get('/admin/:posts', 'PostsController@list', 'posts.list')->with('posts', '([a-z\-0-9]+)');
$router->get('/admin/:posts/:id', 'PostsController@edit', 'posts.edit')->with('posts', '([a-z\-0-9]+)')->with('id', '[0-9]+');
$router->post('/admin/:posts/:id', 'PostsController@update', 'posts.update')->with('posts', '([a-z\-0-9]+)')->with('id', '[0-9]+');
$router->get('/admin/:posts/:action', 'PostsController@new', 'posts.new')->with('posts', '([a-z\-0-9]+)')->with('action', '([a-z\-0-9]+)');
$router->post('/admin/:posts/:action', 'PostsController@insert', 'posts.insert')->with('posts', '([a-z\-0-9]+)')->with('action', '([a-z\-0-9]+)');

// ROUTER USERS - global
$router->get('/admin/:users', 'UsersController@list', 'users.list')->with('users', '([a-z\-0-9]+)');
$router->get('/admin/:users/:id', 'UsersController@edit', 'users.edit')->with('users', '([a-z\-0-9]+)')->with('id', '[0-9]+');
$router->post('/admin/:users/:id', 'UsersController@update', 'users.update')->with('users', '([a-z\-0-9]+)')->with('id', '[0-9]+');
$router->get('/admin/:users/:action', 'UsersController@new', 'users.new')->with('users', '([a-z\-0-9]+)')->with('action', '([a-z\-0-9]+)');
$router->post('/admin/:users/:action', 'UsersController@insert', 'users.insert')->with('users', '([a-z\-0-9]+)')->with('action', '([a-z\-0-9]+)');

// ROUTER COMMENTS - global
$router->get('/admin/:comments', 'CommentsController@list', 'comments.list')->with('comments', '([a-z\-0-9]+)');
$router->get('/admin/:comments/:id', 'CommentsController@edit', 'comments.edit')->with('comments', '([a-z\-0-9]+)')->with('id', '[0-9]+');
$router->post('/admin/:comments/:id', 'CommentsController@update', 'comments.update')->with('comments', '([a-z\-0-9]+)')->with('id', '[0-9]+');
$router->get('/admin/:comments/:action', 'CommentsController@new', 'comments.new')->with('comments', '([a-z\-0-9]+)')->with('action', '([a-z\-0-9]+)');
$router->post('/admin/:comments/:action', 'CommentsController@insert', 'comments.insert')->with('comments', '([a-z\-0-9]+)')->with('action', '([a-z\-0-9]+)');


$router->run();
exit;