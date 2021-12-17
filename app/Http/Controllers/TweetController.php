<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTweetRequest;
use App\Http\Resources\TweetResource;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use App\Models\Tweet;
use Illuminate\Database\Eloquent\Builder;

class TweetController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user_id = $user->followings->pluck('id');
        //$is_liked = $user_id->likes;
        $tweets = Tweet::whereIn('user_id', $user_id)
            ->withCount([
                'comments',
                'likes'])
            //->whereHas('likes', function ($query) use ($user) {
            //    $query->where('likes.user_id', '=', $user->id);
            //})
            // ->when($is_liked, function ($query, $is_liked) {
            //     return $query->where('user_id', '=', auth()->id());
            // })
            ->get();
        // $tweets = select(['user_id' FROM $tweets)
        //         ->where('user_id', auth()->id())
        //     ])
        // ->get();
        // $tweets = $tweets->whereHas('likes', function ($query) {
        //     $query->where('user_id', Auth::id());
        // })->get();
        //($tweets->likes()->where('user_id', auth()->id())->exists())
        return TweetResource::collection($tweets);
    }

    public function show()
    {
        $user = Auth::user();
        $tweets = $user->tweets;
        return TweetResource::collection($tweets);
    }
    public function store(StoreTweetRequest $request)
    {
        $attributes = $request->validated();

        if(request()->hasFile('image_url'))
        {
            $file = request()->file('image_url');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->storeAs('public/images',$filename);
            $attributes['image_url'] = $filename;
        }

        $attributes['user_id'] = auth()->id();
        $tweet = Tweet::create($attributes);
        //return new TweetResource($tweet);
    }
}
