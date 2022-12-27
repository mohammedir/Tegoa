<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Admin;
use App\Models\AdminPermissions;
use App\Models\AdminRoles;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index(Request $request){
    /*    $users = User::query()->get();
        $roles = Role::query()->get();
        return view('admin-management.admins.admins_list',compact('roles','users'));*/
        $users = User::orderBy('id','DESC')->where('id','!=',1)->paginate(5);
        $roles = Role::query()->get();
        return view('admin-management.admins.admins_list',compact('users','roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);

    }
    public function edit($id)
    {
        $user = User::query()->find($id);
        $roles = Role::query()->get();
        return view('admin-management.Admins.admins_edit', compact('user','roles'));
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|string|unique:Users,email',
                'roles_id' => 'required',

            ], [
                'name.required' => trans("str.This field is required"),
                'email.required' => trans("str.This field is required"),
                'email.email' => trans('str.The selected email is invalid.'),
                'email.unique' => trans("str.This field must be unique"),
                'roles_id.required' => trans("str.This field is required"),

            ]);
            if ($validator->passes()) {
                $data = new User();
                $image = uniqid() . '.jpg';
                $image_path = "uploads/admins/$image";
                file_put_contents($image_path, base64_decode($request->customer_image));
                $data->personalphoto = $image;
                $data->full_name = $request->name;
                $data->email = $request->email;
                $data->password = Hash::make($request->password);
                $type = 0;
                switch ($request->roles_id) {
                    case 67: //Admin
                        $type = 0;
                        break;
                    case 68: //Case Manager
                        $type = 1;
                        break;
                    case 69: //Specialists
                        $type = 2;
                        break;
                    case 70: //Facilitators
                        $type = 3;
                        break;
                    case 71: //Supervisors
                        $type = 4;
                        break;
                    case 72: //Case Managers Supervisors
                        $type = 5;
                        break;
                    case 73: //Specialist Supervisors
                        $type = 6;
                        break;
                }
                $data->user_type = $type;
                $data->user_status = 1;
                $data->roles_id = $request->roles_id;
                $data->roles_name = $request->roles_name;
                $data->created_at = Carbon::now();
                $data->updated_at = Carbon::now();
                $data->save();
                $data->assignRole($request->roles_id);
                $role = Role::query()->find($request->roles_id);
                foreach ($role->role_permissions as $permission) {
                    $user_permi = new AdminPermissions();
                    $user_permi->permission_id = $permission->permission_id;
                    $user_permi->model_type = "App\Models\User";
                    $user_permi->model_id = $data->id;
                    $user_permi->save();
                }
                return response()->json(['success' => $data]);
            }
            return response()->json(['error' => $validator->errors()->toArray()]);
        }
    }

    public function update(Request $request , $id){

        if ($request->ajax()) {
         $data = User::query()->find($id);
        $old_email = $data->email;
        $old_mobile = $data->mobile;
        $validator = [];
        $image = uniqid() . '.jpg';
        $image_path = "uploads/admins/$image";
        file_put_contents($image_path, base64_decode($request->user_image));
        if ($request->image_updated == 1){
        $data->personal_photo = $request->user_image;
        }
        if ($request->image_updated == 1)
            $data->personal_photo = $image;
        $data->full_name = $request->name;
        $data->email = $request->email;
        $data->mobile_number = $request->mobile;
        $type = 0;
        switch ($request->roles_id) {
            case 67: //Admin
                $type = 0;
                break;
            case 68: //Case Manager
                $type = 1;
                break;
            case 69: //Specialists
                $type = 2;
                break;
            case 70: //Facilitators
                $type = 3;
                break;
            case 71: //Supervisors
                $type = 4;
                break;
            case 72: //Case Managers Supervisors
                $type = 5;
                break;
            case 73: //Specialist Supervisors
                $type = 6;
                break;
        }
        $data->user_type = $type;
        $data->user_status = 1;
        $data->roles_id = $request->roles_id;
        $data->updated_at = Carbon::now();
        if ($request->password) {
            $data->password = Hash::make($request->password);
        }
        $data->save();
        $old_roles = AdminRoles::query()->where("model_id", $id)->delete();
        $old_permissions = AdminPermissions::query()->where("model_id", $id)->delete();
        $role = Role::query()->find($request->roles_id);
        $data->assignRole($request->roles_id);
        foreach ($role->role_permissions as $permission) {
            $user_permi = new AdminPermissions();
            $user_permi->permission_id = $permission->permission_id;
            $user_permi->model_type = "App\Models\User";
            $user_permi->model_id = $id;
            $user_permi->save();
        }
        return response()->json(['success' => $data]);
        }

    }
    public function destroy($id)
    {
        $data = User::query()->find($id)->delete();
        if ($data)
            return response()->json(['success' => 'success']);
        else
            return response()->json(['error' => 'error']);
    }


}
