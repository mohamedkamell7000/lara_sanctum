<?php

namespace Database\Factories;
 
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
           'owner_id'=>User::all()->random()->id,
           'address'=>$this->faker->sentence(),
           'type'=>$this->faker->randomElement(['house','appartment','villa','penta house']),
           'size'=>$this->faker->randomElement(['140m','150m','200m','240m ']),
           'bedrooms'=>$this->faker->randomElement(['3','5','7',' 2']),
           'bathrooms'=>$this->faker->randomElement(['1','2','3','4']),
           'description'=>$this->faker->text(),
           'location'=>$this->faker->randomElement(['https://maps.app.goo.gl/Vktzc1FNdnW4G1AP6','https://maps.app.goo.gl/ZsTHWRZquH4mor268','  https://maps.app.goo.gl/PXVmgzHTwYkPEPSt8','https://maps.app.goo.gl/tmYFo3nPbrsJYf2x9']),
           'city'=>$this->faker->randomElement(['cairo','alex','sharm el shekh',' new capital']),





        ];
    }
}
