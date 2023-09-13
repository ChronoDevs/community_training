<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Traits\Register;
use App\Models\Traits\Updater;

class Tag extends Model
{
    use HasFactory, Register, Updater;

    protected $fillable = ['name'];

    /**
     * The listings that belong to the tag.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function listings()
    {
        return $this->belongsToMany(Listing::class);
    }

    /**
     * Delete the tag.
     *
     * @return bool|null
     */
    public function deleteTag()
    {
        try {
            return $this->delete();
        } catch (\Exception $e) {
            // Handle the exception (e.g., log it)
            return false; // Return false to indicate that tag deletion failed
        }
    }
}
