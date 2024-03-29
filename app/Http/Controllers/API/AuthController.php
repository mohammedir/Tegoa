<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\API\Car;
use App\Models\API\Photos;
use App\Models\API\User;
use App\Models\API\UserApi;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;

class AuthController extends Controller
{
    //

    public function index(Request $request){
        return  $this->api_response(200,true,trans('api.user info ') , $request->user() , 200);

    }
    public function passenger_register(Request $request){
        $headerFCM = $request->header('fcmToken');
        $validator = Validator::make($request->all(),[
            'full_name' => 'required',
            'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|string|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'mobile_number' => 'required|unique:users',
            'address' => 'required',
            'gender' => 'required',
        ], [
            'full_name.required' => trans("api.full name field is required"),
            'email.required' => trans("api.email field is required"),
            'email.email' => trans("api.The email must be a valid email address"),
            'email.unique' => trans("api.The email has already been taken"),
            'password.required' => trans("api.password field is required"),
            'password.confirmed' => trans("api.The password confirmation does not match"),
            'password.min' => trans("api.The password must be at least 8 characters"),
            'mobile_number.required' => trans("api.mobile_number field is required"),
            'mobile_number.unique' => trans("api.The mobile number has already been taken"),
            'address.required' => trans("api.address field is required"),
            'gender.required' => trans("api.gender field is required"),
        ]);
        if ($validator->passes()) {
            try {
                $user = new User();
                $user->full_name = $request->full_name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->mobile_number = $request->mobile_number;
                $user->address = $request->address;
                $user->gender = $request->gender;
                $user->user_status = 1;
                $user->user_type = 1;
                if ($request->fcmToken){
                    $user->fcm_token = $request->fcmToken;
                }elseif ($headerFCM){
                    $user->fcm_token = $headerFCM;
                }
                $user->save();
                $token = $user->createToken('passenger');
                $user->update(['api_token' =>$token->plainTextToken]);
                $user->sendEmailVerificationNotification();
                $res = [
                    'user' => $user,
                ];
                return  $this->api_response(200,true,trans('api.register passenger done') , $res , 200);
            }catch (Exception $e){
                $user->findOrFail($user->id)->delete();
                return  $this->setError(200 ,false, trans('api.An error occurred during the sending process, please try again') , 200);
            }
        }else{
            return  $this->setError(200 ,false, $validator->errors()->first() , 200);
        }
    }
    public function driver_register(Request $request){
        $headerFCM = $request->header('fcmToken');
        $validator = Validator::make($request->all(),[
            'full_name' => 'required',
            'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|string|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'mobile_number' => 'required|unique:users',
            'gender' => 'required',
            'vehicle_type' => 'required',
            'personalphoto' => 'required',
            'driverlicense' => 'required',
            'address' => 'required',
            'car_number' => 'required|unique:cars',
            'car_brand' => 'required',
            'insurance_number' => 'required',
            'insurance_expiry_date' => 'required|date',
            'carphotos' => 'required',
            'carlicense' => 'required',
            'carinsurance' => 'required',
            'passengersinsurance' => 'required',
        ], [
            'full_name.required' => trans("api.full name field is required"),
            'email.required' => trans("api.email field is required"),
            'email.email' => trans("api.The email must be a valid email address"),
            'email.unique' => trans("api.The email has already been taken"),
            'password.required' => trans("api.password field is required"),
            'password.confirmed' => trans("api.The password confirmation does not match"),
            'password.min' => trans("api.The password must be at least 8 characters"),
            'mobile_number.required' => trans("api.mobile_number field is required"),
            'mobile_number.unique' => trans("api.The mobile number has already been taken"),
            'address.required' => trans("api.address field is required"),
            'gender.required' => trans("api.gender field is required"),
            'vehicle_type.required' => trans("api.The vehicle type field is required."),
            'personalphoto.required' => trans("api.personalphoto field is required"),
            'car_number.required' => trans("api.The car number field is required"),
            'car_number.unique' => trans("api.The car number has already been taken"),
            'car_brand.required' => trans("api.The car brand field is required"),
            'insurance_number.required' => trans("api.The insurance number field is required"),
            'insurance_expiry_date.date' => trans("api.The insurance expiry date is not a valid date"),
            'driverlicense.required' => trans("api.driverlicense field is required"),
            'carphotos.required' => trans("api.carphotos field is required"),
            'carlicense.required' => trans("api.The carlicense field is required"),
            'carinsurance.required' => trans("api.The carinsurance field is required"),
            'passengersinsurance.required' => trans("api.passengersinsurance field is required"),
        ]);
        if ($validator->passes()) {
            try {
                $user = new UserApi();
                $user->full_name = $request->full_name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->mobile_number = $request->mobile_number;
                $user->gender = $request->gender;
                $user->vehicle_type = $request->vehicle_type;
                if ($request->hasFile('personalphoto')){
                    $compFileName =  $request->file('personalphoto')->getClientOriginalName();
                    $fileNameOnly = pathinfo($compFileName, PATHINFO_FILENAME);
                    $extenshion = $request->file('personalphoto')->getClientOriginalExtension();
                    $comPic = str_replace(' ','_',$fileNameOnly).'-'.rand().'_'.time().'.'.$extenshion;
                    $path = $request->file('personalphoto')->move('images/users',$comPic);
                    $user->personalphoto = $comPic;
                }
                if ($request->hasFile('driverlicense')) {
                    $compFileName =  $request->file('driverlicense')->getClientOriginalName();
                    $fileNameOnly = pathinfo($compFileName, PATHINFO_FILENAME);
                    $extenshion = $request->file('driverlicense')->getClientOriginalExtension();
                    $comPic = str_replace(' ','_',$fileNameOnly).'-'.rand().'_'.time().'.'.$extenshion;
                    $path = $request->file('driverlicense')->move('images/users',$comPic);
                    $user->driverlicense = $comPic;
                }
                $user->address = $request->address;
                $user->user_type = 2;
                if ($request->fcmToken){
                    $user->fcm_token = $request->fcmToken;
                }elseif ($headerFCM){
                    $user->fcm_token = $headerFCM;
                }
                $user->save();
                $car = new Car();
                $car->user_id = $user->id;
                $car->car_number = $request->car_number;
                $car->car_brand = $request->car_brand;
                $car->insurance_number = $request->insurance_number;
                $car->insurance_expiry_date = $request->insurance_expiry_date;
                $car->type = $request->vehicle_type;
                if ($request->hasFile('carlicense')) {
                    $compFileName =  $request->file('carlicense')->getClientOriginalName();
                    $fileNameOnly = pathinfo($compFileName, PATHINFO_FILENAME);
                    $extenshion = $request->file('carlicense')->getClientOriginalExtension();
                    $comPic = str_replace(' ','_',$fileNameOnly).'-'.rand().'_'.time().'.'.$extenshion;
                    $path = $request->file('carlicense')->move('images/cars',$comPic);
                    $car->carlicense = $comPic;
                }
                if ($request->hasFile('carinsurance')) {
                    $compFileName =  $request->file('carinsurance')->getClientOriginalName();
                    $fileNameOnly = pathinfo($compFileName, PATHINFO_FILENAME);
                    $extenshion = $request->file('carinsurance')->getClientOriginalExtension();
                    $comPic = str_replace(' ','_',$fileNameOnly).'-'.rand().'_'.time().'.'.$extenshion;
                    $path = $request->file('carinsurance')->move('images/cars',$comPic);
                    $car->carinsurance = $comPic;
                }
                if ($request->hasFile('passengersinsurance')) {
                    $compFileName =  $request->file('passengersinsurance')->getClientOriginalName();
                    $fileNameOnly = pathinfo($compFileName, PATHINFO_FILENAME);
                    $extenshion = $request->file('passengersinsurance')->getClientOriginalExtension();
                    $comPic = str_replace(' ','_',$fileNameOnly).'-'.rand().'_'.time().'.'.$extenshion;
                    $path = $request->file('passengersinsurance')->move('images/cars',$comPic);
                    $car->passengersinsurance = $comPic;
                }
                if ($request->hasFile('carphotos')) {
                    $photos = new Photos();
                    $compFileName =  $request->file('carphotos')->getClientOriginalName();
                    $fileNameOnly = pathinfo($compFileName, PATHINFO_FILENAME);
                    $extenshion = $request->file('carphotos')->getClientOriginalExtension();
                    $comPic = str_replace(' ','_',$fileNameOnly).'-'.rand().'_'.time().'.'.$extenshion;
                    $path = $request->file('carphotos')->move('images/cars',$comPic);
                    $car->carphotos = $comPic;
                    $car->save();
                    Photos::create([
                        'images' => $comPic,
                        'car_id' => $car->id,
                    ]);
                }

                $token = $user->createToken('driver');
                $user->update(['api_token' =>$token->plainTextToken]);
                $res = [
                    'user' => $user,
                    'car' => $car
                ];
                $user->sendEmailVerificationNotification();
                return  $this->api_response(200,true,trans('api.account has been created but car is under review, we will inform you when it get reviewed') , $res , 200);

            }catch (Exception $e){
                $user->findOrFail($user->id)->delete();
                return  $this->setError(200 ,false, trans('api.An error occurred during the sending process, please try again') , 200);
            }

        }else{
            return  $this->setError(200 ,false, $validator->errors()->first() , 200);

        }
    }

    public function passenger_login(Request $request){
        $headerFCM = $request->header('fcmToken');
        $input = $request->all();
        $validation = Validator::make($input,[
            'email' => 'required',
            'password' => 'required',
        ],[
            'email.required' => trans("api.email field is required"),
            'password.required' => trans("api.password field is required"),
        ]);

        if ($validation->fails()){
            return  $this->setError(400 ,false, $validation->errors()->first(), 400);
        }
        if (Auth::attempt(['email' => $input['email'],'password' => $input['password'] , 'user_type' => 1]) || Auth::attempt(['mobile_number' => $input['email'],'password' => $input['password'] , 'user_type' => 1])){
            $data = Auth::user();
            if ($data->user_status == 1) {
                $token = $data->createToken('passenger');
                $data->api_token = $token->plainTextToken;
                if ($request->fcmToken) {
                    $data->fcm_token = $request->fcmToken;
                } elseif ($headerFCM) {
                    $data->fcm_token = $headerFCM;
                }
                $data->save();
                $res = [
                    'user' => $data,
                ];
                return $this->api_response(200, true, trans('api.login done'), $res, 200);
            }else {
                return  $this->setError(200 ,false, trans('api.Your account has been suspended by admin') , 200);
            }
        }else{
            return  $this->setError(400 ,false, trans('api.failed') , 400);
        }
    }
    public function driver_login(Request $request){
        $headerFCM = $request->header('fcmToken');
        $input = $request->all();
        $validation = Validator::make($input,[
            'email' => 'required',
            'password' => 'required',

        ],[
            'email.required' => trans("api.email field is required"),
            'password.required' => trans("api.password field is required"),
        ]);

        if ($validation->fails()){
            return  $this->setError(400 ,false, $validation->errors()->first(), 400);
        }
        if (Auth::attempt(['email' => $input['email'],'password' => $input['password'] , 'user_type' => 2]) || Auth::attempt(['mobile_number' => $input['email'],'password' => $input['password'] , 'user_type' => 2])){
            $data = Auth::user();
            if ($data->user_status == 1 ){
                $car = Car::query()->where('user_id','=',$data->id)->get()->first();
                $token = $data->createToken('driver');
                $data->api_token = $token->plainTextToken;
                if ($request->fcmToken){
                    $data->fcm_token = $request->fcmToken;
                }elseif ($headerFCM){
                    $data->fcm_token = $headerFCM;
                }
                $data->save();
                $res = [
                    'user' => $data,
                    'car' => $car

                ];
                return  $this->api_response(200 ,true,trans('api.login done') , $res , 200);
            }else{
                return  $this->setError(200 ,false, trans('api.Your account has been suspended by admin') , 200);
            }
        }else{
            return  $this->setError(200 ,false, trans('api.failed') , 200);

        }
    }


    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        $user = User::query()->find($request->user()->id);
        $user->api_token = '';
        $user->fcm_token = '';
        $user->save();
        return  $this->api_response(200 ,true,trans('api.Success logout') , "" , 200);

    }
}
