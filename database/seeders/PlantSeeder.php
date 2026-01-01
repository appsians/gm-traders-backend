<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
 use App\Models\Consultancy;
 use Illuminate\Support\Facades\DB;

class PlantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('plantbookings')->insert([
            [
                'plantation_area' => '1kanal 200plants',
                'plant_varieties' => 'schnico Red',
                'plant_grading'   => '3Feather',
            ],
            [
                'plantation_area' => '2kanal 400plants',
                'plant_varieties' => 'RD 11',
                'plant_grading'   => '5Feather',
            ],
            [
                'plantation_area' => '3kanal 600plants',
                'plant_varieties' => 'Trex Gala',
                'plant_grading'   => '7Feather',
            ],
        ]);
    }
    }

