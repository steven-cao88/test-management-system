<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Submission extends AppModel
{
    /**
      * The attributes that are mass assignable.
      *
      * @var array
      */
    protected $fillable = [
        'user_id',
    ];

    // Relations
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
