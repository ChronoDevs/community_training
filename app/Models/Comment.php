<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CommentLike;
use App\Models\Listing;
use App\Models\Reply;
use App\Models\User;
use App\Models\Traits\Register;

class Comment extends Model
{
    use HasFactory, Register;

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

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * Store a reply to this comment.
     *
     * @param array $data
     * @return Reply|false
     */
    public function storeReply($data)
    {
        try {
            // Create a new reply with the content and associate it with the authenticated user
            $reply = new Reply([
                'content' => $data['content'],
            ]);
            $reply->user_id = auth()->user()->id; // Set the user_id

            // Save the reply and associate it with the comment
            $this->replies()->save($reply);

            return $reply;
        } catch (\Exception $e) {
            // Handle any errors, log them, or return false
            return false;
        }
    }

    /**
     * Reply to this comment.
     *
     * @param array $data
     * @return Comment|false
     */
    public function replyToComment($data)
    {
        try {
            // Create a new reply with the content and associate it with the authenticated user
            $comment = new Comment([
                'content' => $data['content'],
                'listing_id' => $this->listing_id,
                'user_id' => auth()->user()->id,
                'parent_id' => $this->id, // Associate the reply with this comment
            ]);

            $comment->save();

            return $comment;
        } catch (\Exception $e) {
            // Handle any errors, log them, or return false
            return false;
        }
    }

    /**
     * Store a new comment.
     *
     * @param array $data
     * @return Comment|false
     */
    public static function storeComment($data)
    {
        try {
            // Get the parent_id from the data
            $parentId = $data['parent_id'];

            if ($parentId) {
                $parentComment = Comment::find($parentId);

                // If the parent comment doesn't exist, return an error or handle it as needed
                if (!$parentComment) {
                    return false;
                }

                $comment = Comment::create([
                    'content' => $data['content'],
                    'listing_id' => $parentComment->listing_id,
                    'user_id' => auth()->user()->id,
                    'parent_id' => $parentId,
                ]);
            } else {
                // Create a new comment if no parent_id is provided
                $comment = Comment::create([
                    'content' => $data['content'],
                    'listing_id' => $data['listing_id'],
                    'user_id' => auth()->user()->id,
                    'parent_id' => null, // Ensure parent_id is null for comments
                ]);

                // Broadcast the new comment
                broadcast(new CommentPosted($comment))->toOthers();
            }

            return $comment;
        } catch (\Exception $e) {
            // Handle any errors, log them, or return false
            return false;
        }
    }
}
