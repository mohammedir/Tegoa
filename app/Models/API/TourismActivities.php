<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class TourismActivities extends Model
{
    use HasFactory,SoftDeletes,HasTranslations;
    protected $table = "activities";
    protected $guarded = [];
    public $translatable = ['name','description','required_tools'];


    protected $hidden = [
        'created_at', 'updated_at'
    ];
    protected $fillable = [
        'image',

    ];

    public function getImageAttribute($value)
    {
        return url(asset('images/activities/'.$value));
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
    protected function requiredTools(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->getTranslation('required_tools',app()->getLocale()),
        );
    }

}
