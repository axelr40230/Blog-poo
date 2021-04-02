<?php


namespace App\Controller;


class PostsController
{
    public function show($id)
    {
        echo "Je suis l'article $id";
    }

    public function all(){
       $posts = \find('articles');
       require 'templates/frontend/posts.php';
    }

    public function create()
    {
        echo 'crée un article';
    }

}