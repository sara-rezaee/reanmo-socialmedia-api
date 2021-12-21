<?php

namespace App\Http\Controllers;

use App\Http\Resources\TweetResource;
use Illuminate\Support\Facades\Auth;

class UserTweetController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $tweets = $user->tweets->load('user', 'likes')->loadCount(['comments', 'likes']);

        return TweetResource::collection($tweets);
    }
}
