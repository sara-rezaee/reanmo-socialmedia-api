<?php

namespace App\Http\Controllers;

use App\Http\Resources\TweetResource;
use Illuminate\Support\Facades\Auth;
use App\Models\Tweet;

class TweetController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user_id = $user->followings->pluck('id');

         $tweets = Tweet::query()
            ->whereIn('user_id', $user_id)
            ->with('user', 'likes')
            ->withCount([
                'comments',
                'likes'
            ])
            ->get();

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
