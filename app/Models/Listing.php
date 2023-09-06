<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Listing extends Model
{
    use HasFactory, SoftDeletes;

    // Define the fillable fields for the Listing model
    protected $fillable = [
        'user_id',
        'title',
        'description',
    ];

    protected $dates = ['deleted_at'];

    // Define any relationships here, such as a user relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Create a new listing and attach tags.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\Listing
     */
    public static function createListing(Request $request)
    {
        $user = auth()->user();

        // Create the listing
        $listing = self::create([
            'user_id' => $user->id,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        // Attach tags to the listing
        $listing->tags()->attach($request->input('tags'));

        return $listing;
    }
}
