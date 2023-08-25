<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
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
        return $this->role === 'admin';
    }
    
    public static function createUser(array $data)
    {
        try {
            return static::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']), // Using bcrypt() to hash the password
                'middle_name' => $data['middle_name'],
                'last_name' => $data['last_name'],
                'user_name' => $data['user_name'],
                'nickname' => $data['nickname'],
                'gender' => $data['gender'],
                'date_of_birth' => $data['date_of_birth'],
                'contact_number' => $data['contact_number'],
                'zip_code' => $data['zip_code'],
                'address' => $data['address']
            ]);
        } catch (Exception $e) {
            // Handle the error here
            return false;
        }
    }
}
