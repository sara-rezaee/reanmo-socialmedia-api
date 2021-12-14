<?php

namespace App\Http\Controllers;

use App\Http\Resources\TweetResource;
use Illuminate\Support\Facades\Auth;
use App\Models\Tweet;

class TweetController extends Controller
{
    public function showTweets()
    {
        $user = Auth::user();
        $user_id = $user->followings->pluck('id');
        $tweets = Tweet::whereIn('user_id',$user_id)->get();

        return TweetResource::collection($tweets);
    }
}
