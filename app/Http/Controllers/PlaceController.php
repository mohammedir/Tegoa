<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class PlaceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:places_view|places_create|places_edit|places_delete']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Place::query()->latest();
            return Datatables::of($data)->addIndexColumn()
                ->editColumn('name', function ($data) {
                    return Str::limit($data->name,20) ;
                })->editColumn('description', function ($data) {
                    return Str::limit($data->description,20) ;
                })->editColumn('address', function ($data) {
                    return Str::limit($data->address,20) ;
                })
                ->addColumn('map', function ($data) {
                    return '<a id="showMap" style="text-decoration:underline;color: #ceb115;" class="show" data-id="' . $data->id . '" data-bs-toggle="modal" data-bs-target="#kt_modal_show_maps">' . trans("web.maps") . '</a>';
                })
                ->editColumn('type', function ($data) {
                    if ($data->type == 1) {
                        $status = trans('web.place');
                    } elseif ($data->type == 2) {
                        $status = trans('web.tourism sites');
                    } else {
                        $status = trans('web.stations');
                    }
                    return $status;
                })
                ->addColumn('others', function ($data) {
                    $actions = '<button id="show" data-id="' . $data->id . '" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_show_places">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                    <span class="svg-icon svg-icon-3">
																	<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"/>
                                                                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor"/>
                                                                    </svg>
																</span>
                                    <!--end::Svg Icon-->
                                </button>';
                    if (Auth::user()->hasPermissionTo('places_edit')) {
                        $actions = $actions . '<button id="edit" data-id="' . $data->id . '" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_places">
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
                    if (Auth::user()->hasPermissionTo('places_delete')) {
                        $actions = $actions . ' <button id="delete" data-id="' . $data->id . '" class="btn btn-icon btn-active-light-primary w-30px h-30px" data-kt-permissions-table-filter="delete_row">
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
        return view('places.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'type' => ['required','numeric',Rule::in(['1','2','3'])],
                'type_station' => ['sometimes','numeric',Rule::in(['1','2'])],
                'lat' => 'required|numeric',
                'long' => 'required|numeric',
                'name_en' => 'required|string',
                'name_ar' => 'required|string',
                'description_en' => 'required|string',
                'description_ar' => 'required|string',
                'address_en' => 'required|string',
                'address_ar' => 'required|string',
                'fileupload' => 'required|mimes:jpeg,png,jpg'
            ], [
                'type.required' => trans("web.required"),
                'type.numeric' => trans("web.numeric"),
                'type.in' => trans("web.in"),

                'type_station.required' => trans("web.required"),
                'type_station.numeric' => trans("web.numeric"),
                'type_station.in' => trans("web.in"),

                'lat.required' => trans("web.required"),
                'lat.numeric' => trans("web.numeric"),

                'long.required' => trans("web.required"),
                'long.numeric' => trans("web.numeric"),

                'name_en.required' => trans("web.required"),
                'name_en.string' => trans("web.string"),
                'name_en.max' => trans("web.max"),
                'name_ar.required' => trans("web.required"),
                'name_ar.string' => trans("web.string"),
                'name_ar.max' => trans("web.max"),

                'description_en.required' => trans("web.required"),
                'description_en.string' => trans("web.string"),
                'description_en.max' => trans("web.max"),
                'description_ar.required' => trans("web.required"),
                'description_ar.string' => trans("web.string"),
                'description_ar.max' => trans("web.max"),

                'address_en.required' => trans("web.required"),
                'address_en.string' => trans("web.string"),
                'address_en.max' => trans("web.max"),
                'address_ar.required' => trans("web.required"),
                'address_ar.string' => trans("web.string"),
                'address_ar.max' => trans("web.max"),

                'fileupload.required' => trans("web.required"),
                'fileupload.mimes' => trans("web.mimes"),

            ]);
            if ($validator->passes()) {
                $data = new Place();
                $data->name = ['en' => $request->name_en, "ar" => $request->name_ar];
                $data->description = ['en' => $request->description_en, "ar" => $request->description_ar];
                $data->address = ['en' => $request->address_en, "ar" => $request->address_ar];
                $data->type = $request->type;
                $data->type_station = $request->type_station;
                $data->lat = $request->lat;
                $data->long = $request->long;

                if ($request->file('fileupload')) {
                    $value = $request->file('fileupload');
                    $name = time() . rand(1, 100) . '.' . $value->extension();
                    $value->move('images/places/', $name);
                    $data->image = $name;
                }

                $data->save();


                return response()->json(['success' => $data]);
            }
            return response()->json(['error' => $validator->errors()->toArray()]);
        }
    }

    public function show(Request $request,Place $place)
    {
        if ($request->ajax()) {
            $place = Place::find($place->id);
            if ($place->type == 1) {
                $type =  trans('web.places');
            }elseif ($place->type == 2) {
                $type =  trans('web.tourism sites');
            } else {
                $type =  trans('web.stations');
            }
            return response()->json(['place'=>$place,'type'=>$type]);
        }
    }

    public function edit(Request $request, Place $place)
    {
        if ($request->ajax()) {
            $place = Place::find($place->id);
            return response()->json($place);
        }
    }

    public function update(Request $request, Place $place)
    {
        $validator = Validator::make($request->all(), [
            'type_edit' => ['required','numeric',Rule::in(['1','2','3'])],
            'type_station_edit' => ['sometimes','numeric',Rule::in(['1','2'])],
            'lat_edit' => 'required|numeric',
            'long_edit' => 'required|numeric',
            'name_en_edit' => 'required|string',
            'name_ar_edit' => 'required|string',
            'description_en_edit' => 'required|string',
            'description_ar_edit' => 'required|string',
            'address_en_edit' => 'required|string',
            'address_ar_edit' => 'required|string',
            'fileuploads' => $request->fileuploads != 'undefined' ? 'mimes:jpeg,jpg,png|sometimes' : '',
        ], [
            'type_edit.required' => trans("web.required"),
            'type_edit.numeric' => trans("web.numeric"),
            'type_edit.in' => trans("web.in"),

            'type_station_edit.required' => trans("web.required"),
            'type_station_edit.numeric' => trans("web.numeric"),
            'type_station_edit.in' => trans("web.in"),

            'lat_edit.required' => trans("web.required"),
            'lat_edit.numeric' => trans("web.numeric"),

            'long_edit.required' => trans("web.required"),
            'long_edit.numeric' => trans("web.numeric"),

            'name_en_edit.required' => trans("web.required"),
            'name_en_edit.string' => trans("web.string"),
            'name_en_edit.max' => trans("web.max"),
            'name_ar_edit.required' => trans("web.required"),
            'name_ar_edit.string' => trans("web.string"),
            'name_ar_edit.max' => trans("web.max"),

            'description_en_edit.required' => trans("web.required"),
            'description_en_edit.string' => trans("web.string"),
            'description_en_edit.max' => trans("web.max"),
            'description_ar_edit.required' => trans("web.required"),
            'description_ar_edit.string' => trans("web.string"),
            'description_ar_edit.max' => trans("web.max"),

            'address_en_edit.required' => trans("web.required"),
            'address_en_edit.string' => trans("web.string"),
            'address_en_edit.max' => trans("web.max"),
            'address_ar_edit.required' => trans("web.required"),
            'address_ar_edit.string' => trans("web.string"),
            'address_ar_edit.max' => trans("web.max"),

            'fileuploads.mimes' => trans("web.mimes"),

        ]);
        if ($validator->passes()) {
            $data = Place::find($place->id);
            $data->name = ['en' => $request->name_en_edit, "ar" => $request->name_ar_edit];
            $data->description = ['en' => $request->description_en_edit, "ar" => $request->description_ar_edit];
            $data->address = ['en' => $request->address_en_edit, "ar" => $request->address_ar_edit];
            $data->type = $request->type_edit;
            $data->type_station = $request->type_station_edit;
            $data->lat = $request->lat_edit;
            $data->long = $request->long_edit;
            if ($request->input('fileuploads') != 'undefined') {
                $value = $request->file('fileuploads');
                $name = time() . rand(1, 100) . '.' . $value->extension();
                $value->move('images/places/', $name);
                $data->image = $name;
            }
            $data->save();

            return response()->json(['success' => $data]);
        }
        return response()->json(['error' => $validator->errors()->toArray()]);

    }

    public function destroy(Place $place)
    {
        $place = Place::find($place->id)->delete();
        return response()->json(['success' => $place]);
    }

    public function map(Request $request)
    {
        $map = Place::find($request->id);
        return response()->json($map);
    }

}
