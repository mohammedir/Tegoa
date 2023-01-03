<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransportationRequests extends Model
{
    use HasFactory;
    protected $table = "transportation_requests";
    protected $guarded = [];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $fillable = [
        'passenger_id',
        'lat_from',
        'lng_from',
        'lat_to',
        'lng_to',
        'departure_time',
        'number_of_passenger',
        'vehicle_type',
        'distance',
        'expected_cost',
        'arrival_time',


    ];




}
