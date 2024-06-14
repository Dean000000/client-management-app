<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    public function run()
    {
        DB::table('statuses')->insert([
            ['id' => 1, 'name' => 'Booked-in'],
            ['id' => 2, 'name' => 'Booked-out'],
            ['id' => 3, 'name' => 'Awaiting-parts'],
            ['id' => 4, 'name' => 'Awaiting-client'],
            ['id' => 5, 'name' => 'Awaiting-payment'],
            ['id' => 6, 'name' => 'closed-success'],
            ['id' => 7, 'name' => 'closed-dispute'],
        ]);
    }
}
