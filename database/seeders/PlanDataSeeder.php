<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Monthly',
                'price' => '147'                
            ],
            [
                'name' => 'Quarterly',
                'price' => '387'                
            ],
            [
                'name' => 'Yearly',
                'price' => '787'                
            ],
            // Add more rows as needed
        ];

        // Insert the data into the users table
        DB::table('plans')->insert($plans);
    }
}
