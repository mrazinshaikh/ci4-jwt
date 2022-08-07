<?php

namespace App\Models;

use App\Entities\Users;
use CodeIgniter\Model;
use CodeIgniter\Shield\Authorization\Traits\Authorizable;
// use CodeIgniter\Shield\Models\UserModel;

class UsersModel extends Model
{
    // use Authorizable;
    protected $table = 'users';

    protected $allowedFields = [
        'username',
        'status',
        'status_message',
        'uid',
        'active',
        'last_active',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $returnType    = 'array';
    protected $useTimestamps = true;
}
