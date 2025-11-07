<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Test1',
            'country' => 'Japan',
            'email' => 'test1@mail.com',
            'password' => Hash::make('asdfasdf'),
            'role_id' => 1,
        ]);
    }
}
