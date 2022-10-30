<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\Pricing;
use App\Models\Trip;
use App\Models\TripPicture;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Vessel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'currency_display' => fake()->currencyCode(),
            'language_spoken' => fake()->languageCode(),
            'phone' => fake()->phoneNumber(),
            'description' => fake()->text('150'),
            'marketing_consent' => true,
            'isAdmin' => true,
            'timezone' => fake()->timezone(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
    
    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            $trip = new Trip;
            $trip->head_line = fake()->text(50);
            $trip->description = fake()->text(120);
            $trip->operator_status_id = 1;
            $trip->save();

            /* Creating a link to user */
            DB::table('user_link_trip')->insert(
                ['user_id' => $user->user_id, 'trip_id' => $trip->trip_id],
            );

            /* Creating Photos */
            $trip_picture = new TripPicture;
            $trip_picture->trip_picture_url = 'https://www.goceksailing.com/img/blogs/sample-gulet-picture.webp';
            $trip_picture->save();

            /* Creating a link to user */
            DB::table('trip_link_trip_picture')->insert(
                ['trip_id' => $trip->trip_id, 'trip_picture_id'=> $trip_picture->trip_picture_id],
            );

            /* Create A category */
            DB::table('trip_link_trip_category')->insert([
                ['trip_category_id' => 1, 'trip_id'=> $trip->trip_id, 'primary' => true],
                ['trip_category_id' => 2, 'trip_id'=> $trip->trip_id, 'primary' => false],
                ['trip_category_id' => 3, 'trip_id'=> $trip->trip_id, 'primary' => false],
            ]);

            /* Creating a Vessel */
            $vessel = new Vessel;
            $vessel->make_model = fake()->text(20);
            $vessel->length = fake()->text(20);
            $vessel->year = fake()->text(20);
            $vessel->capacity = fake()->numberBetween(1,10);
            $vessel->number_of_engines = fake()->numberBetween(1,10);
            $vessel->engine_horsepower = fake()->text(20);
            $vessel->engine_brand = fake()->text(20);
            $vessel->engine_model = fake()->text(20);
            $vessel->save();

            /* Creating a link to vessel */
            DB::table('trip_link_vessel')->insert(
                ['trip_id' => $trip->trip_id, 'vessel_id'=> $vessel->vessel_id],
            );

            /* Create a link from vessel to feature */
            DB::table('vessel_link_feature')->insert([
                ['vessel_id' => $vessel->vessel_id, 'feature_id'=> 1],
                ['vessel_id' => $vessel->vessel_id, 'feature_id'=> 2],
                ['vessel_id' => $vessel->vessel_id, 'feature_id'=> 3],
            ]);

            /*Create a Location*/
            $location = new Location;
            $location->city = fake()->city(); 
            $location->state= fake()->country(); 
            $location->country = fake()->country(); 
            $location->zip = 4118; 
            $location->address = fake()->address(); 
            $location->latitude = fake()->latitude(); 
            $location->longitude = fake()->longitude();
            $location->save();

            /* Create a link from to location */
            DB::table('trip_link_location')->insert(
                ['trip_id' => $trip->trip_id, 'location_id'=> $location->location_id],
            );

            /* Create a price*/
            $price = new Pricing;
            $price->currency = fake()->currencyCode();
            $price->price_per_day = fake()->numberBetween(1,100);
            $price->per_day_minimum = fake()->numberBetween(1,10);
            $price->price_per_week = fake()->numberBetween(1,100);
            $price->price_per_hour = fake()->numberBetween(1,100);
            $price->per_hour_minimum = fake()->numberBetween(1,5);
            $price->price_per_night = fake()->numberBetween(1,100);
            $price->per_night_minimum = fake()->numberBetween(1,10);
            $price->security_allowance = fake()->numberBetween(1,50000);
            $price->price_per_multiple_days = fake()->numberBetween(1,100);
            $price->per_multiple_days_minimum = fake()->numberBetween(1,20);
            $price->price_per_multiple_hours = fake()->numberBetween(1,10);
            $price->per_multiple_hours_minimum = fake()->numberBetween(1,10);
            $price->price_per_person = fake()->numberBetween(1,100);
            $price->per_person_minimum = fake()->numberBetween(1,10);
            $price->per_person_charge_type = 1;
            $price->cancellation_refund_rate = fake()->numberBetween(1,100);
            $price->cancellation_allowed_days = fake()->numberBetween(1,10);
            $price->rental_terms = fake()->text(50);
            $price->save();


            /* Creating a link to pricing */
            DB::table('trip_link_pricing')->insert(
                ['trip_id' => $trip->trip_id, 'pricing_id'=> $price->pricing_id],
            );
                
            /* Create a Sample Addon */
            for ($x = 0; $x <= 10; $x++) {
                $trip_addon_id = DB::table('trip_addon')->insertGetId(
                    [
                        'description' => fake()->text(20), 
                        'price'=> fake()->numberBetween(1,20),
                        'currency'=> "USD"
                    ],
                );  

                 /* Create link to tour */
                DB::table('trip_link_trip_addon')->insert([
                    ['trip_addon_id' => $trip_addon_id, 'trip_id'=> $trip->trip_id],
                ]);
            }
        });
    }


    
}
