<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    /**/
    use HasFactory;
    protected $table = "cars";
    protected $guarded = [];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
    protected $fillable = [
        'carlicense',
        'carinsurance',
        'passengersinsurance',

    ];

    public function getCarphotosAttribute($value)
    {
        return url(asset('images/cars/'.$value));
    }
    public function getCarlicenseAttribute($value)
    {
        return url(asset('images/cars/'.$value));
    }
    public function getCarinsuranceAttribute($value)
    {
        return url(asset('images/cars/'.$value));
    }
    public function getPassengersinsuranceAttribute($value)
    {
        return url(asset('images/cars/'.$value));
    }

}
