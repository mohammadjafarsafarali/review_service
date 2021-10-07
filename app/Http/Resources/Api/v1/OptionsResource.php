<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class OptionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     */
    public function toArray($request)
    {
        return responseApi('success', NULL, NULL, [
            'is_visible' => $this->is_visible ?? false,
            'options' =>
                (isset($this->is_visible) && $this->is_visible) ? [
                    'comments_mode' => $this->comments_mode,
                    'vote_mode' => $this->vote_mode,
                ] : NULL
        ]);
    }
}
