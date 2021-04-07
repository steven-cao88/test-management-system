<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends AppModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label',
        'type',
        'required',
    ];

    // Relations
    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }

    // Helper
    public function updateOptions(array $options): void
    {
        foreach ($options as $option) {
            if (isset($option['id'])) {
                $existingOption = Option::find($option['id']);

                if (!empty($existingOption)) {
                    $existingOption->fill($option);
                    $existingOption->save();
                }
            } else {
                $this->options->create($option);
            }
        }
    }
}
