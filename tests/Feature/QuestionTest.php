<?php

namespace Tests\Feature;

use App\Enums\QuestionType;
use App\Models\Option;
use App\Models\Question;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_admin_can_create_new_question()
    {
        $user = User::factory()->create(['is_admin' => true]);

        $this->actingAs($user);

        $faker = $this->faker;

        $questionWithoutOption = [
            'label' => $faker->sentence,
            'type' => QuestionType::OPTIONS[random_int(0, 2)],
            'required' => random_int(0, 1) ? true : false,
        ];

        $response = $this->post('/questions', $questionWithoutOption);

        $response->assertStatus(201);

        $this->assertDatabaseHas('questions', $questionWithoutOption);

        $option1 = [
            'label' => $faker->word,
            'value' => $faker->word
        ];

        $option2 = [
            'label' => $faker->word,
            'value' => $faker->word
        ];

        $questionWithoutOptions = [
            'label' => $faker->sentence,
            'type' => QuestionType::OPTIONS[random_int(0, 2)],
            'required' => random_int(0, 1) ? true : false,
            'options' => [$option1, $option2],
        ];

        $response = $this->post('/questions', $questionWithoutOptions);

        $response->assertStatus(201);

        $this->assertDatabaseHas('questions', [
            'label' => $questionWithoutOptions['label']
        ]);
        $this->assertDatabaseCount('questions', 2);

        $this->assertDatabaseCount('options', 2);
        $this->assertDatabaseHas('options', $option1);
        $this->assertDatabaseHas('options', $option2);
    }

    public function test_user_can_not_create_question()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $faker = $this->faker;

        $questionWithoutOption = [
            'label' => $faker->sentence,
            'type' => QuestionType::OPTIONS[random_int(0, 2)],
            'required' => random_int(0, 1) ? true : false,
        ];

        $response = $this->post('/questions', $questionWithoutOption);

        $response->assertStatus(403);

        $this->assertDatabaseMissing('questions', $questionWithoutOption);
    }

    public function test_admin_can_update_question()
    {
        $user = User::factory()->create(['is_admin' => true]);

        $this->actingAs($user);

        $question = Question::factory()->create();
        $option = Option::factory()->create(['question_id' => $question->id]);

        $updatedQuestionWithExitingOption = [
            'label' => 'Test updated question',
            'type' => QuestionType::OPTIONS[random_int(0, 2)],  
            'options' => [
                [
                    'id' => $option->id,
                    'label' => 'Test updated option',
                    'value' => 'updated value'
                ]
            ]
        ];

        $response = $this->put('/questions/' . $question->id, $updatedQuestionWithExitingOption);

        $response->assertStatus(200);

        $this->assertDatabaseHas('questions', [
            'label' => $updatedQuestionWithExitingOption['label']
        ]);

        $this->assertDatabaseHas('options', [
            'label' => $updatedQuestionWithExitingOption['options'][0]['label']
        ]);
    }
}
