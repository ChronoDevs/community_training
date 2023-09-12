<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Traits\Register;
use App\Models\Traits\Updater;

class Category extends Model
{
    use HasFactory, Register, Updater;

    protected $fillable = ['name'];

    /**
     * The listings that belong to the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function listings()
    {
        return $this->belongsToMany(Listing::class);
    }

    /**
     * Delete the category.
     *
     * @return bool|null
     */
    public function deleteCategory()
    {
        try {
            return $this->delete();
        } catch (\Exception $e) {
            // Handle the exception (e.g., log it)
            return false; // Return false to indicate that category deletion failed
        }
    }
}
