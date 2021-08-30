<?php

namespace App\Entity;

use App\App;

class UserEntity extends Entity
{
    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $status;
    public $created_at;

    /**
     * Permet de générer l'url vers une instance // Allows you to generate the url to an instance
     * @return string
     */
    public function url()
    {
        return App::url('admin/') .'users/' . $this->id;
    }


}
