<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use function Symfony\Component\String\u;

class TourGuids extends Model
{
    use HasFactory,SoftDeletes,HasTranslations;
    protected $table = "tour_guids";
    protected $guarded = [];
    public $translatable = ['full_name','address'];


    protected $hidden = [
        'created_at', 'updated_at'
    ];
    protected $fillable = [
        'image',

    ];
    public function getImageAttribute($value)
    {
        return url(asset('images/tours/'.$value));
    }
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->getTranslation('full_name',app()->getLocale()),
        );
    }
    protected function address(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->getTranslation('address',app()->getLocale()),
        );
    }


}
