<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Photos;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                       $status = '<div style="color: #ffc700">in review</div>';
                   }elseif ($data->status == 1){
                       $status = '<div>accepted</div>';
                   }else{
                       $status = '<div style="color: red">declined</div>';
                   }
                   return $status;
                })
                ->addColumn('others', function ($data) {
                    if ($data->status == 0 || $data->status == 2){
                        $other = '<button id="show" data-id="' . $data->id . '" data-bs-toggle="modal" data-bs-target="#kt_modal_detail_car"  class="btn btn-warning" style="color:black;font-weight: bold;">
                                    Details</button>';
                    }else{
                        $other = '<button id="edit" data-id="' . $data->id . '"  data-bs-toggle="modal" data-bs-target="#kt_modal_update_car" class="btn btn-warning" style="color:black;font-weight: bold;">
                                    Edit</button>';
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
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'type' => 'required|string|max:255',
                'number' => 'required|numeric',
                'brand' => 'required|string|max:255',
                'license' => 'required|string|max:255',
                'insurance_number' => 'required|string|max:255',
                'insurance_expiry_date' => 'required|date',
                'passengers_insurance' => 'required|string|max:255',
                'photos.*' => 'required|mimes:jpeg,png,jpg|max:1024'
            ], [

            ]);
            if ($validator->passes()) {
                $data = new Car();
                $data->type = $request->type;
                $data->car_number = $request->number;
                $data->car_brand = $request->brand;
                $data->license = $request->license;
                $data->insurance_number = $request->insurance_number;
                $data->insurance_expiry_date = $request->insurance_expiry_date;
                $data->user_id = Auth::user()->id;
                $data->status = 0;
                $data->save();

                if ($request->file()) {
                    foreach ($request->file() as $value){
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
        dd($request->file('file'));
    }

    public function destroy($id)
    {
        //
    }
}
