<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Activity extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    protected $table = "activities";
    public $translatable = ['name','description','required_tools'];
    protected $guarded = [];
    const status = [1, 2];
}
