<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserTweetResource;

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
            'user' => UserTweetResource::make($this->whenLoaded('user')),
            'likes_count' => $this->likes_count,
            'is_liked'  => $this->whenLoaded('likes')->where('user_id', auth()->id())->isNotEmpty(),
            'comments_count' => $this->comments_count,
            'displayed_created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
