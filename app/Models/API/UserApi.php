<?php

namespace App\Models\API;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class UserApi extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'user_type',
        'roles_name',
        'user_status',
        'api_token',
        'personalphoto',
        'driverlicense'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'user_status',
        'roles_name',
        'roles_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'roles_name'  => 'array',
        'gender' => 'integer',
        'vehicle_type' => 'integer'

    ];

    public function getPersonalphotoAttribute($value)
    {
        return url(asset('images/users/'.$value));
    }
    public function getDriverlicenseAttribute($value)
    {
        return url(asset('images/users/'.$value));
    }

}
