<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
     * @return \App\Models\Listing|false
     */
    public static function createListing(Request $request)
    {
        $user = auth()->user();

        // Attempt to create the listing within a database transaction
        return DB::transaction(function () use ($user, $request) {
            // Create the listing
            $listing = self::create([
                'user_id' => $user->id,
                'title' => $request->input('title'),
                'description' => $request->input('description'),
            ]);

            // Attach tags to the listing
            $listing->tags()->attach($request->input('tags'));

            // If you also want to attach categories to the listing, you can do it here:
            $listing->categories()->attach($request->input('category'));

            return $listing;
        }, 5); // The second argument '5' specifies the number of times to attempt the transaction in case of deadlock
    }

    /**
     * Update a listing along with tags and categories using a transaction.
     *
     * @param  array  $data
     * @return bool
     */
    public function updateListing(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Update the listing details
            $this->update([
                'title' => $data['title'],
                'description' => $data['description'],
            ]);

            // Sync tags for the listing
            $this->tags()->sync($data['tags']);

            // Update the selected category for the listing
            $this->categories()->sync($data['category']);

            // Commit the transaction
            return true;
        });
    }

    /**
     * Override the soft delete method to customize behavior.
     *
     * @return void
     */
    public function softDelete()
    {
        // Set the 'deleted_at' column to the current timestamp
        $this->deleted_at = $this->freshTimestamp();

        // Set the 'deleted_by' column to the ID of the authenticated user
        $this->deleted_by = Auth::id();

        // Disable timestamps to prevent them from being updated
        $this->timestamps = false;

        // Save the model to apply the changes
        $this->save();
    }
}
