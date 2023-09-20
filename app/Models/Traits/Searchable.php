<?php

namespace App\Models\Traits;

trait Searchable
{
    /**
     * Scope a query to search for records based on a search term.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $searchTerm
     * @param  string  $table
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $searchTerm, $table = 'default')
    {
        // Get the searchable columns for the specified table from the configuration
        $tableColumns = config("searchable.$table", []);
        
        return $query->where(function ($query) use ($searchTerm, $tableColumns) {
            foreach ($tableColumns as $column) {
                $query->orWhere($column, 'like', "%$searchTerm%");
            }
        });
    }
}
