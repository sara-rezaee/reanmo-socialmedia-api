<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'user_id',
        'image_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function is_liked()
    {
        return $this->likes()->where('user_id', auth()->id())->exists();
    }
    
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
