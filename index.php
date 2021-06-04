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
$router->get('/logout', 'LoginController@logout');
$router->post('/login', 'LoginController@connect', 'login.connect');
$router->get('/register', 'LoginController@register');
$router->post('/register', 'LoginController@registered');
$router->get('/forgot-password', 'LoginController@forgotpassword');
$router->post('/forgot-password', 'LoginController@retrievepassword');

// ROUTER POSTS - posts
$router->get('/admin/posts', 'PostsController@list', 'posts.list');
$router->get('/admin/posts/:id', 'PostsController@edit', 'posts.edit')->with('id', '[0-9]+');
$router->post('/admin/posts/:id', 'PostsController@update', 'posts.update')->with('id', '[0-9]+');
$router->get('/admin/posts/:action', 'PostsController@new', 'posts.new')->with('action', '([a-z\-0-9]+)');
$router->post('/admin/posts/:action', 'PostsController@insert', 'posts.insert')->with('action', '([a-z\-0-9]+)');

// ROUTER USERS - users
$router->get('/admin/users', 'UsersController@list', 'users.list');
$router->get('/admin/users/:id', 'UsersController@edit', 'users.edit')->with('id', '[0-9]+');
$router->post('/admin/users/:id', 'UsersController@update', 'users.update')->with('id', '[0-9]+');
$router->get('/admin/users/:action', 'UsersController@new', 'users.new')->with('action', '([a-z\-0-9]+)');
$router->post('/admin/users/:action', 'UsersController@insert', 'users.insert')->with('action', '([a-z\-0-9]+)');

// ROUTER COMMENTS - comments
$router->get('/admin/comments', 'CommentsController@list', 'comments.list');
$router->get('/admin/comments/:id', 'CommentsController@edit', 'comments.edit')->with('id', '[0-9]+');
$router->post('/admin/comments/:id', 'CommentsController@update', 'comments.update')->with('id', '[0-9]+');
$router->get('/admin/comments/:action', 'CommentsController@new', 'comments.new')->with('action', '([a-z\-0-9]+)');
$router->post('/admin/comments/:action', 'CommentsController@insert', 'comments.insert')->with('action', '([a-z\-0-9]+)');


$router->run();
exit;