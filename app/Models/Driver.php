<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use HasFactory;
    protected $table = "users";
    protected $guarded = [];
    public function car()
    {
        return $this->hasOne(Car::class,'user_id');
    }

    public function transportations() {
        return $this->hasMany(Transportation::class,'driver_id');
    }

}
