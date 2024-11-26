<?php

namespace Database\Factories;

use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

class SectionFactory extends Factory
{
    protected $model = Section::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'class_name' => $this->faker->word,
            'class_id' => $this->faker->numberBetween(1, 10),
            'capacity' => $this->faker->numberBetween(20, 40),
            'campus_name' => $this->faker->word,
            'campus_id' => $this->faker->numberBetween(1, 5),
            'teacher_in_charge_name' => $this->faker->name,
            'teacher_in_charge_id' => $this->faker->numberBetween(1, 20),
            'is_deleted' => $this->faker->boolean(0),
        ];
    }
}
