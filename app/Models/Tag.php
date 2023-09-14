<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Traits\Register;
use App\Models\Traits\Updater;
use App\Models\Traits\Deleter;

class Tag extends Model
{
    use HasFactory, Register, Updater, Deleter;

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
}
