<?php

namespace App\Entity;

use App\App;

class PostEntity extends Entity
{
    public $id;
    public $title;
    public $slug;
    public $introduction;
    public $content;
    public $author;
    public $status;
    public $created_at;
    public $modify_at;

    /**
     * Permet de générer l'url vers une instance // Allows you to generate the url to an instance
     * @return string
     */
    public function url()
    {
        return 'posts/'.$this->id;
    }

}
