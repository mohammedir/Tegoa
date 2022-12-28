<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Photos;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CarController extends Controller
{

    public function index(Request $request)
    {
        $cars = Car::query()->get();
        if ($request->ajax()) {
            $data = Car::query()->take(10)->get();
            return Datatables::of($data)->addIndexColumn()
                ->editColumn('Name', function ($data) {
                    return User::find($data->user_id)->full_name;
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
                        $other = '<button id="show" data-id="' . $data->id . '" data-bs-toggle="modal" data-bs-target="#kt_modal_detail_car"  class="btn btn-warning" style="color:black;font-weight: bold;">
                                    '. trans('web.Details').'</button>';
                    }else{
                        $other = '<button id="edit" data-id="' . $data->id . '"  data-bs-toggle="modal" data-bs-target="#kt_modal_update_car" class="btn btn-warning" style="color:black;font-weight: bold;">
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
            return response()->json(['car' => $car,'user' => $user,'image' => $images]);
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
//            dd($request->all());
            $validator = Validator::make($request->all(), [
                'type_edit' => 'required|string|max:255',
                'number_edit' => 'required|numeric',
                'brand_edit' => 'required|string|max:255',
                'insurance_number_edit' => 'required|string|max:255',
                'insurance_expiry_date_edit' => 'required|date',
                'photos_edit.*' => 'sometimes|mimes:jpeg,png,jpg'
            ], [

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
                        $value->move(public_path('/images/cars/'), $name);
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
