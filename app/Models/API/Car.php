<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "cars";
    protected $guarded = [];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
    protected $fillable = [
        'carphotos',
        'carlicense',
        'carinsurance',
        'passengersinsurance',

    ];

    public function getCarphotosAttribute($value)
    {
        return url(asset('carphotos/'.$value));
    }
    public function getCarlicenseAttribute($value)
    {
        return url(asset('carlicense/'.$value));
    }
    public function getCarinsuranceAttribute($value)
    {
        return url(asset('carinsurance/'.$value));
    }
    public function getPassengersinsuranceAttribute($value)
    {
        return url(asset('passengersinsurance/'.$value));
    }

}
