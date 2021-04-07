<?php

namespace Database\Factories;

use App\Models\Answer;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Answer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'submission_id' => $this->faker->randomDigit(),
            'user_id' => $this->faker->randomDigit(),
            'question_id' => $this->faker->randomDigit(),
            'value' => $this->faker->word()
        ];
    }
}
