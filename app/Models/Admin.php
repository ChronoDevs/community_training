<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Enums\AdminRole;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'admin'; // Use 'admin' guard for admin authentication
    protected $table = 'admin'; // Use the correct table name

    protected $fillable = [
        'name',
        'password',
        'role', 
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function isAdmin()
    {
        return $this->role === AdminRole::ADMIN;
    }
}
