<?php

namespace Database\Seeders;

use App\Models\ErrorHandle;
use Illuminate\Database\Seeder;

class ErroHandleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        ErrorHandle::firstOrCreate([
            'code' => 1062,
            'message' => 'Duplicate Entry Exception'
        ]);

        ErrorHandle::firstOrCreate([
            'code' => 1064,
            'message' => 'Not null Exception'
        ]);
    }
}
