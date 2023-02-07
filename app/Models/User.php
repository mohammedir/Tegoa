<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
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
        'user_status'
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
        'roles_name'  => 'array'
    ];




    public function getPersonalphotoAttribute($value)
    {
        if (Auth::user()->user_type == 2)
             return url(asset('images/users/'.$value));
        return $value;

    }
    public function getDriverlicenseAttribute($value)
    {
        if (Auth::user()->user_type == 2)
            return url(asset('images/users/'.$value));
        return $value;
    }

    public function transportations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Transportation::class,'driver_id');
    }

    public function passengers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Transportation::class,'passenger_id');
    }


}
