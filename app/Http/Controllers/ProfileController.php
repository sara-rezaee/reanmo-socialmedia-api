<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUserRequest;

class ProfileController extends Controller
{
    public function showProfile()
    {
        $user = Auth::user();
        return new UserResource($user);
    }
    public function updateProfile(UpdateUserRequest $request)
    {
        $attributes = $request->validated();

        if($request->hasFile('avatar'))
        {
            $file = $request->file('avatar');
            $extension = $file->getClientOriginalExtension();
            $filename = $attributes['first_name'] . time() . '.'.$extension;
            $file->storeAs('public',$filename);
            $attributes['avatar_url'] = $filename;
        }

        /** @var User $user */
        $user = Auth::user();
        $user->update($attributes);

        return new UserResource($user);
    }
}
