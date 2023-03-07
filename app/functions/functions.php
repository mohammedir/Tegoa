<?php


use App\Models\API\User;
use App\Models\Permission;
use App\Models\RolesPermission;
use App\Services\FCMService;
use Carbon\Carbon;

function get_permission_by_name($name)
{
    $permission = Permission::query()->where("name", $name)->where("status", 1)->get()->first();
    return $permission;
}

function get_role_permission_checked($role_id, $permission_id)
{
    $data = RolesPermission::query()->where("role_id", $role_id)->where("permission_id", $permission_id)->get()->first();
    return $data;
}
function get_meters_between_points($latitude1, $longitude1, $latitude2, $longitude2) {
    if (($latitude1 == $latitude2) && ($longitude1 == $longitude2)) { return 0; } // distance is zero because they're the same point
    $p1 = deg2rad($latitude1);
    $p2 = deg2rad($latitude2);
    $dp = deg2rad($latitude2 - $latitude1);
    $dl = deg2rad($longitude2 - $longitude1);
    $a = (sin($dp/2) * sin($dp/2)) + (cos($p1) * cos($p2) * sin($dl/2) * sin($dl/2));
    $c = 2 * atan2(sqrt($a),sqrt(1-$a));
    $r = 6371008; // Earth's average radius, in meters
    $d = $r * $c;
    return $d/1000; // distance, in meters
}

function firebaseNotification($fcmNotification)
{
    $fcmUrl =config('firebase.fcm_url');

    $apiKey=config('firebase.fcm_api_key');

    $http=\Illuminate\Support\Facades\Http::withHeaders([
        'Authorization:key'=>$apiKey,
        'Content-Type'=>'application/json'
    ])  ->post($fcmUrl,$fcmNotification);

    return  $http->json();

}

function getUserName($id){
    $user = User::query()->find($id);
    if ($user)
        return $user->full_name;
    return '';

}

function getDistanceAndEtaByLatLng($originLatLng, $destinationLatLng, $apiKey , $price)
{
    $client =  new \yidas\googleMaps\Client(['key'=>$apiKey]);

    $response = $client->distanceMatrix(implode(',', $originLatLng), implode(',', $destinationLatLng));
    if ($response['rows'][0]['elements'][0]['status'] == "OK"){
    //dd($response['rows'][0]['elements'][0]['distance']['text']);
    $distance = $response['rows'][0]['elements'][0]['distance']['text'];
    $duration = $response['rows'][0]['elements'][0]['duration']['text'];
    $num = ($response['rows'][0]['elements'][0]['distance']['value']/1000)*$price;
    return [
            'distance' => $distance,
            'arrival_time' => $duration,
            'expected_cost' => number_format($num,2)
    ];
    }else{

        $lat1 = deg2rad($originLatLng[0]);
        $lng1 = deg2rad($originLatLng[1]);
        $lat2 = deg2rad($destinationLatLng[0]);
        $lng2 = deg2rad($destinationLatLng[0]);
        $speed = 20;
        $earth_radius = 6371; // km
        $lat_diff = deg2rad($lat2 - $lat1);
        $lng_diff = deg2rad($lng2 - $lng1);
        $a = sin($lat_diff / 2) * sin($lat_diff / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($lng_diff / 2) * sin($lng_diff / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earth_radius * $c; // km
        $distance = $distance +20;
        // Calculate the estimated arrival time based on the speed of travel
        $time = $distance / ($speed/60); // hours

        // Return the distance and estimated arrival time as an array
        return [
            'distance' =>floor($distance)." km",
            'arrival_time' => floor($time)." mins",
            'expected_cost' => number_format(floor($distance)*$price,2)
        ];

    }
}

function marginFunction(){
    if (\Illuminate\Support\Facades\App::getLocale() == "ar"){
        return 'margin-right: 10px;';
    }else{
        return 'margin-left: 10px;';
    }
}

function getStatusAttribute($value)
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
        case 5:
            return trans('api.rejected');
        default:
            return $value;
    }
}

function getStatusTypeAttribute($value)
{
    switch ($value) {
        case 1:
            return 'Waiting_Driver';
        case 2:
            return 'Accept_Driver';
        case 3:
            return 'Start_Trip';
        case 4:
            return 'End_Trip';
        case 5:
            return 'Rejected';
        default:
            return $value;
    }
}
function getDistanceAndArrivalTime($lat1, $lng1, $lat2, $lng2, $speed , $price) {
    // Calculate the distance between the two points using the Haversine formula
    $earth_radius = 6371; // km
    $lat_diff = deg2rad($lat2 - $lat1);
    $lng_diff = deg2rad($lng2 - $lng1);
    $a = sin($lat_diff / 2) * sin($lat_diff / 2) +
        cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
        sin($lng_diff / 2) * sin($lng_diff / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $distance = $earth_radius * $c; // km

    // Calculate the estimated arrival time based on the speed of travel
    $time = $distance / $speed; // hours

    // Return the distance and estimated arrival time as an array
    return [
        'distance' =>floor($distance)." km",
        'arrival_time' => floor($time)." hours",
        'expected_cost' => number_format(floor($distance)*$price,2)
    ];
}

function getArLang($value){
    $array = json_decode($value);
    $translatedArray = array_map(function ($value) {
        return trans('api.'.$value);
    }, $array);

    return json_encode($translatedArray,JSON_UNESCAPED_UNICODE);
}

function getUserNumber($value){
    if ($value){
        $user = User::query()->find($value);
        return $user->mobile_number;
    }
    return '';

}
function isTimeLessThanNow(string $timeString)//: bool
{
    $utf8String = mb_convert_encoding($timeString, 'UTF-8', 'auto');
    $dateTime = DateTime::createFromFormat('h:i A', $utf8String);
    // Parse the input string into a Carbon object.
    $time = Carbon::parse($dateTime);
    // Get the current time as a Carbon object.
    $now = Carbon::now()->format('h:i A');

    // Compare the two times.
    return $time->lessThan($now);
}
