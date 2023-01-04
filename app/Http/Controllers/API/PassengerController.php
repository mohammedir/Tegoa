<?php

namespace App\Http\Controllers\API;

use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Mail\changePassword;
use App\Mail\updatePassword;
use App\Mail\updateProfile;
use App\Models\API\Settings;
use App\Models\API\TransportationRequests;
use App\Models\API\User;
use App\Services\FCMService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use MongoDB\Driver\Session;

class PassengerController extends Controller
{

    //2

   /* public function index(Request $request){
        return $request->user();
    }
    public function register(Request $request){

        $validator = Validator::make($request->all(),[
            'full_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);
        if ($validator->passes()) {
            $user = new User();
            $user->full_name = $request->full_name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->user_type = 1;
            $user->save();

            return $user;
        }else{
            return response()->json(['error'=>$validator->errors()->all()],409);

        }
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (Auth::attempt($credentials)){
            $user = Auth::user();
            $token = md5(time().'.'.md5($request->email));
            $user->forceFill([
                'api_token' => $token,
            ])->save();
            return response()->json([
                'token' => $token
            ]);
        }
        return response()->json([
            'message' => 'The provided  credentials do not match our records'
        ]);

    }

    public function logout(Request $request){
        return $request;
        return response()->json(['message'=>'success']);
    }*/

    public function edit_profile(Request $request){

        return  $this->api_response(200,true,trans('api.user info ') , $request->user() , 200);

    }
    public function update_profile(Request $request){
        $validator = Validator::make($request->all(),[
            'full_name' => 'required',
            'email' => 'required',
            'mobile_number' => 'required',
            'address' => 'required',

        ]);
        if ($validator->passes()) {
            $passenger = User::query()->find($request->user()->id);
            $passenger->full_name = $request->full_name;
            $passenger->email = $request->email;
            $passenger->mobile_number = $request->mobile_number;
            $passenger->address = $request->address;
            $passenger->save();
            Mail::to($request->email)->send(new updateProfile($passenger));

            return  $this->api_response(200,true,trans('api.user info ') , $passenger , 200);


        }else{
            return  $this->setError(500,false, $validator->errors()->first() , 500);

        }
        }

    public function change_password(Request $request){
        $validator = Validator::make($request->all(),[
            'current_password' => 'required',
            'new_password' => 'required||min:8|confirmed',

        ]);
        if ($validator->passes()) {
            $passenger = User::query()->find($request->user()->id);
            if (Hash::check($request->current_password,$passenger->password) ){
                $passenger->password = Hash::make($request->new_password);
                $passenger->save();
                Mail::to($passenger->email)->send(new updatePassword($passenger));
                return  $this->api_response(200,true,trans('api.changed password successfully ') , $request->user() , 200);
            }else{
                return  $this->setError(500,false, trans('api.the current password is not true') , 500);
            }
        }else{
            return  $this->setError(500,false, $validator->errors()->first() , 500);

        }
    }

    public function reset_password_with_email(Request $request){
        try {
            $passenger = User::query()->find($request->user()->id);
            Mail::to($passenger->email)->send(new changePassword($passenger));
            return  $this->api_response(200,true,trans('api.Reset link has  been send to your email, please check it ') , "" , 200);
        } catch (\Exception $e) {
            return  $this->setError(500,false, "api.Something went wrong, please try again later!" , 500);
        }
    }
    public function reset_password_view(Request $request , $id){
        $passenger = User::query()->where('api_token','=',$id)->get()->first();
        return view('reset_password_view',compact('passenger'));

    }

    public function update_password_with_email(Request $request){
        $validator = Validator::make($request->all(),[
            'password' => 'required|min:8|confirmed',

        ]);
        if ($validator->passes()){
            $passenger = User::query()->find($request->user_id);
            $passenger->password = Hash::make($request->password);
            $passenger->save();
            \Illuminate\Support\Facades\Session::flash('message', 'This is a message!');

        }else{
            \Illuminate\Support\Facades\Session::flash('message', $validator->errors()->first());

        }
    }

    public function find_transportion(Request $request){
        $validator = Validator::make($request->all(),[
            'passenger_id' => 'required',
            'lat_from' => 'required',
            'lng_from' => 'required',
            'lat_to' => 'required',
            'lng_to' => 'required',
            'departure_time' => 'required',
            'number_of_passenger' => 'required',
            'vehicle_type' => 'required',
            'distance' => 'required',
            'expected_cost' => 'required',
            'arrival_time' => 'required',

        ]);
        $passenger_id = User::query()->where('user_type','=',1)->where('id','=',$request->passenger_id)->get()->first();
        if ($validator->passes()){
            if ($passenger_id){
            $transportation_requests = new TransportationRequests();
            $transportation_requests->passenger_id = $request->passenger_id;
            $transportation_requests->lat_from = $request->lat_from;
            $transportation_requests->lng_from = $request->lng_from;
            $transportation_requests->lat_to = $request->lat_to;
            $transportation_requests->lng_to = $request->lng_to;
            $transportation_requests->departure_time = $request->departure_time;
            $transportation_requests->number_of_passenger = $request->number_of_passenger;
            $transportation_requests->vehicle_type = $request->vehicle_type;
            $transportation_requests->distance = $request->distance;
            $transportation_requests->expected_cost = $request->expected_cost;
            $transportation_requests->arrival_time = $request->arrival_time;
            $transportation_requests->save();


                $user = User::query()->find(1);
                FCMService::send(
                    $user->fcm_token,
                    [
                        'title' => 'your title',
                        'body' => 'your body',

                    ]
                );


            return  $this->api_response(200,true,trans('api.find_transportion') , $transportation_requests, 200);
            }else{
               return  $this->setError(500,false, "api.Passenger id not correct" , 500);

            }
        }



    }

    public function settings(){
        $settings = Settings::query()->get();
        return  $this->api_response(200,true,trans('api.Settings ') , $settings , 200);

    }
}
