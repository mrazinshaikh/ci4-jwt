<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Users extends Entity
{
    protected $attributes = [
        'id' => null,
        'name' => null,
        'email' => null,
        'password' => null,
        'uid' => null,
    ];
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [];
}
