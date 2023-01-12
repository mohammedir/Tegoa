<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:activities_view|activities_create|activities_edit|activities_delete']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Activity::query()->latest();
            return Datatables::of($data)->addIndexColumn()
                ->editColumn('name', function ($data) {
                    return Str::limit($data->name,20) ;
                })->editColumn('description', function ($data) {
                    return Str::limit($data->description,20) ;
                })->editColumn('status', function ($data) {
                    if (Auth::user()->hasPermissionTo('activities_edit')) {
                        if ($data->status == 1) {
                            $status = '<div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input checkBox" name="toggle[' . $data->id . ']" id="' . $data->id . '"  type="checkbox" value="' . $data->id . '" id="flexSwitchChecked" onclick="getStatusEmergency(this)"  checked />
                            <label class="form-check-label" for="flexSwitchChecked">
                            </label>
                                </div>';
                        } else {
                            $status = '<div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input checkBox" name="toggle[' . $data->id . ']" id="' . $data->id . '"  type="checkbox" value="' . $data->id . '" id="flexSwitchChecked"  onclick="getStatusEmergency(this)" />
                            <label class="form-check-label" for="flexSwitchChecked">
                            </label>
                                </div>';
                        }
                        return $status;
                    }else{
                        if ($data->status == 1){
                            return trans('web.active');
                        }else{
                            return trans('web.inactive');
                        }
                    }
                })
                ->addColumn('others', function ($data) {
                    $actions = '<button id="show" data-id="' . $data->id . '" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_show_activities">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                    <span class="svg-icon svg-icon-3">
																	<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"/>
                                                                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor"/>
                                                                    </svg>
																</span>
                                    <!--end::Svg Icon-->
                                </button>';
                    if (Auth::user()->hasPermissionTo('activities_edit')) {
                        $actions = $actions . '<button id="edit" data-id="' . $data->id . '" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_activities">
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
                    if (Auth::user()->hasPermissionTo('activities_delete')) {
                        $actions = $actions . '<button id="delete" data-id="' . $data->id . '" class="btn btn-icon btn-active-light-primary w-30px h-30px" data-kt-permissions-table-filter="delete_row">
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
        return view('activities.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'required_tools_en' => 'required|string',
            'required_tools_ar' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'fileupload' => 'required|mimes:jpeg,png,jpg'
        ], [
            'name_en.required' => trans("web.required"),
            'name_en.string' => trans("web.string"),
            'name_ar.required' => trans("web.required"),
            'name_ar.string' => trans("web.string"),

            'description_en.required' => trans("web.required"),
            'description_en.string' => trans("web.string"),
            'description_ar.required' => trans("web.required"),
            'description_ar.string' => trans("web.string"),

            'required_tools_en.required' => trans("web.required"),
            'required_tools_en.string' => trans("web.string"),
            'required_tools_ar.required' => trans("web.required"),
            'required_tools_ar.string' => trans("web.string"),

            'start_date.required' => trans("web.required"),
            'start_date.date' => trans("web.date"),

            'end_date.required' => trans("web.required"),
            'end_date.date' => trans("web.date"),
            'end_date.after_or_equal' => trans("web.after_or_equal"),

            'fileupload.required' => trans("web.required"),
            'fileupload.mimes' => trans("web.mimes"),
        ]);
        if ($validator->passes()) {
            $data = new Activity();
            $data->name = ["en" => $request->name_en, "ar" => $request->name_ar];
            $data->description = ["en" => $request->description_en, "ar" => $request->description_ar];
            $data->required_tools = ["en" => $request->required_tools_en, "ar" => $request->required_tools_ar];
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->status = 1;
            if ($request->file('fileupload')) {
                $value = $request->file('fileupload');
                $name = time().rand(1,100).'.'.$value->extension();
                $value->move('images/activities/', $name);
                $data->image = $name;
            }
            $data->save();

            return response()->json(['success' => $data]);
        }
        return response()->json(['error' => $validator->errors()->toArray()]);

    }

    public function show(Request $request,Activity $activity)
    {
        if ($request->ajax()) {
            $activity = Activity::find($activity->id);
            if ($activity->status == 1) {
                $status = '<span class="badge badge-success" style="font-size: 13px;">' . trans('web.active') . '</span>';
            } else {
                $status = '<span class="badge badge-danger" style="font-size: 13px;">' . trans('web.inactive') . '</span>';
            }
            return response()->json(['activity'=>$activity,'status'=>$status]);
        }
    }

    public function edit(Request $request,Activity $activity)
    {
        if ($request->ajax()) {
            $activity = Activity::find($activity->id);
            return response()->json($activity);
        }
    }

    public function update(Request $request, Activity $activity)
    {
        $validator = Validator::make($request->all(), [
            'name_en_edit' => 'required|string',
            'name_ar_edit' => 'required|string',
            'description_en_edit' => 'required|string',
            'description_ar_edit' => 'required|string',
            'required_tools_en_edit' => 'required|string',
            'required_tools_ar_edit' => 'required|string',
            'start_date_edit' => 'required|date',
            'end_date_edit' => 'required|date',
            'fileuploads' => $request->fileuploads != 'undefined' ? 'mimes:jpeg,jpg,png|sometimes' : '',
        ], [
            'name_en_edit.required' => trans("web.required"),
            'name_en_edit.string' => trans("web.string"),
            'name_ar_edit.required' => trans("web.required"),
            'name_ar_edit.string' => trans("web.string"),

            'description_en_edit.required' => trans("web.required"),
            'description_en_edit.string' => trans("web.string"),
            'description_ar_edit.required' => trans("web.required"),
            'description_ar_edit.string' => trans("web.string"),

            'required_tools_en_edit.required' => trans("web.required"),
            'required_tools_en_edit.string' => trans("web.string"),
            'required_tools_ar_edit.required' => trans("web.required"),
            'required_tools_ar_edit.string' => trans("web.string"),

            'start_date_edit.required' => trans("web.required"),
            'start_date_edit.date' => trans("web.date"),

            'end_date_edit.required' => trans("web.required"),
            'end_date_edit.date' => trans("web.date"),

            'fileuploads.mimes' => trans("web.mimes"),
            'fileuploads.uploaded' => trans("web.uploaded"),

        ]);
        if ($validator->passes()) {
            $data = Activity::find($activity->id);
            $data->name = ["en" => $request->name_en_edit, "ar" => $request->name_ar_edit];
            $data->description = ["en" => $request->description_en_edit, "ar" => $request->description_ar_edit];
            $data->required_tools = ["en" => $request->required_tools_en_edit, "ar" => $request->required_tools_ar_edit];
            $data->start_date = $request->start_date_edit;
            $data->end_date = $request->end_date_edit;
            if ($request->input('fileuploads') != 'undefined'){
                $value = $request->file('fileuploads');
                $name = time().rand(1,100).'.'.$value->extension();
                $value->move('images/activities/', $name);
                $data->image = $name;
            }
            $data->save();
            return response()->json(['success' => $data]);
        }
        return response()->json(['error' => $validator->errors()->toArray()]);

    }

    public function destroy(Activity $activity)
    {
        $activity = Activity::find($activity->id)->delete();
        return response()->json(['success' => $activity]);
    }
    public function changeStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = Activity::find($request->id);
            if ($request->isChecked == "true") {
                $data->status = 1;
                $data->save();
            } else {
                $data->status = 2;
                $data->save();
            }
            return response()->json('success');
        }
    }
}
