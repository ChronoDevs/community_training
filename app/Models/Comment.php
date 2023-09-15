<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CommentLike;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'listing_id',
        'content',
    ];

    /**
     * Define the user relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define the listing relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    /**
     * Get the likes for the comment.
     */
    public function likes()
    {
        return $this->hasMany(CommentLike::class);
    }

    /**
     * Check if the comment is liked by a specific user.
     *
     * @param int $userId
     * @return bool
     */
    public function isLikedByUser($userId)
    {
        return $this->likes->contains('user_id', $userId);
    }
}
