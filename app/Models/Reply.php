<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Comment;
use App\Models\ReplyLike;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = ['content']; // Add other attributes as needed

    // Define the relationship between replies and the user who posted them
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship between replies and the comment they belong to
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    // Define the relationship between replies and their likes
    public function likes()
    {
        return $this->hasMany(ReplyLike::class);
    }

    // Check if a reply is liked by a specific user
    public function isLikedByUser($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }
}
