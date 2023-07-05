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
                'price' => '147',
                'stripe_plan' => 'price_1NLRfuCdpaHxI8YR4lA89hNl',
                'paypal_plan' => 'P-8AT24987DW515823F3FMH6MA'               
            ],
            [
                'name' => 'Quarterly',
                'price' => '387',                
                'stripe_plan' => 'price_1NLRivCdpaHxI8YR5KSwEhDC',
                'paypal_plan' => 'P-4WA2005249560843Y3YYX4VQ'               
            ],
            [
                'name' => 'Yearly',
                'price' => '787',                
                'stripe_plan' => 'price_1NLRjECdpaHxI8YRB9SWvndd',
                'paypal_plan' => 'P-45K95324L7256440S3YZ2DSI'               
            ],
            // Add more rows as needed
        ];

        // Insert the data into the users table
        DB::table('plans')->insert($plans);
    }
}
