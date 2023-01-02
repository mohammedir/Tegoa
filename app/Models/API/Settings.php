<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Settings extends Model
{
    use HasFactory;
    protected $table = "settings";
    protected $guarded = [];

    protected $hidden = [
        'created_at', 'updated_at'
    ];




}
