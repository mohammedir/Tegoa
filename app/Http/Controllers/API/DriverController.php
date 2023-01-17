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
use Exception;

class DriverController extends Controller
{


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

    public function accept_transportion(Request $request){
        $validator = Validator::make($request->all(),[
            'transportation_id' => 'required',

        ]);
        /*1*/
        $driver = User::query()->where('user_type','=',2)->where('id','=',$request->user()->id)->get()->first();
        $transportation = TransportationRequests::query()->find($request->transportation_id);
        if ($validator->passes()){
            if ($driver || $transportation){
                if ($transportation->status == 1){
                  $transportation->driver_id = $request->user()->id;
                  $transportation->status = 2;
                  $transportation->save();
                  return  $this->api_response(200,true,trans('The request has been successfully accepted') , $transportation, 200);
                }else if ($transportation->status == 2 &&$transportation->driver_id == $request->user()->id){
                    return  $this->api_response(200,true,trans('The request has been successfully accepted') , $transportation, 200);
                }else{
                    return  $this->setError(400 ,false, trans('api.The order was taken by another driver') , 400);
                }


            }else{
                return  $this->setError(400 ,false, trans('api.driver or transportation not found') , 400);

            }
        }



    }

    public function start_trip(Request $request){
        $validator = Validator::make($request->all(),[
            'transportation_id' => 'required',
        ]);
        /*1*/
        $driver = User::query()->where('user_type','=',2)->where('id','=',$request->user()->id)->get()->first();
        $transportation = TransportationRequests::query()->find($request->transportation_id);
        if ($validator->passes()){
            if ($driver || $transportation){
                if ($transportation->status == 2){
                    $transportation->start_trip = now();
                    $transportation->status = 3;
                    $transportation->save();
                    return  $this->api_response(200,true,trans('The request has been successfully accepted') , "" , 200);
                }else{
                    return  $this->setError(400 ,false, trans('api.The order was taken by another driver') , 400);
                }


            }else{
                return  $this->setError(400 ,false, trans('api.driver or transportation not found') , 400);

            }
        }

    }
    public function end_trip(Request $request){
        $validator = Validator::make($request->all(),[
            'transportation_id' => 'required',
            'time_end_trip' => 'required',
        ]);
        /*1*/
        $driver = User::query()->where('user_type','=',2)->where('id','=',$request->user()->id)->get()->first();
        $transportation = TransportationRequests::query()->find($request->transportation_id);
        if ($validator->passes()){
            if ($driver || $transportation){
                if ($transportation->status == 3){
                    $transportation->end_trip = now();
                    $transportation->status = 4;
                    $transportation->save();
                    return  $this->api_response(200,true,trans('The request has been successfully accepted') , "" , 200);
                }else{
                    return  $this->setError(400 ,false, trans('api.The order was taken by another driver') , 400);
                }


            }else{
                return  $this->setError(400 ,false, trans('api.driver or transportation not found') , 400);

            }
        }

    }


    public function rating(Request $request){
        $validator = Validator::make($request->all(),[
            'transportation_id' => 'required',
            'passenger_rating' => 'required',
        ]);
        if ($validator->passes()) {
            $transportation = TransportationRequests::query()->find($request->transportion_id);
            $transportation->passenger_rating = $request->rating_passenger;
            $transportation->save();
        }
        return  $this->api_response(200,true,trans('api.Rating successfully ') , "" , 200);

    }
    public function report_passenger(Request $request){
        $validator = Validator::make($request->all(),[
            'transportation_id' => 'required',
            'text_report' => 'required',
        ]);
        if ($validator->passes()) {
            $transportation = TransportationRequests::query()->find($request->transportion_id);
            $transportation->complaint = $request->text_report;
            $transportation->save();
        }
    }
    public function settings(){
        $settings = Settings::query()->get();
        return  $this->api_response(200,true,trans('api.Settings ') , $settings , 200);

    }
}
