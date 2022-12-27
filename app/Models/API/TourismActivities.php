<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourismActivities extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "tourism_activities";
    protected $guarded = [];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
    protected $fillable = [
        'images',

    ];

    public function getImagesAttribute($value)
    {
        return url(asset('tourism_activities/'.$value));
    }

}
