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
    public $name;
    public $email;
    public $message;


    /**
     * Permet de générer l'url vers une instance
     * Allows you to generate the url to an instance
     * @return string
     */
    public function url()
    {
        return 'contact/' . $this->id;
    }


}
