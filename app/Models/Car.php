<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Car extends Model
{
    use HasFactory;
    protected $table = "cars";
    protected $guarded = [];
    const Status =[0,1,2];
    const type =[1,2];

    public function driver() {
        return $this->belongsTo(Driver::class,'user_id');
    }

    public function photo() {
        return $this->hasone(Photos::class);
    }



}
