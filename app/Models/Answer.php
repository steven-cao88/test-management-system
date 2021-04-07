<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends AppModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'submission_id',
        'user_id',
        'question_id',
        'value'
    ];

    // Relations
    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($answer) {
            if (auth()->check()) {
                $answer->user_id = auth()->user()->id;
            }
        });
    }
}
