<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DropdownSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currency')->insert([
            ["currency_id" => "AED", "description" => "AED"],
            ["currency_id" => "ARS", "description" => "ARS"],
            ["currency_id" => "AUD", "description" => "AUD"],
            ["currency_id" => "BRL", "description" => "BRL"],
            ["currency_id" => "CAD", "description" => "CAD"],
            ["currency_id" => "CHF", "description" => "CHF"],
            ["currency_id" => "CNY", "description" => "CNY"],
            ["currency_id" => "CRC", "description" => "CRC"],
            ["currency_id" => "DKK", "description" => "DKK"],
            ["currency_id" => "EUR", "description" => "EUR"],
            ["currency_id" => "GBP", "description" => "GBP"],
            ["currency_id" => "HKD", "description" => "HKD"],
            ["currency_id" => "HRK", "description" => "HRK"],
            ["currency_id" => "IDR", "description" => "IDR"],
            ["currency_id" => "ILS", "description" => "ILS"],
            ["currency_id" => "INR", "description" => "INR"],
            ["currency_id" => "ISK", "description" => "ISK"],
            ["currency_id" => "JPY", "description" => "JPY"],
            ["currency_id" => "KES", "description" => "KES"],
            ["currency_id" => "KRW", "description" => "KRW"],
            ["currency_id" => "MAD", "description" => "MAD"],
            ["currency_id" => "MXN", "description" => "MXN"],
            ["currency_id" => "MYR", "description" => "MYR"],
            ["currency_id" => "NOK", "description" => "NOK"],
            ["currency_id" => "NZD", "description" => "NZD"],
            ["currency_id" => "PEN", "description" => "PEN"],
            ["currency_id" => "PHP", "description" => "PHP"],
            ["currency_id" => "PLN", "description" => "PLN"],
            ["currency_id" => "RUB", "description" => "RUB"],
            ["currency_id" => "SEK", "description" => "SEK"],
            ["currency_id" => "SGD", "description" => "SGD"],
            ["currency_id" => "THB", "description" => "THB"],
            ["currency_id" => "TRY", "description" => "TRY"],
            ["currency_id" => "TWD", "description" => "TWD"],
            ["currency_id" => "USD", "description" => "USD"],
            ["currency_id" => "VND", "description" => "VND"],
            ["currency_id" => "ZAR", "description" => "ZAR"],
        ]);

        DB::table('status')->insert([
            ['description' => 'Active'],
            ['description' => 'Deactiveated'],
        ]);

        DB::table('operator_status')->insert([
            ['description' => 'Operator is present'],
            ['description' => 'Customer is operator'],
            ['description' => 'flexible'],
        ]);

        DB::table('trip_status')->insert([
            ['description' => 'pending'],
            ['description' => 'published'],
        ]);

        DB::table('booking_status')->insert([
            ['description' => 'new inquiry'],
            ['description' => 'with offer'],
            ['description' => 'accepted'],
            ['description' => 'paid'],
            ['description' => 'confirmed'],
            ['description' => 'complete'],
            ['description' => 'declined'],
            ['description' => 'cancelled'],
            ['description' => 'expired'],
        ]);

        DB::table('offer_status')->insert([
            ['description' => 'pending'],
            ['description' => 'accepted'],
            ['description' => 'paid'],
            ['description' => 'declined'],
            ['description' => 'cancelled'],
            ['description' => 'expired'],
        ]);

        DB::table('trip_category')->insert([
            ['label' => 'Fishing', 'description' => fake()->text(20), 'logo' => 'fa fa-trash'],
            ['label' => 'Jetskis', 'description' => fake()->text(20), 'logo' => 'fa fa-trash'],
            ['label' => 'Ferries', 'description' => fake()->text(20), 'logo' => 'fa fa-trash'],
            ['label' => 'tours', 'description' => fake()->text(20), 'logo' => 'fa fa-trash'],
            ['label' => 'Luxury Motor', 'description' => fake()->text(20), 'logo' => 'fa fa-trash'],
        ]);


        DB::table('feature')->insert([
            ['label' => 'Wi-fi', 'description' => fake()->text(20)],
            ['label' => 'Bimini', 'description' => fake()->text(20)],
            ['label' => 'Bluetooth', 'description' => fake()->text(20)],
        ]);

        DB::table('tourist_location')->insert([
            ['city' => fake()->city(), 'state'=> fake()->country(), 'country'=> fake()->country(), 'address' => fake()->address(), 'latitude' => fake()->latitude(), 'longitude' => fake()->longitude(), 'slug' => fake()->text(20)],
            ['city' => fake()->city(), 'state'=> fake()->country(), 'country'=> fake()->country(), 'address' => fake()->address(), 'latitude' => fake()->latitude(), 'longitude' => fake()->longitude(), 'slug' => fake()->text(20)],
            ['city' => fake()->city(), 'state'=> fake()->country(), 'country'=> fake()->country(), 'address' => fake()->address(), 'latitude' => fake()->latitude(), 'longitude' => fake()->longitude(), 'slug' => fake()->text(20)],
            ['city' => fake()->city(), 'state'=> fake()->country(), 'country'=> fake()->country(), 'address' => fake()->address(), 'latitude' => fake()->latitude(), 'longitude' => fake()->longitude(), 'slug' => fake()->text(20)],
            ['city' => fake()->city(), 'state'=> fake()->country(), 'country'=> fake()->country(), 'address' => fake()->address(), 'latitude' => fake()->latitude(), 'longitude' => fake()->longitude(), 'slug' => fake()->text(20)],
            ['city' => fake()->city(), 'state'=> fake()->country(), 'country'=> fake()->country(), 'address' => fake()->address(), 'latitude' => fake()->latitude(), 'longitude' => fake()->longitude(), 'slug' => fake()->text(20)],
            ['city' => fake()->city(), 'state'=> fake()->country(), 'country'=> fake()->country(), 'address' => fake()->address(), 'latitude' => fake()->latitude(), 'longitude' => fake()->longitude(), 'slug' => fake()->text(20)],
            ['city' => fake()->city(), 'state'=> fake()->country(), 'country'=> fake()->country(), 'address' => fake()->address(), 'latitude' => fake()->latitude(), 'longitude' => fake()->longitude(), 'slug' => fake()->text(20)],
            ['city' => fake()->city(), 'state'=> fake()->country(), 'country'=> fake()->country(), 'address' => fake()->address(), 'latitude' => fake()->latitude(), 'longitude' => fake()->longitude(), 'slug' => fake()->text(20)],
            ['city' => fake()->city(), 'state'=> fake()->country(), 'country'=> fake()->country(), 'address' => fake()->address(), 'latitude' => fake()->latitude(), 'longitude' => fake()->longitude(), 'slug' => fake()->text(20)],
            ['city' => fake()->city(), 'state'=> fake()->country(), 'country'=> fake()->country(), 'address' => fake()->address(), 'latitude' => fake()->latitude(), 'longitude' => fake()->longitude(), 'slug' => fake()->text(20)],
        ]);
        
    }
}
