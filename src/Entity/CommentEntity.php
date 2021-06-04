<?php

namespace App\Entity;

use App\App;

class CommentEntity extends Entity
{
    public $id;
    public $author;
    public $comment;
    public $article_id;
    public $status;
    public $reply_to;
    public $created_at;

    /**
     * Permet de générer l'url vers une instance // Allows you to generate the url to an instance
     * @return string
     */
    public function url()
    {
        return 'comments/' . $this->id;
    }


}
