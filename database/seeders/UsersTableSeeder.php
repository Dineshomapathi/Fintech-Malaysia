<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Moderator',
                'email'          => 'moderator@mail.com',
                'loginotp'       => 'moderator',
                'password'       => 'moderator',
                'lang'           => 'EN',
                'project'        => 'testmoderator',
                'role'           => 'moderator',
                'booth'          => 'testmoderator',
                'welcometext'    => null,
                'company'        => null,
                'position'       => null,
                'suggestion'     => null,
                'imageurl'          => null,
                'remember_token' => null,
            ]
        ];

        User::insert($users);
    }
}