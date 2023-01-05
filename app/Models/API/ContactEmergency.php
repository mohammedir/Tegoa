<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class ContactEmergency extends Model
{
    use HasFactory,SoftDeletes,HasTranslations;
    protected $table = "emergencies";
    protected $guarded = [];
    public $translatable = ['title'];


    protected $hidden = [
        'created_at', 'updated_at'
    ];
    protected $fillable = [
        'image',

    ];

    public function getImageAttribute($value)
    {
        return url(asset('images/emergencies/'.$value));
    }
    protected function title(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->getTranslation('title',app()->getLocale()),
        );
    }

}
