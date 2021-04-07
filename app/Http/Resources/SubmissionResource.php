<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubmissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'submitted_date' => $this->created_at,
            'user' => $this->user->username,
            'answers' => $this->answers->map->only(['id', 'value'])
        ];
    }
}
