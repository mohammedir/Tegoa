<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Settings extends Model
{
    use HasFactory,HasTranslations;
    protected $table = "settings";
    public $translatable = ['municipality'];
    protected $guarded = [];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected function municipality(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->getTranslation('municipality',app()->getLocale()),
        );
    }


}
