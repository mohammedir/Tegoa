<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    /**/
    use HasFactory;
    protected $table = "pages";
    protected $guarded = [];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $casts = [
    ];



}
