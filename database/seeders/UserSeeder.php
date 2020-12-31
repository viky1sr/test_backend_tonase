<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate(
            [
                'email' => 'vikymuhamad@gmail.com',
                ],[
                'name' => 'viky muhammad alif',
                'password' => Hash::make('123123')
            ]
        );
    }
}
