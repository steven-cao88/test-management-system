<?php

namespace Tests\Feature;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubmissionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_user_can_submit_answers()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $question = Question::factory()->create();

        $answer1 = [
            'question_id' => $question->id,
            'value' => $this->faker->word,
        ];

        $answers = [$answer1];

        $response = $this->post('/submissions', [
            'answers' => $answers
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('answers', [
            'question_id' => $answer1['question_id'],
            'value' => $answer1['value']
        ]);
    }

    public function test_user_can_view_own_submission()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $submission = Submission::factory()->create(['user_id' => $user->id]);
        $question1 = Question::factory()->create();
        $answer1 = Answer::factory()->create([
            'submission_id' => $submission->id,
            'user_id' => $user->id,
            'question_id' => $question1
        ]);

        $response = $this->getJson('/submissions/' . $submission->id);

        $response->assertStatus(200);

        $response->assertJsonPath('data.answers.0.value', $answer1->value);
    }
}
