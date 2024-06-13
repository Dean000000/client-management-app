<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    public function run()
    {
        DB::table('statuses')->insert([
            ['name' => 'Booked-in'],
            ['name' => 'Booked-out'],
            ['name' => 'Awaiting-parts'],
            ['name' => 'Awaiting-client'],
            ['name' => 'Awaiting-payment'],
        ]);
    }
}
