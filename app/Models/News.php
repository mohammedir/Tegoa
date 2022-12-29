<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class News extends Model
{
    use HasFactory,SoftDeletes,HasTranslations;
    protected $table = "news_and_announcements";
    public $translatable = ['title','description','article'];
    protected $guarded = [];
    const Status =[0,1];
    const type =[1,2];
}
