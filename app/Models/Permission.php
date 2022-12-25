<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Permission extends Model
{
    protected $table = "permissions";
    protected $guarded = [];

    public function role_permissions()
    {
        return $this->hasMany(RolesPermission::class, 'permission_id', 'id');
    }
}
