<?php


use App\Models\API\User;
use App\Models\Permission;
use App\Models\RolesPermission;
use App\Services\FCMService;

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
    //dd($response['rows'][0]['elements'][0]['distance']['text']);
    $distance = $response['rows'][0]['elements'][0]['distance']['text'];
    $duration = $response['rows'][0]['elements'][0]['duration']['text'];
    $num = ($response['rows'][0]['elements'][0]['distance']['value']/1000)*$price;
    return [
        'distance' => $distance,
        'arrival_time' => $duration,
        'expected_cost' => number_format($num,2)
    ];
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
