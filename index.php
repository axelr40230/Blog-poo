<?php
require 'vendor/autoload.php';

//die($_GET['url']);

$router = new App\Router\Router($_GET['url']);

$router->get('/', 'HomeController@home');
//$router->get('/:name', 'HomeController@hello');
$router->get('/posts', 'PostsController@all');
$router->get('/posts/:id-:slug', 'PostsController@show', 'posts.show')->with('id', '[0-9]+')->with('slug', '[a-z\-0-9]+');
$router->post('/posts', 'PostsController@create');

$router->run();


