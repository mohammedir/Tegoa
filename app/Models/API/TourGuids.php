<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use function Symfony\Component\String\u;

class TourGuids extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "tour_guids";
    protected $guarded = [];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
    protected $fillable = [
        'image',

    ];

    public function getImageAttribute($value)
    {
        return url(asset('tour_guids/'.$value));
    }

}
