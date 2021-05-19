<?php

namespace App\Controller;

use App\Table\PostTable;

class PostsController extends Controller
{
    /**
     * @param $id
     */
    public function show($id)
    {
        $table = new PostTable();
        $post = $table->one($id);
        $pageTitle = $post->title;
        $this->render('single', ['pageTitle' => $pageTitle, 'id'=>$id, 'post' => $post], 'frontend');
    }

    /**
     *
     */
    public function all()
    {
        $table = new PostTable();
        $pageTitle = 'Mes articles';
        $this->render('posts', ['pageTitle' => $pageTitle, 'posts' => $table->findAll()], 'frontend');
    }
}