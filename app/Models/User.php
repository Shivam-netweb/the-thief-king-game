<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'user_name',
        'phone',
        'profile',
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
        'password' => 'hashed',
    ];

    /**
     * Authentication rules for the user so that not to explode the query in database
     *
     * @var array<string, string>
     */
    public static $authenticationRules = [
        'username' => 'required|string|regex:/[A-za-z0-9.-_!@  ]+/',
        'password' => 'required|string'
    ];

    /**
     *
     * Registeration Rules to restrict user not to add wrong things in inputs
     *
     * @var array<string, string>
     */
    public static $registerationRules = [
        'first_name' => 'required|string|regex:/[A-za-z ]+/',
        'last_name' => 'required|string|regex:/[A-za-z ]+/',
        'user_name' => 'nullable|string|regex:/[A-za-z0-9.-_&*%$#@!() ]+/',
        'phone' => 'nullable|numeric',
        'profile' => 'nullable|image',
        'email' => 'required|string|regex:/[A-za-z0-9.-_!@  ]+/',
        'password' => 'required|string|regex:/[A-za-z0-9.-_&*%$#@!() ]+/|confirmed',
    ];

    public function name() : Attribute
    {
        return Attribute::make(
            get: fn () => $this->first_name .' ' .$this->last_name
        );
    }
}
