<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyLike extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'reply_id',
    ];

    /**
     * Get the user who liked the reply.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the reply that was liked.
     */
    public function reply()
    {
        return $this->belongsTo(Reply::class);
    }
}
