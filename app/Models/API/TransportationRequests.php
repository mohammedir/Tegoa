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
        'driver_id'
    ];

   /* public function getStatusAttribute($value)
    {
        switch ($value) {
            case 1:
               return trans('api.waiting driver');
            case 2:
                return trans('api.accept driver');
            case 3:
                return trans('api.start trip');
            case 4:
                return trans('api.trip is complete');
            default:
                return $value;
        }
    }*/

    protected function status_string(): Attribute
    {
        return Attribute::make(
            set: fn (TransportationRequests $value) => [
                'address_line_one' => $value->lat_to,
                'address_line_two' => $value->lat_to,
            ],
        );
    }
}
