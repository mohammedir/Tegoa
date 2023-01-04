<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TourController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Tour::query()->latest();
            return Datatables::of($data)->addIndexColumn()
                ->editColumn('full_name', function ($data) {
                    return $data->full_name;
                })
                ->addColumn('map', function ($data) {
                    return '<a id="showMap" style="text-decoration:underline;color: #ceb115;" class="show" data-id="' . $data->id . '" data-bs-toggle="modal" data-bs-target="#kt_modal_show_maps">' . trans("web.maps") . '</a>';
                })
                ->editColumn('status', function ($data) {
                    if ($data->status == 1){
                        $status =  '<div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input checkBox" name="toggle[' . $data->id . ']" id="' . $data->id . '"  type="checkbox" value="' . $data->id . '" id="flexSwitchChecked" onclick="getStatus(this)"  checked />
                            <label class="form-check-label" for="flexSwitchChecked">
                            </label>
                                </div>';
                    }else{
                        $status =  '<div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input checkBox" name="toggle[' . $data->id . ']" id="' . $data->id . '"  type="checkbox" value="' . $data->id . '" id="flexSwitchChecked"  onclick="getStatus(this)" />
                            <label class="form-check-label" for="flexSwitchChecked">
                            </label>
                                </div>';
                    }
                    return $status;
                })
                ->addColumn('others', function ($data) {
                    $actions = '<button id="show" data-id="' . $data->id . '" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_show_tour">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                    <span class="svg-icon svg-icon-3">
																	<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"/>
                                                                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor"/>
                                                                    </svg>
																</span>
                                    <!--end::Svg Icon-->
                                </button>
                                <button id="edit" data-id="' . $data->id . '" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_tours">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                    <span class="svg-icon svg-icon-3">
																	<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																		<path d="M17.5 11H6.5C4 11 2 9 2 6.5C2 4 4 2 6.5 2H17.5C20 2 22 4 22 6.5C22 9 20 11 17.5 11ZM15 6.5C15 7.9 16.1 9 17.5 9C18.9 9 20 7.9 20 6.5C20 5.1 18.9 4 17.5 4C16.1 4 15 5.1 15 6.5Z" fill="currentColor" />
																		<path opacity="0.3" d="M17.5 22H6.5C4 22 2 20 2 17.5C2 15 4 13 6.5 13H17.5C20 13 22 15 22 17.5C22 20 20 22 17.5 22ZM4 17.5C4 18.9 5.1 20 6.5 20C7.9 20 9 18.9 9 17.5C9 16.1 7.9 15 6.5 15C5.1 15 4 16.1 4 17.5Z" fill="currentColor" />
																	</svg>
																</span>
                                    <!--end::Svg Icon-->
                                </button>
                                <!--end::Update-->
                                <!--begin::Delete-->
                                <button id="delete" data-id="' . $data->id . '" class="btn btn-icon btn-active-light-primary w-30px h-30px" data-kt-permissions-table-filter="delete_row">
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

                    return $actions;

                })
                ->rawColumns(['others'])
                ->escapeColumns([])
                ->make(true);
        }
        return view('tour.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'address_en' => 'required|string|max:255',
            'address_ar' => 'required|string|max:255',
            'gender' => 'required|numeric',
            'spoken_languages' => 'required|array',
            'email' => 'required|email|unique:tour_guids|max:255',
            'phone_number' => 'required|numeric',
            'fileupload' => 'required|mimes:jpeg,png,jpg'
        ], [
            'name_en.required' => trans("web.required"),
            'name_en.string' => trans("web.string"),
            'name_en.max' => trans("web.max"),
            'name_ar.required' => trans("web.required"),
            'name_ar.string' => trans("web.string"),
            'name_ar.max' => trans("web.max"),

            'address_en.required' => trans("web.required"),
            'address_en.string' => trans("web.string"),
            'address_en.max' => trans("web.max"),
            'address_ar.required' => trans("web.required"),
            'address_ar.string' => trans("web.string"),
            'address_ar.max' => trans("web.max"),

            'gender.required' => trans("web.required"),
            'gender.numeric' => trans("web.numeric"),

            'spoken_languages.required' => trans("web.required"),

            'email.required' => trans("web.required"),
            'email.email' => trans("web.email"),
            'email.max' => trans("web.max"),
            'email.unique' => trans("web.unique"),

            'phone_number.required' => trans("web.required"),
            'phone_number.numeric' => trans("web.numeric"),

            'fileupload.required' => trans("web.required"),
            'fileupload.mimes' => trans("web.mimes"),

        ]);
        if ($validator->passes()) {
            $data = new Tour();
            $data->full_name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $data->address = ['en' => $request->address_en, 'ar' => $request->address_ar];
            $data->gender = $request->gender;
            $data->spoken_languages = $request->spoken_languages;
            $data->status = 1;
            $data->email = $request->email;
            $data->phone_number = $request->phone_number;
            if ($request->file('fileupload')) {
                $value = $request->file('fileupload');
                $name = time().rand(1,100).'.'.$value->extension();
                $value->move('images/tours/', $name);
                $data->image = $name;
            }
            $data->save();
            return response()->json(['success' => $data]);
        }
        return response()->json(['error' => $validator->errors()->toArray()]);

    }

    public function show(Request $request,Tour $tour)
    {
        if ($request->ajax()) {
            $selected =[];
            $tour = Tour::find($tour->id);
            if ($tour->status == 1) {
                $status = '<span class="badge badge-success" style="font-size: 13px;">' . trans('web.active') . '</span>';
            } else {
                $status = '<span class="badge badge-danger" style="font-size: 13px;">' . trans('web.inactive') . '</span>';
            }
            if ($tour->gender == 1) {
                $gender = '<span >' . trans('web.Male') . '</span>';
            } else {
                $gender = '<span>' . trans('web.Female') . '</span>';
            }
            $values = [$tour->spoken_languages];
            foreach ($values as $value){
                $selected[] = $value;
            }
            return response()->json(['tour'=>$tour,'status'=>$status,'spoken'=>$values,'gender'=>$gender]);
        }
    }

    public function edit(Request $request,Tour $tour)
    {
        if ($request->ajax()) {
            $selected = [];
            $tour = Tour::find($tour->id);
            $values = [$tour->spoken_languages];
            foreach ($values as $value){
                $selected[] = $value;
            }
            return response()->json(['tour'=>$tour,'selected'=>$selected]);
        }
    }

    public function update(Request $request, Tour $tour)
    {
//        dd($tour->id);
        $validator = Validator::make($request->all(), [
            'name_en_edit' => 'required|string|max:255',
            'name_ar_edit' => 'required|string|max:255',
            'address_en_edit' => 'required|string|max:255',
            'address_ar_edit' => 'required|string|max:255',
            'gender_edit' => 'required|numeric',
            'spoken_languages_edit' => 'required|array',
            'email_edit' => 'required|email|max:255|unique:tour_guids,email,' . $tour->id,
            'phone_number_edit' => 'required|numeric',
            'fileuploads' => $request->fileuploads != 'undefined' ? 'mimes:jpeg,jpg,png|sometimes' : '',
        ], [
            'name_en_edit.required' => trans("web.required"),
            'name_en_edit.string' => trans("web.string"),
            'name_en_edit.max' => trans("web.max"),
            'name_ar_edit.required' => trans("web.required"),
            'name_ar_edit.string' => trans("web.string"),
            'name_ar_edit.max' => trans("web.max"),

            'address_en_edit.required' => trans("web.required"),
            'address_en_edit.string' => trans("web.string"),
            'address_en_edit.max' => trans("web.max"),
            'address_ar_edit.required' => trans("web.required"),
            'address_ar_edit.string' => trans("web.string"),
            'address_ar_edit.max' => trans("web.max"),

            'gender_edit.required' => trans("web.required"),
            'gender_edit.numeric' => trans("web.numeric"),

            'spoken_languages_edit.required' => trans("web.required"),

            'email_edit.required' => trans("web.required"),
            'email_edit.email' => trans("web.email"),
            'email_edit.max' => trans("web.max"),
            'email_edit.unique' => trans("web.unique"),

            'phone_number_edit.required' => trans("web.required"),
            'phone_number_edit.numeric' => trans("web.numeric"),

            'fileuploads.mimes' => trans("web.mimes"),

        ]);
        if ($validator->passes()) {
            $data = Tour::find($tour->id);
            $data->full_name = ['en' => $request->name_en_edit, 'ar' => $request->name_ar_edit];
            $data->address = ['en' => $request->address_en_edit, 'ar' => $request->address_ar_edit];
            $data->gender = $request->gender_edit;
            $data->spoken_languages = $request->spoken_languages_edit;
            $data->email = $request->email_edit;
            $data->phone_number = $request->phone_number_edit;
            if ($request->input('fileuploads') != 'undefined') {
                $value = $request->file('fileuploads');
                $name = time() . rand(1, 100) . '.' . $value->extension();
                $value->move('images/tours/', $name);
                $data->image = $name;
            }
            $data->save();

            return response()->json(['success' => $data]);
        }
        return response()->json(['error' => $validator->errors()->toArray()]);

    }

    public function destroy(Request $request,Tour $tour)
    {
        if ($request->ajax()){
            $tour = Tour::find($tour->id)->delete();
            return response()->json(['success' => $tour]);
        }
    }
    public function changeStatus(Request $request)
    {
        if ($request->ajax()){
            $data = Tour::find($request->id);
            if ($request->isChecked == "true"){
                $data->status = 1;
                $data->save();
            }else{
                $data->status = 0;
                $data->save();
            }
            return response()->json('success');
        }
    }
}
