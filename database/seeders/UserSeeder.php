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

        User::firstOrCreate(
            [
                'email' => 'admin@gmail.com',
            ],[
                'name' => 'admin',
                'password' => Hash::make('123123')
            ]
        );

        User::firstOrCreate(
            [
                'email' => 'seljaa@gmail.com',
            ],[
                'name' => 'Selja Sampe Rante',
                'password' => Hash::make('123123')
            ]
        );

        User::firstOrCreate(
            [
                'email' => 'kepo@gmail.com',
            ],[
                'name' => 'Kepo bangat',
                'password' => Hash::make('123123')
            ]
        );
    }
}
