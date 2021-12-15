<?php

namespace App\Http\Controllers;

use App\Http\Resources\TweetResource;
use Illuminate\Support\Facades\Auth;
use App\Models\Tweet;
use Illuminate\Database\Eloquent\Builder;

class TweetController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user_id = $user->followings->pluck('id');
        $tweets = Tweet::withCount(['likes', 'comments' => function (Builder $query) {
            $query->whereIn('user_id', $user_id);
        }])->get();
        return TweetResource::collection($tweets);
    }
}
