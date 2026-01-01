<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
 use App\Models\Consultancy;
 use Illuminate\Support\Facades\DB;

class ConsultancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
              DB::table('consultancies')->insert([
            [
                'consultancy' => 'High-Density Apple Plantation',
                'sub_consultancy' => 'Guidance on land selection and preparation',
            ],
            [
                'consultancy' => 'Technical Support',
                'sub_consultancy' => 'Trellis and drip irrigation system design',
            ],
            [
                'consultancy' => 'Production Guidance',
                'sub_consultancy' => 'Selection of suitable rootstocks and varieties',
            ],
            [
                'consultancy' => 'Orchard Management & Growth',
                'sub_consultancy' => 'Planting layout (row-to-row and plant to plant distance',
            ],

              [
                'consultancy' => 'Other',
                'sub_consultancy' => 'Other',
            ],
        ]);
    }
    }

