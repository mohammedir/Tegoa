<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class News extends Model
{
    use HasFactory,SoftDeletes,HasTranslations;
    protected $table = "news_and_announcements";
    protected $guarded = [];
    public $translatable = ['title','article','description'];


    protected $hidden = [
        'deleted_at','type'
    ];
    protected $fillable = [
        'image',

    ];

    public function getImageAttribute($value)
    {
        return url(asset('images/news/'.$value));
    }
    protected function title(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->getTranslation('title',app()->getLocale()),
        );
    }
    protected function article(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->getTranslation('article',app()->getLocale()),
        );
    }
    protected function description(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->getTranslation('description',app()->getLocale()),
        );
    }
}
