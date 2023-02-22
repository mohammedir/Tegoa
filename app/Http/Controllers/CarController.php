<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Driver;
use App\Models\Photos;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CarController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:cars_view|cars_edit']);
    }

    public function index(Request $request)
    {
        $cars = Car::query()->get();
        if ($request->ajax()) {
            $data = Car::query()->orderBy('id', 'DESC')->get();
            return Datatables::of($data)->addIndexColumn()
                ->editColumn('Name', function ($data) {
                    return '<a href="' . route("drivers.index") . '?input_value='.User::find($data->user_id)->full_name.'"">' . User::find($data->user_id)->full_name . '</a>';
                })
                ->editColumn('car_number', function ($data) {
                    return Str::limit($data->car_number, 20);;
                })
                ->editColumn('car_brand', function ($data) {
                    return Str::limit($data->car_brand, 20);;
                })
                ->editColumn('insurance_number', function ($data) {
                    return Str::limit($data->insurance_number, 20);;
                })
                ->editColumn('status', function ($data) {
                    if ($data->status == 0) {
                        $status = '<div style="color: #ffc700">' . trans('web.review') . '</div>';
                    } elseif ($data->status == 1) {
                        $status = '<div>' . trans('web.accepted') . '</div>';
                    } else {
                        $status = '<div style="color: red">' . trans('web.declined') . '</div>';
                    }
                    return $status;
                })
                ->editColumn('email', function ($data) {
                    if ($data->is_email_verified == 1) {
                        $email = '<div style="color: #00ff15">' . trans('web.Yes') . '</div>';
                    } elseif ($data->is_email_verified == null) {
                        $email = '<div style="color: #ff0000">' . trans('web.No') . '</div>';
                    }else{
                        $email = 'error';
                    }
                    return $email;
                })
                ->addColumn('others', function ($data) {
                    if (Auth::user()->hasPermissionTo('cars_edit')) {
                        $other = '<div style="display:flex;">';
                        if ($data->status == 0 || $data->status == 2) {
                            $other .= '<button id="show" data-id="' . $data->id . '" data-bs-toggle="modal" data-bs-target="#kt_modal_detail_car"  class="btn btn-warning" style="color:black;font-weight: bold; width: 90px !important; margin-left: 10px;">
                                    ' . trans('web.Details') . '</button>';
                        } else {
                            $other .= '<button id="edit" data-id="' . $data->id . '"  data-bs-toggle="modal" data-bs-target="#kt_modal_update_car" class="btn btn-warning" style="color:black;font-weight: bold; width: 90px !important; margin-left: 10px;">
                                    ' . trans('web.Edit') . '</button>';
                        }
                        $other .= '<button id="delete" data-id="' . $data->id . '"  class="btn btn-danger" style="font-weight: bold; margin-left: 10px;">
                                    ' . trans('web.Delete') . '</button>';
                        $other .= '</div>';
                        return $other;
                    }
                })
                ->rawColumns(['others'])
                ->escapeColumns([])
                ->make(true);
        }
        return view('cars.index', compact('cars'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'driver' => 'required|numeric',
            'number' => 'required|string',
            'brand' => 'required|string',
            'insurance_number' => 'required|string',
            'insurance_expiry_date' => 'required|date',
            'type' => 'required|numeric',
            'photos' => $request->photos != 'undefined' ? 'required|array' : '',
            'photos_carlicense' => $request->photos_carlicense != 'undefined' ? 'required|mimes:jpeg,png,jpg' : '',
            'photos_carinsurance' => $request->photos_carinsurance != 'undefined' ? 'required|mimes:jpeg,png,jpg' : '',
            'photos_passengersinsurance' => $request->photos_passengersinsurance != 'undefined' ? 'required|mimes:jpeg,png,jpg' : '',
        ], [
            'driver.required' => trans("web.required"),
            'driver.numeric' => trans("web.numeric"),

            'number.required' => trans("web.required"),
            'number.string' => trans("web.string"),

            'brand.required' => trans("web.required"),
            'brand.string' => trans("web.string"),

            'insurance_number.required' => trans("web.required"),
            'insurance_number.string' => trans("web.string"),

            'insurance_expiry_date.required' => trans("web.required"),
            'insurance_expiry_date.date' => trans("web.date"),

            'type.string' => trans("web.required"),
            'type.numeric' => trans("web.numeric"),

            'photos.required' => trans("web.required"),
            'photos.mimes' => trans("web.mimes"),

            'photos_carlicense.required' => trans("web.required"),
            'photos_carlicense.mimes' => trans("web.mimes"),

            'photos_carinsurance.required' => trans("web.required"),
            'photos_carinsurance.mimes' => trans("web.mimes"),

            'photos_passengersinsurance.required' => trans("web.required"),
            'photos_passengersinsurance.mimes' => trans("web.mimes"),


        ]);
        if ($validator->passes()) {
            $data = new Car();
            $data->user_id = $request->driver;
            $data->type = $request->type;
            $data->car_number = $request->number;
            $data->car_brand = $request->brand;
            $data->insurance_number = $request->insurance_number;
            $data->insurance_expiry_date = $request->insurance_expiry_date;
            $data->status = 1;
            $data->is_email_verified = 1;


            $value1 = $request->photos_carlicense;
            $name1 = time() . rand(1, 100) . '.' . $value1->extension();
            $value1->move('images/cars/', $name1);
            $data->carlicense = $name1;

            $value2 = $request->photos_carinsurance;
            $name2 = time() . rand(1, 100) . '.' . $value2->extension();
            $value2->move('images/cars/', $name2);
            $data->carinsurance = $name2;

            $value4 = $request->photos_passengersinsurance;
            $name4 = time() . rand(1, 100) . '.' . $value4->extension();
            $value4->move('images/cars/', $name4);
            $data->passengersinsurance = $name4;

            $value3 = $request->photos[0];
            $name_value3 = time() . rand(1, 100);
            $name3 = $name_value3 . '.' . $value3->extension();
            $data->carphotos = $name3;
            $data->save();

            foreach ($request->photos as $photo) {
                $value = $photo;
                $name = $name_value3 . '.' . $value->extension();
                $value->move('images/cars/', $name);
                $pic = new Photos();
                $pic->images = $name;
                $pic->car_id = $data->id;
                $pic->save();

            }

            return response()->json(['success' => $data]);
        }
        return response()->json(['error' => $validator->errors()->toArray()]);

    }

    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $images = [];
            $car = Car::find($id);
            $user = User::find($car->user_id)->full_name;
            $image = Photos::where('car_id', $car->id)->get();
            foreach ($image as $value) {
                $images[] = $value->images;
            }
            $type = "";
            if ($car->type == 1) {
                $type = trans('web.public');
            } else {
                $type = trans('web.private');
            }


            return response()->json(['type' => $type, 'car' => $car, 'user' => $user, 'image' => $images]);
        }
    }

    public function accept(Request $request)
    {
        if ($request->ajax()) {
            $car = Car::find($request->id);
            $car->status = 1;
            $car->save();
            if ($car) {
                $details = [
                    'title' => 'Mail from Teqoa',
                    'body' => 'This email to inform you that the registered vehicle is enabled successfully'
                ];
                $user = User::find($car->user_id)->email;
                try {
                    Mail::to($user)->send(new \App\Mail\StatusCar($details));
                    return response()->json(['response' => $car, 'email_status' => 'success']);
                } catch (Exception $e) {
                    return response()->json(['response' => $car, 'email_status' => 'failed']);
                }
            }

            return response()->json(['response' => $car]);
        }
    }

    public function deleteImage(Request $request)
    {
        if ($request->ajax()) {
            $images = [];
            $image = Photos::where('images', $request->id)->delete();
            $imagess = Photos::where('car_id', $request->car_id)->get();
            if ($imagess->isEmpty()) {
                return response()->json(['res' => "nothing"]);
            } else {
                foreach ($imagess as $value) {
                    $images[] = $value->images;
                }
                return response()->json(['image' => $images]);
            }
        }
    }

    public function decline(Request $request)
    {
        if ($request->ajax()) {
            $car = Car::find($request->id);
            $car->status = 2;
            $car->save();
            return response()->json(['response' => $car]);
        }
    }

    public function edit(Request $request, $id)
    {
        if ($request->ajax()) {
            $images = [];
            $car = Car::find($id);
            $user = User::find($car->user_id)->full_name;
            $image = Photos::where('car_id', $car->id)->get();
            foreach ($image as $value) {
                $images[] = $value->images;
            }
            return response()->json(['car' => $car, 'user' => $car, 'image' => $images]);
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'type_edit' => 'required|numeric',
                'number_edit' => 'required|string',
                'brand_edit' => 'required|string|max:255',
                'insurance_number_edit' => 'required|string|max:255',
                'insurance_expiry_date_edit' => 'required|date',
                'status' => 'required|numeric',
                'photos_edit' => 'sometimes|mimes:jpeg,png,jpg',
                'photos_carlicense_edit' => 'sometimes|mimes:jpeg,png,jpg',
                'photos_carinsurance_edit' => 'sometimes|mimes:jpeg,png,jpg',
                'photos_passengersinsurance_edit' => 'sometimes|mimes:jpeg,png,jpg'
            ], [
                'type_edit.required' => trans("web.required"),
                'type_edit.numeric' => trans("web.numeric"),

                'number_edit.required' => trans("web.required"),
                'number_edit.string' => trans("web.string"),

                'status.required' => trans("web.required"),
                'status.numeric' => trans("web.numeric"),

                'brand_edit.required' => trans("web.required"),
                'brand_edit.string' => trans("web.string"),
                'brand_edit.max' => trans("web.max"),

                'insurance_number_edit.required' => trans("web.required"),
                'insurance_number_edit.string' => trans("web.string"),
                'insurance_number_edit.max' => trans("web.max"),

                'insurance_expiry_date_edit.required' => trans("web.required"),
                'insurance_expiry_date_edit.date' => trans("web.date"),

                'photos_edit.uploaded' => trans("web.uploaded"),
                'photos_carlicense_edit.uploaded' => trans("web.uploaded"),
                'photos_carinsurance_edit.uploaded' => trans("web.uploaded"),
                'photos_passengersinsurance_edit.uploaded' => trans("web.uploaded"),
            ]);
            if ($validator->passes()) {
                $data = Car::find($id);
                $data->type = $request->type_edit;
                $data->car_number = $request->number_edit;
                $data->car_brand = $request->brand_edit;
                $data->insurance_number = $request->insurance_number_edit;
                $data->insurance_expiry_date = $request->insurance_expiry_date_edit;
//                $data->user_id = Auth::user()->id;
                $data->status = $request->status;
                $data->save();

                if ($request->file('photos_edit')) {

                    $pic = $request->file('photos_edit');
                    $name = time() . rand(1, 100) . '.' . $pic->extension();
                    $pic->move('images/cars/', $name);
                    $photos = $data->photo;
                    if ($photos) {
                        $photos->delete();
                    }
                    $image = new Photos();
                    $image->images = $name;
                    $image->car_id = $data->id;
                    $image->save();
                    $data1 = Car::find($id);
                    unlink('images/cars/' . $data1->carphotos);
                    $data1->carphotos = $name;
                    $data1->save();
                }

                if ($request->file('photos_carlicense_edit')) {
                    $pic = $request->file('photos_carlicense_edit');
                    $name = time() . rand(1, 100) . '.' . $pic->extension();
                    $pic->move('images/cars/', $name);
                    $data2 = Car::find($id);
                    unlink('images/cars/' . $data2->carlicense);
                    $data2->carlicense = $name;
                    $data2->save();
                }

                if ($request->file('photos_carinsurance_edit')) {
                    $pic = $request->file('photos_carinsurance_edit');
                    $name = time() . rand(1, 100) . '.' . $pic->extension();
                    $pic->move('images/cars/', $name);
                    $data3 = Car::find($id);
                    unlink('images/cars/' . $data3->carinsurance);
                    $data3->carinsurance = $name;
                    $data3->save();
                }

                if ($request->file('photos_passengersinsurance_edit')) {
                    $pic = $request->file('photos_passengersinsurance_edit');
                    $name = time() . rand(1, 100) . '.' . $pic->extension();
                    $pic->move('images/cars/', $name);
                    $data4 = Car::find($id);
                    unlink('images/cars/' . $data4->passengersinsurance);
                    $data4->passengersinsurance = $name;
                    $data4->save();
                }


                return response()->json(['success' => $data]);
            }
            return response()->json(['error' => $validator->errors()->toArray()]);
        }
    }

    public function destroy($id)
    {
        $carId = Car::find($id);
        $driver = Driver::find($carId->user_id);
        if ($driver->transportations->count() > 0) {
            return response()->json(['error' => 'Cannot delete car, it has orders']);
        } else {
            $carId->delete();
            return response()->json(['success' => 'delete car success']);
        }
    }

    public function getUnRegisterUsersCard(Request $request)
    {
        $drivers = Driver::doesntHave('car')->where('user_type', 2)->get();
        return response()->json($drivers);

    }
}
