<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Enums\AdminRole;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Updater;
use App\Models\Traits\Register;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Register, Updater;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'line_id',
        'middle_name',
        'last_name',
        'user_name',
        'nickname',
        'gender',
        'date_of_birth',
        'contact_number',
        'zip_code',
        'address',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        return $this->role === AdminRole::ADMIN;
    }

    /**
     * Scope: Perform a search query based on a keyword.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $keyword
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $keyword)
    {
        // Customize this query as per your search criteria
        return $query->where('id', 'like', "%$keyword%")
            ->orWhere('name', 'like', "%$keyword%");
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Define a relationship to the ListingLike model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function listingLikes(): HasMany
    {
        return $this->hasMany(ListingLike::class);
    }

    /**
     * Check if the user has liked a specific listing.
     *
     * @param  Listing  $listing
     * @return bool
     */
    public function hasLiked(Listing $listing): bool
    {
        return $this->listingLikes->contains('listing_id', $listing->id);
    }
}
