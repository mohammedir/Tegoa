<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Emergency extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    protected $table = "emergencies";
    public $translatable = ['title'];
    protected $guarded = [];
    const type = [1, 2];
    const status = [1, 2];
}
