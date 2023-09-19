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
use App\Models\Favorite;
use App\Enums\LikeCount;
use App\Enums\ListingAction;
use Illuminate\Http\Request;

class Listing extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'listings';
    
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
    ];

    protected $appends = ['likesText'];

    protected $dates = ['deleted_at'];

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
     * Define the tags relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
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

    /**
     * Update the status of a listing based on the provided status and action.
     *
     * @param  string  $status
     * @param  string  $action
     * @return string|false
     */
    public function updateListingStatus($status, $action)
    {
        // Handle status change
        $this->status = $status;

        // Save the updated listing
        $this->save();

        // Determine the action and return a success message
        switch ($action) {
            case ListingAction::PUBLISH:
                // Implement logic to publish the listing
                return 'Listing published successfully.';
                break;

            case ListingAction::UNPUBLISH:
                // Implement logic to unpublish the listing
                return 'Listing unpublished successfully.';
                break;

            case ListingAction::DELETE:
                // Implement logic to delete the listing
                return 'Listing deleted successfully.';
                break;

            default:
                return false; // Invalid action
        }
    }

    /**
     * Define the likes relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()
    {
        return $this->hasMany(ListingLike::class);
    }

    /**
     * Add a like to the listing for the given user.
     *
     * @param  User  $user
     * @return void
     */
    public function like(User $user)
    {
        if (!$this->likes()->where('user_id', $user->id)->exists()) {
            $this->likes()->create(['user_id' => $user->id]);
        }
    }

    /**
     * Remove a like from the listing for the given user.
     *
     * @param  User  $user
     * @return void
     */
    public function unlike(User $user)
    {
        $this->likes()->where('user_id', $user->id)->delete();
    }

    /**
     * Get the likes text attribute.
     *
     * @return string
     */
    public function getLikesTextAttribute()
    {
        $likeCount = LikeCount::from($this->likes->count());
        $currentUser = auth()->user();

        switch ($likeCount) {
            case LikeCount::ZERO():
                return __('listing.no_likes');

            case LikeCount::ONE():
                if ($this->likes->contains('user_id', $currentUser->id)) {
                    return __('listing.you_liked');
                } else {
                    $otherUser = $this->likes->first()->user->name;
                    return __('listing.other_liked', ['user' => $otherUser]);
                }

            case LikeCount::TWO():
                if ($this->likes->contains('user_id', $currentUser->id)) {
                    $otherUser = $this->likes->where('user_id', '!=', $currentUser->id)->first()->user->name;
                    return __('listing.you_and_other_liked', ['user' => $otherUser]);
                } else {
                    $otherUsersCount = $likeCount->value - 2;
                    return __('listing.others_liked', ['count' => $otherUsersCount]);
                }
                break;

            case LikeCount::MORE_THAN_TWO():
                $otherUsersCount = $likeCount->value - 1;
                $otherUsers = $this->likes->where('user_id', '!=', $currentUser->id)->take(2)->pluck('user.name')->implode(', ');
                return __('listing.you_and_others_liked', ['users' => $otherUsers, 'count' => $otherUsersCount]);

            default:
                $likedBy = $this->likes->pluck('user.name')->splice(0, 2)->implode(', ');
                $remainingLikes = $likeCount->value - 2;
                return __('listing.others_liked', ['users' => $likedBy, 'count' => $remainingLikes]);
        }
    }

    /**
     * Check if the listing is favorited by the given user.
     *
     * @param  User  $user
     * @return bool
     */
    public function isFavoritedBy(User $user)
    {
        return $this->favorites()->where('user_id', $user->id)->exists();
    }

    /**
     * Define a relationship for the favorites.
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Get the number of favorites for the listing.
     *
     * @return int
     */
    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}
