<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Traits\Searchable;
use App\Enums\LikeCount;
use App\Enums\ListingAction;
use App\Enums\ListingSort;
use Illuminate\Http\Request;

class Listing extends Model
{
    use HasFactory, SoftDeletes, Searchable;

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
     * Define the tags relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
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
            // Strip HTML tags from the description
            $description = strip_tags($request->input('description'));

            // Create the listing with the cleaned-up description
            $listing = self::create([
                'user_id' => $user->id,
                'title' => $request->input('title'),
                'description' => $description, // Use the cleaned-up description
            ]);

            // Attach tags to the listing
            $listing->tags()->attach($request->input('tags'));

            // If you also want to attach categories to the listing, you can do it here:
            $listing->categories()->attach($request->input('category'));

            return $listing;
        }, 5);
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
            // Strip HTML tags from the description
            $description = strip_tags($data['description']);

            // Update the listing details with the cleaned-up description
            $this->update([
                'title' => $data['title'],
                'description' => $description, // Use the cleaned-up description
            ]);

            // Sync tags for the listing
            $this->tags()->sync($data['tags']);

            // Update the selected category for the listing
            $this->categories()->sync($data['category']);

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

    /**
     * Define the comments relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Add a comment to the listing.
     *
     * @param  User  $user
     * @param  string  $content
     * @return Comment
     */
    public function addComment(User $user, $content)
    {
        // Create a new comment
        $comment = $this->comments()->create([
            'user_id' => $user->id,
            'content' => $content,
        ]);

        return $comment;
    }

    /**
     * Scope a query to order listings by the most used tag.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrderByMostUsedTag(Builder $query)
    {
        return $query
            ->select('listings.*') // Select all columns from the listings table
            ->join('listing_tag', 'listings.id', '=', 'listing_tag.listing_id')
            ->join('tags', 'listing_tag.tag_id', '=', 'tags.id')
            ->selectRaw('COUNT(listing_tag.tag_id) as tag_count')
            ->groupBy('listings.id')
            ->orderByDesc('tag_count');
    }

    /**
     * Sort listings based on the specified sort option.
     *
     * @param string $sortOption The sorting option to apply.
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function sortBy($sortOption)
    {
        $query = self::query();

        switch ($sortOption) {
            case ListingSort::LATEST:
                $query->orderBy('created_at', 'desc');
                break;
            case ListingSort::TOP:
                $query->withCount('likes')->orderByDesc('likes_count');
                break;
            case ListingSort::MOST_USED_TAG:
            default:
                $query->orderByMostUsedTag();
                break;
        }

        return $query;
    }

    /**
     * Retrieve the most used tags with a specified limit.
     *
     * @param int $limit The limit for the number of popular tags to retrieve.
     * @return \Illuminate\Support\Collection
     */
    public static function mostUsedTags($limit)
    {
        return DB::table('listing_tag')
            ->join('tags', 'listing_tag.tag_id', '=', 'tags.id')
            ->select('tags.name', DB::raw('COUNT(listing_tag.tag_id) as tag_count'))
            ->groupBy('tags.name')
            ->orderByDesc('tag_count')
            ->limit($limit)
            ->get();
    }
}
