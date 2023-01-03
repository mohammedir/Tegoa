<?php


use App\Models\Permission;
use App\Models\RolesPermission;

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
