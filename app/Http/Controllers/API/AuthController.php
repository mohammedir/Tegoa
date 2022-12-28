<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\API\car;
use App\Models\API\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //

    public function index(Request $request){
        return  $this->api_response(200,true,trans('api.user info ') , $request->user() , 200);

    }
    public function passenger_register(Request $request){

        $validator = Validator::make($request->all(),[
            'full_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'mobile_number' => 'required|unique:users|min:8',
            'address' => 'required',
            'gender' => 'required',
        ]);
        if ($validator->passes()) {
            $user = new User();
            $user->full_name = $request->full_name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->mobile_number = $request->mobile_number;
            $user->address = $request->address;
            $user->gender = $request->gender;
            $user->user_status = 1;
            $user->user_type = 1;
            $user->save();
                $token = $user->createToken('passenger');
            $user->update(['api_token' =>$token->plainTextToken]);

            return  $this->api_response(200,true,trans('api.register passenger done') , $user , 200);

        }else{
            return  $this->setError(400 ,false, $validator->errors()->first() , 400);

/*            return response()->json(['error'=>$validator->errors()->first()],409);*/

        }
    }
    public function driver_register(Request $request){

        $validator = Validator::make($request->all(),[
            'full_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'mobile_number' => 'required|unique:users',
            'gender' => 'required',
            'vehicle_type' => 'required',
            'personalphoto' => 'required',
            'driverlicense' => 'required',
            'address' => 'required',
            'car_number' => 'required',
            'insurance_number' => 'required',
            'insurance_expiry_date' => 'required',
            'carphotos' => 'required',
            'carlicense' => 'required',
            'carinsurance' => 'required',
            'passengersinsurance' => 'required',
        ]);
        if ($validator->passes()) {
            $user = new User();
            $user->full_name = $request->full_name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->gender = $request->gender;
            $user->vehicle_type = $request->vehicle_type;
            if ($request->hasFile('personalphoto')){
                $compFileName =  $request->file('personalphoto')->getClientOriginalName();
                $fileNameOnly = pathinfo($compFileName, PATHINFO_FILENAME);
                $extenshion = $request->file('personalphoto')->getClientOriginalExtension();
                $comPic = str_replace(' ','_',$fileNameOnly).'-'.rand().'_'.time().'.'.$extenshion;
                $path = $request->file('personalphoto')->move(public_path('personalphoto'),$comPic);
                $user->personalphoto = $comPic;
            }
            if ($request->hasFile('driverlicense')) {
                $compFileName =  $request->file('driverlicense')->getClientOriginalName();
                $fileNameOnly = pathinfo($compFileName, PATHINFO_FILENAME);
                $extenshion = $request->file('driverlicense')->getClientOriginalExtension();
                $comPic = str_replace(' ','_',$fileNameOnly).'-'.rand().'_'.time().'.'.$extenshion;
                $path = $request->file('driverlicense')->move(public_path('driverlicense'),$comPic);
                $user->driverlicense = $comPic;
            }
            $user->address = $request->address;
            $user->user_type = 2;
            $user->save();
            $car = new Car();
            $car->user_id = $user->id;
            $car->car_number = $request->car_number;
            $car->car_brand = $request->car_brand;
            $car->insurance_number = $request->insurance_number;
            $car->insurance_expiry_date = $request->insurance_expiry_date;
            $car->type = $request->vehicle_type;
            if ($request->hasFile('carphotos')) {
                $compFileName =  $request->file('carphotos')->getClientOriginalName();
                $fileNameOnly = pathinfo($compFileName, PATHINFO_FILENAME);
                $extenshion = $request->file('carphotos')->getClientOriginalExtension();
                $comPic = str_replace(' ','_',$fileNameOnly).'-'.rand().'_'.time().'.'.$extenshion;
                $path = $request->file('carphotos')->move(public_path('carphotos'),$comPic);
                $car->carphotos = $comPic;
            }
            if ($request->hasFile('carlicense')) {
                $compFileName =  $request->file('carlicense')->getClientOriginalName();
                $fileNameOnly = pathinfo($compFileName, PATHINFO_FILENAME);
                $extenshion = $request->file('carlicense')->getClientOriginalExtension();
                $comPic = str_replace(' ','_',$fileNameOnly).'-'.rand().'_'.time().'.'.$extenshion;
                $path = $request->file('carlicense')->move(public_path('carlicense'),$comPic);
                $car->carlicense = $comPic;
            }
            if ($request->hasFile('carinsurance')) {
                $compFileName =  $request->file('carinsurance')->getClientOriginalName();
                $fileNameOnly = pathinfo($compFileName, PATHINFO_FILENAME);
                $extenshion = $request->file('carinsurance')->getClientOriginalExtension();
                $comPic = str_replace(' ','_',$fileNameOnly).'-'.rand().'_'.time().'.'.$extenshion;
                $path = $request->file('carinsurance')->move(public_path('carinsurance'),$comPic);
                $car->carinsurance = $comPic;
            }
            if ($request->hasFile('passengersinsurance')) {
                $compFileName =  $request->file('passengersinsurance')->getClientOriginalName();
                $fileNameOnly = pathinfo($compFileName, PATHINFO_FILENAME);
                $extenshion = $request->file('passengersinsurance')->getClientOriginalExtension();
                $comPic = str_replace(' ','_',$fileNameOnly).'-'.rand().'_'.time().'.'.$extenshion;
                $path = $request->file('passengersinsurance')->move(public_path('passengersinsurance'),$comPic);
                $car->passengersinsurance = $comPic;
            }
            $car->save();
                $token = $user->createToken('driver');
            $user->update(['api_token' =>$token->plainTextToken]);
            $res = [
                'user' => $user,
                'car' => $car
            ];
            return  $this->api_response(200,true,trans('api.account has been created but car is under review, we will inform you when it get reviewed') , $res , 200);

        }else{
            return  $this->setError(400 ,false, $validator->errors()->first() , 400);

            /*            return response()->json(['error'=>$validator->errors()->first()],409);*/

        }
    }

    public function login(Request $request){
      $input = $request->all();
      $validation = Validator::make($input,[
          'email' => 'required',
          'password' => 'required',
      ]);

      if ($validation->fails()){
          return response()->json(['error' => $validation->errors()]);
      }
      if (Auth::attempt(['email' => $input['email'],'password' => $input['password']])){
          $data = Auth::user();
          if ($request->user_type == 1){
            $token = $data->createToken('passenger');
          }elseif ($request->user_type == 2){
              $token = $data->createToken('driver');
          }
          $data->api_token = $token->plainTextToken;
          $data->save();

          return  $this->api_response(200 ,true,trans('api.login done') , $data , 200);
      }
    }

    public function logout(Request $request){

        $request->user()->currentAccessToken()->delete();
        return response()->json(['success' => 'logout']);
    }
}
