<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;

class TweetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'image_url' => $this->image_url,
            'user' => [
                'id' => Auth::user()->id,
                'full_name' => $this->full_name,
                'avatar_url' => Auth::user()->avatar_url,
            ],
            'likes_count' => $this->likes_count(),
            'is_liked' => $this->is_liked(),
            'comments_count' => $this->comments_count(),
            'displayed_created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
