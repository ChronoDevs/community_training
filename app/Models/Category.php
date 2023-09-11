<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;

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
     * Create a new category.
     *
     * @param  string  $name
     * @return \App\Models\Category
     */
    public static function createCategory($name)
    {
        // Create a new category instance
        $category = new static();
        $category->name = $name;
        // Set other attributes if needed
        $category->save();

        return $category;
    }

    /**
     * Update the category.
     *
     * @param  string  $name
     * @return bool
     */
    public function updateCategory($name)
    {
        $this->name = $name;
        // Update other fields if needed
        return $this->save();
    }

    /**
     * Delete the category.
     *
     * @return bool|null
     */
    public function deleteCategory()
    {
        return $this->delete();
    }
}
