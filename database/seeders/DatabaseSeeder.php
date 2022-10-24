<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
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
        
        \App\Models\User::factory(10)->create();
    }
}
