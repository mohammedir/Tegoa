<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Photos;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CarController extends Controller
{

    public function index(Request $request)
    {
        $cars = Car::query()->get();
        if ($request->ajax()) {
            $data = Car::query()->where('is_email_verified',"=",1)->get();
            return Datatables::of($data)->addIndexColumn()
                ->editColumn('Name', function ($data) {
                    return '<a href="'.route("drivers.index").'">'.User::find($data->user_id)->full_name.'</a>';
                })
                ->editColumn('car_number', function ($data) {
                    return Str::limit($data->car_number,20) ;;
                })
                ->editColumn('car_brand', function ($data) {
                    return Str::limit($data->car_brand,20) ;;
                })
                ->editColumn('insurance_number', function ($data) {
                    return Str::limit($data->insurance_number,20) ;;
                })
                ->editColumn('status', function ($data) {
                    if ($data->status == 0){
                        $status = '<div style="color: #ffc700">'. trans('web.review').'</div>';
                    }elseif ($data->status == 1){
                        $status = '<div>'. trans('web.accepted').'</div>';
                    }else{
                        $status = '<div style="color: red">'. trans('web.declined').'</div>';
                    }
                    return $status;
                })
                ->addColumn('others', function ($data) {
                    if ($data->status == 0 || $data->status == 2){
                        $other = '<button id="show" data-id="' . $data->id . '" data-bs-toggle="modal" data-bs-target="#kt_modal_detail_car"  class="btn btn-warning btn-block" style="color:black;font-weight: bold; width: 90px !important;">
                                    '. trans('web.Details').'</button>';
                    }else{
                        $other = '<button id="edit" data-id="' . $data->id . '"  data-bs-toggle="modal" data-bs-target="#kt_modal_update_car" class="btn btn-warning btn-block" style="color:black;font-weight: bold; width: 90px !important;">
                                    '. trans('web.Edit').'</button>';
                    }

                    return $other;

                })
                ->rawColumns(['others'])
                ->escapeColumns([])
                ->make(true);
        }
        return view('cars.index',compact('cars'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Request $request,$id)
    {
        if ($request->ajax()) {
            $images = [];
            $car = Car::find($id);
            $user = User::find($car->user_id)->full_name;
            $image = Photos::where('car_id',$car->id)->get();
            foreach ($image as $value){
                $images[] = $value->images;
            }
            $type = "";
            if($car->type == 1){
                $type = trans('web.public');
            }else{
                $type =trans('web.private');
            }



            return response()->json(['type'=>$type,'car' => $car,'user' => $user,'image' => $images]);
        }
    }

    public function accept(Request $request)
    {
        if ($request->ajax()) {
            $car =  Car::find($request->id);
            $car->status = 1;
            $car->save();
            if ($car){
                $details = [
                    'title' => 'Mail from Teqoa',
                    'body' => 'This email to inform you that the registered vehicle is enabled successfully'
                ];
                $user = User::find($car->user_id)->email;
                Mail::to($user)->send(new \App\Mail\StatusCar($details));
            }

            return response()->json(['response' => $car]);
        }
    }

    public function deleteImage(Request $request)
    {
        if ($request->ajax()) {
            $images = [];
            $image = Photos::where('images',$request->id)->delete();
            $imagess = Photos::where('car_id',$request->car_id)->get();
            if ($imagess->isEmpty()){
                return response()->json(['res' => "nothing"]);
            }else{
                foreach ($imagess as $value){
                    $images[] = $value->images;
                }
                return response()->json(['image' => $images]);
            }
        }
    }

    public function decline(Request $request)
    {
        if ($request->ajax()) {
            $car =  Car::find($request->id);
            $car->status = 2;
            $car->save();
            return response()->json(['response' => $car]);
        }
    }

    public function edit(Request $request,$id)
    {
        if ($request->ajax()) {
            $images = [];
            $car = Car::find($id);
            $user = User::find($car->user_id)->full_name;
            $image = Photos::where('car_id',$car->id)->get();
            foreach ($image as $value){
                $images[] = $value->images;
            }
            return response()->json(['car' => $car,'user' => $car,'image' => $images]);
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'type_edit' => 'required|numeric',
                'number_edit' => 'required|numeric',
                'brand_edit' => 'required|string|max:255',
                'insurance_number_edit' => 'required|string|max:255',
                'insurance_expiry_date_edit' => 'required|date',
                'photos_edit.*' => 'sometimes|mimes:jpeg,png,jpg'
            ], [
                'type_edit.required' => trans("web.required"),
                'type_edit.numeric' => trans("web.numeric"),

                'number_edit.required' => trans("web.required"),
                'number_edit.numeric' => trans("web.numeric"),

                'brand_edit.required' => trans("web.required"),
                'brand_edit.string' => trans("web.string"),
                'brand_edit.max' => trans("web.max"),

                'insurance_number_edit.required' => trans("web.required"),
                'insurance_number_edit.string' => trans("web.string"),
                'insurance_number_edit.max' => trans("web.max"),

                'insurance_expiry_date_edit.required' => trans("web.required"),
                'insurance_expiry_date_edit.date' => trans("web.date"),

                'photos_edit.uploaded' => trans("web.uploaded"),

            ]);
            if ($validator->passes()) {
                $data = Car::find($id);
                $data->type = $request->type_edit;
                $data->car_number = $request->number_edit;
                $data->car_brand = $request->brand_edit;
                $data->insurance_number = $request->insurance_number_edit;
                $data->insurance_expiry_date = $request->insurance_expiry_date_edit;
                $data->user_id = Auth::user()->id;
//                $data->status = 0;
                $data->save();

                if ($request->file('photos_edit')) {
                    foreach ($request->file('photos_edit') as $value){
                        $name = time().rand(1,100).'.'.$value->extension();
                        $value->move('images/cars/', $name);
                        $image = new Photos();
                        $image->images = $name;
                        $image->car_id = $data->id;
                        $image->save();
                    }
                }

                return response()->json(['success' => $data]);
            }
            return response()->json(['error' => $validator->errors()->toArray()]);
        }
    }

    public function destroy($id)
    {
        //
    }
}
