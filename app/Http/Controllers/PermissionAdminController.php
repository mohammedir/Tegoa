<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdminPermissions;
use App\Models\Permission;
use App\Models\RolesPermission;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class PermissionAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:roles_view|roles_create|roles_edit|roles_delete']);
    }

    public function index(Request $request)
    {
        $permissions = Permission::query()->get();

        return view("admin-management.permissions", compact("permissions"));
    }


    public function roles()
    {
        return view("admin.users.roles.list");
    }

    public function roles_view()
    {
        return view("admin.users.roles.view");
    }
    public function edit($id){

        $permission = Permission::query()->find($id);
        return response()->json(['permission' => $permission]);
    }

    public function store(Request $request)
    {

        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:permissions',
            ], [
                'name.required' => trans("str.Name is required"),
            ]);
            if ($validator->passes()) {
                $data = new Permission();
                $data->name = $request->name;
                $data->guard_name = "admin";
                $data->created_at = Carbon::now();
                $data->save();
                return response()->json(['success' => $data]);
            }
            return response()->json(['error' => $validator->errors()->toArray()]);
        }
    }

    public function show($id)
    {
    }


    public function update(Request $request, $id)
    {
        $data = Permission::query()->find($id);
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:permissions',
            ], [
                'name.required' => trans("str.Name is required"),
            ]);
            if ($validator->passes()) {
                $data->name = $request->name;
                $data->created_at = Carbon::now();
                $data->save();
                return response()->json(['success' => $data]);
            }
            return response()->json(['error' => $validator->errors()->toArray()]);
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = Permission::query()->find($id)->delete();
            $role = RolesPermission::query()->where("permission_id", $id)->delete();
            $user = AdminPermissions::query()->where("permission_id", $id)->delete();
            return response()->json(['success' => "success"]);
        }
        return response()->json(['error' => "error"]);
    }
}
