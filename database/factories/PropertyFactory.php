<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Property::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'listing_type' => $this->faker->randomElement(['private_room', 'studio', 'whole_building', 'own_compound']),
            'building_type' => $this->faker->randomElement(['house', 'apartment', 'home']),
            'name' => $this->faker->company() . ' Homes',
            'stay_type' => $this->faker->randomElement(['Long', 'Short', 'Flex']),
            'is_furnished' => $this->faker->randomElement([true, false]),
            'rent_cost' => random_int(10000, 500000) / 100,
            'utilities_cost' => random_int(0, 10000) / 100,
            'currency' => 'USD',
            'bedrooms' => random_int(1, 4),
            'bathrooms' => random_int(1, 2),
            'location' => $this->faker->city(),
            'description' => $this->faker->paragraph(),
            'available_from' => now()->addDays(random_int(0, 90)),
            'date_approved' => now(),
            'status' => 'approved'
        ];
    }
}

/* $table->uuid('id')->primary();
            $table->string('listing_type');
            $table->string('building_type');
            $table->string('name');
            $table->string('unit_size')->nullable();
            $table->string('stay_type');
            $table->boolean('is_furnished');
            $table->double('rent_cost', 11, 2);
            $table->double('utilities_cost', 11, 2)->default(0.00);
            $table->string('currency');
            $table->unsignedInteger('bedrooms');
            $table->unsignedInteger('bathrooms');
            $table->string('location');
            $table->string('description', 10000);
            $table->string('cover_image')->nullable();
            $table->json('amenities')->default('[]');
            $table->string('status')->default('pending');
            $table->date('available_from');
            $table->dateTime('date_approved')->nullable();
            $table->double('longitude', 11, 8)->nullable();
            $table->double('latitude', 11, 8)->nullable(); */
