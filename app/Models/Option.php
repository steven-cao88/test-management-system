<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Option extends AppModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id',
        'label',
        'value',
    ];

    // Relations
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
