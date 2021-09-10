<?php

namespace App\Entity;

use App\App;

/**
 * Class CommentEntity
 * @package App\Entity
 */
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
     * Allows you to generate the url to an instance
     * Permet de générer l'url vers une instance
     * @return string
     */
    public function url()
    {
        return App::url('admin/') . 'comments/' . $this->id;
    }


}
