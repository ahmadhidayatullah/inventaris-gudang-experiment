<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'administrator', 'desc' => ''],
            ['name' => 'petugas', 'desc' => '']
        ];
        DB::table('roles')->insert($data);

        $user = [
            [
                'role_id' => 1,
                'name' => 'Admin',
                'email' => 'admin@mail.com',
                'password' => bcrypt('admin'),
                'no_hp' => '085254',
                'active'=>true
            ],
            [
                'role_id' => 2,
                'name' => 'petugas',
                'email' => 'petugas@mail.com',
                'password' => bcrypt('petugas'),
                'no_hp' => '08625252',
                'active'=>true
            ]

        ];
        DB::table('users')->insert($user);
    }
}