<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Tour extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    protected $table = "tour_guids";
    public $translatable = ['full_name','address'];
    protected $guarded = [];
    const type = [1, 2];
    protected $casts = [
        'spoken_languages' => 'array'
    ];
}

