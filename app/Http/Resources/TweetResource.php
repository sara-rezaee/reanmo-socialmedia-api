<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserTweetResource;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
        $user_id = $user->followings->keyBy->id;
        return [
            'id' => $this->id,
            'body' => $this->body,
            'image_url' => $this->image_url,
            //'user' => UserTweetResource::make($this->whenPivotLoaded('followers', function () {
                //return $this->pivot->user_id;
            //})),
            'user' => UserTweetResource::make($this->where('user_id', '=', $user_id)),
            'likes_count' => $this->likes_count,
            'is_liked' => $this->with('likes.user_id', Auth::user()->id, function () {
                return True;
            }),
            'comments_count' => $this->comments_count,
            'displayed_created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
