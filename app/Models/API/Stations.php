<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Stations extends Model
{
    use HasFactory,SoftDeletes,HasTranslations;
    protected $table = "places";
    public $translatable = ['name','description','address'];
    protected $guarded = [];

    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    protected $fillable = [
        'image',

    ];

    public function getImageAttribute($value)
    {
        return url(asset('images/places/'.$value));
    }
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->getTranslation('name',app()->getLocale()),
        );
    }
    protected function description(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->getTranslation('description',app()->getLocale()),
        );
    }
    protected function address(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->getTranslation('address',app()->getLocale()),
        );
    }

}
