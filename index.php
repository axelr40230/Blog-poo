<?php

require 'vendor/autoload.php';

$router = new App\Router\Router($_GET['url']);

// ROUTER FRONT
$router->get('/', 'HomeController@home');
$router->get('/posts', 'PostsController@all');
$router->get('/contact', 'GlobalController@contact');
$router->post('/contact', 'GlobalController@sendContact');
$router->get('/404', 'GlobalController@notFound');
$router->get('/posts/:slug', 'PostsController@show', 'posts.show')->with('action', '([a-z\-0-9]+)');
$router->post('/posts/:slug', 'CommentsController@addComment', 'comments.addComment')->with('slug', '([a-z\-0-9]+)');
$router->get('/confirmation', 'CommentsController@confirm');

// ROUTER ADMIN - global
$router->get('admin/404', 'AdminController@notFound');
$router->get('/admin', 'AdminController@admin');

// ROUTER LOGIN
$router->get('/login', 'LoginController@login');
$router->get('/logout', 'LoginController@logout');
$router->post('/login', 'LoginController@connect', 'login.connect');
$router->get('/register', 'LoginController@register');
$router->get('/confirm', 'LoginController@confirm');
$router->get('/confirmed', 'LoginController@confirmed');
$router->post('/register', 'LoginController@registered');
$router->get('/forgot-password', 'LoginController@forgotpassword');
$router->post('/forgot-password', 'LoginController@retrievepassword');
$router->get('/change', 'LoginController@changePassword');
$router->post('/change', 'LoginController@changedPassword');


// ROUTER POSTS - posts
$router->get('/admin/posts', 'PostsController@list', 'posts.list');
$router->get('/admin/posts/corbeille', 'PostsController@trash', 'posts.trash');
$router->get('/admin/posts/brouillons', 'PostsController@draft', 'posts.draft');
$router->get('/admin/posts/publies', 'PostsController@publish', 'posts.publish');
$router->get('/admin/posts/corbeille', 'PostsController@trash', 'posts.trash');
$router->get('/admin/posts/edit/:slug', 'PostsController@edit', 'posts.edit')->with('slug', '([a-z\-0-9]+)');
$router->get('/admin/posts/delete/:slug', 'PostsController@delete', 'posts.delete')->with('slug', '([a-z\-0-9]+)');
$router->post('/admin/posts/edit/:slug', 'PostsController@update', 'posts.update')->with('slug', '([a-z\-0-9]+)');
$router->get('/admin/posts/insert', 'PostsController@new', 'posts.new');
$router->post('/admin/posts/insert', 'PostsController@insert', 'posts.insert');

// ROUTER USERS - users
$router->get('/admin/users', 'UsersController@list', 'users.list');
$router->get('/admin/users/:id', 'UsersController@edit', 'users.edit')->with('id', '[0-9]+');
$router->post('/admin/users/:id', 'UsersController@update', 'users.update')->with('id', '[0-9]+');
$router->get('/admin/users/delete/:id', 'UsersController@delete', 'users.delete')->with('id', '[0-9]+');
$router->get('/admin/users/:action', 'UsersController@new', 'users.new')->with('action', '([a-z\-0-9]+)');
$router->post('/admin/users/:action', 'UsersController@insert', 'users.insert')->with('action', '([a-z\-0-9]+)');

// ROUTER COMMENTS - comments
$router->get('/admin/comments', 'CommentsController@list', 'comments.list');
$router->get('/admin/comments/:id', 'CommentsController@edit', 'comments.edit')->with('id', '[0-9]+');
$router->post('/admin/comments/:id', 'CommentsController@update', 'comments.update')->with('id', '[0-9]+');


$router->run();
exit;