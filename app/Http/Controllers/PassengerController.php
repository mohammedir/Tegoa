<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PassengerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:passengers_view|passengers_create|passengers_edit']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Passenger::query()->where('user_type', "=", 1)->latest();
            return Datatables::of($data)->addIndexColumn()
                ->editColumn('status', function ($data) {
                    if (Auth::user()->hasPermissionTo('passengers_edit')) {
                        if ($data->user_status == 1) {
                            $status = '<div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input checkBox" name="toggle[' . $data->id . ']" id="' . $data->id . '"  type="checkbox" value="' . $data->id . '" id="flexSwitchChecked" onclick="getStatusDrivers(this)"  checked />
                            <label class="form-check-label" for="flexSwitchChecked">
                            </label>
                                </div>';
                        } else {
                            $status = '<div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input checkBox" name="toggle[' . $data->id . ']" id="' . $data->id . '"  type="checkbox" value="' . $data->id . '" id="flexSwitchChecked"  onclick="getStatusDrivers(this)" />
                            <label class="form-check-label" for="flexSwitchChecked">
                            </label>
                                </div>';
                        }
                        return $status;
                    } else {
                        if ($data->status == 1) {
                            return trans('web.active');
                        } else {
                            return trans('web.inactive');
                        }
                    }
                })
                ->addColumn('others', function ($data) {
                    $actions = '<button id="show" data-id="' . $data->id . '" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_show_drivers">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                    <span class="svg-icon svg-icon-3">
																	<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"/>
                                                                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor"/>
                                                                    </svg>
																</span>
                                    <!--end::Svg Icon-->
                                </button>';
                    if (Auth::user()->hasPermissionTo('passengers_edit')) {
                        $actions = $actions . '<button id="edit" data-id="' . $data->id . '" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_drivers">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                    <span class="svg-icon svg-icon-3">
																	<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																		<path d="M17.5 11H6.5C4 11 2 9 2 6.5C2 4 4 2 6.5 2H17.5C20 2 22 4 22 6.5C22 9 20 11 17.5 11ZM15 6.5C15 7.9 16.1 9 17.5 9C18.9 9 20 7.9 20 6.5C20 5.1 18.9 4 17.5 4C16.1 4 15 5.1 15 6.5Z" fill="currentColor" />
																		<path opacity="0.3" d="M17.5 22H6.5C4 22 2 20 2 17.5C2 15 4 13 6.5 13H17.5C20 13 22 15 22 17.5C22 20 20 22 17.5 22ZM4 17.5C4 18.9 5.1 20 6.5 20C7.9 20 9 18.9 9 17.5C9 16.1 7.9 15 6.5 15C5.1 15 4 16.1 4 17.5Z" fill="currentColor" />
																	</svg>
																</span>
                                    <!--end::Svg Icon-->
                                </button>';
                    }
                    if (Auth::user()->hasPermissionTo('passengers_delete')) {
                        $actions = $actions . ' <button id="delete" data-id="' . $data->id . '" class="btn btn-icon btn-active-light-primary w-30px h-30px" data-kt-permissions-table-filter="delete_row">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                    <span class="svg-icon svg-icon-3">
																	<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																		<path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
																		<path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
																		<path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
																	</svg>
																</span>
                                    <!--end::Svg Icon-->
                                </button>';
                    }
                    return $actions;
                })
                ->rawColumns(['others'])
                ->escapeColumns([])
                ->make(true);
        }
        return view('admin-management.passengers.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'address' => 'required|string',
            'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:8',
            'gender' => 'required|numeric',
            'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|unique:users,email|max:255',
            'mobile' => 'required|string|min:10|max:14|unique:users,mobile_number',
        ], [
            'name.required' => trans("web.required"),
            'name.string' => trans("web.string"),
            'name.max' => trans("web.max"),

            'address.required' => trans("web.required"),
            'address.string' => trans("web.string"),
            'address.max' => trans("web.max"),

            'password.min' => trans("web.min"),
            'password.same' => trans("web.same"),
            'password.required_with' => trans("web.required_with"),
            'password_confirmation.min' => trans("web.min"),

            'gender.required' => trans("web.required"),
            'gender.numeric' => trans("web.numeric"),

            'email.required' => trans("web.required"),
            'email.email' => trans("web.email"),
            'email.max' => trans("web.max"),
            'email.unique' => trans("web.unique"),
            'email.regex' => trans("web.regex"),

            'mobile.required' => trans("web.required"),
            'mobile.numeric' => trans("web.numeric"),
            'mobile.unique' => trans("web.uniqueNumber"),
            'mobile.min' => trans("web.minPhone"),
            'mobile.max' => trans("web.maxPhone"),
        ]);
        if ($validator->passes()) {
            $data = new Passenger();
            $data->full_name = $request->name;
            $data->address = $request->address;
            $data->gender = $request->gender;
            $data->email = $request->email;
            $data->mobile_number = $request->mobile;
            $data->password = Hash::make($request->password);
            $data->user_type = 1;
            $data->save();

            return response()->json(['success' => $data]);
        }
        return response()->json(['error' => $validator->errors()->toArray()]);

    }

    public function show(Request $request, Passenger $passenger)
    {
        if ($request->ajax()) {
            $passenger = Passenger::find($passenger->id);

            if ($passenger->gender == 1) {
                $gender = trans('web.Male');
            } else {
                $gender = trans('web.Female');
            }

            return response()->json(['driver' => $passenger, 'gender' => $gender]);
        }
    }

    public function edit(Request $request, Passenger $passenger)
    {
        if ($request->ajax()) {
            $passenger = Passenger::find($passenger->id);
            return response()->json($passenger);
        }
    }

    public function update(Request $request, Passenger $passenger)
    {
        $validator = Validator::make($request->all(), [
            'name_edit' => 'required|string|max:255',
            'address_edit' => 'required|string|max:255',
            'gender_edit' => 'required|numeric',
            'email_edit' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|max:255|unique:users,email,' . $passenger->id,
            'mobile_edit' => 'required|string|min:10|max:14|unique:users,mobile_number,' . $passenger->id,
        ], [
            'name_edit.required' => trans("web.required"),
            'name_edit.string' => trans("web.string"),
            'name_edit.max' => trans("web.max"),

            'address_edit.required' => trans("web.required"),
            'address_edit.string' => trans("web.string"),
            'address_edit.max' => trans("web.max"),

            'gender_edit.required' => trans("web.required"),
            'gender_edit.numeric' => trans("web.numeric"),

            'email_edit.required' => trans("web.required"),
            'email_edit.email' => trans("web.email"),
            'email_edit.max' => trans("web.max"),
            'email_edit.unique' => trans("web.unique"),
            'email_edit.regex' => trans("web.regex"),

            'mobile_edit.required' => trans("web.required"),
            'mobile_edit.numeric' => trans("web.numeric"),
            'mobile_edit.unique' => trans("web.uniqueNumber"),
            'mobile_edit.min' => trans("web.minPhone"),
            'mobile_edit.max' => trans("web.maxPhone"),

        ]);
        if ($validator->passes()) {
            $data = Passenger::find($passenger->id);
            $data->full_name = $request->name_edit;
            $data->address = $request->address_edit;
            $data->gender = $request->gender_edit;
            $data->email = $request->email_edit;
            $data->mobile_number = $request->mobile_edit;
            $data->save();

            return response()->json(['success' => $data]);
        }
        return response()->json(['error' => $validator->errors()->toArray()]);

    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->passengers->count()) {
            return response()->json(['error' => trans('web.Passenger has transportations, cannot be deleted')]);
        }else{
            $user->delete();
            return response()->json(['success' => 'success']);
        }
    }
}
