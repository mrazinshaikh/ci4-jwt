<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users_data = [
            'username'  => 'System User',
            'active'    => 1
        ];
        $this->db->table('users')->insert($users_data);

        $auth_identities_data = [
            'user_id'   => '1',
            'type'      => 'email_password',
            'secret'    => 'admin@gmail.com',
            // 'secret2'   => service('passwords')->hash('123'),
            'secret2'   => password_hash('123', PASSWORD_BCRYPT),
            'created_at' => date("Y-m-d H:i:s")
        ];
        $this->db->table('auth_identities')->insert($auth_identities_data);

        $auth_groups_users_data = [
            'user_id'    => '1',
            'group'      => 'admin',
            'created_at' => date("Y-m-d H:i:s")
        ];
        $this->db->table('auth_groups_users')->insert($auth_groups_users_data);
    }
}
