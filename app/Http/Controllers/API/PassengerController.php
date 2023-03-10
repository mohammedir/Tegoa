<?php

namespace App\Http\Controllers\API;

use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Mail\changePassword;
use App\Mail\updatePassword;
use App\Mail\updateProfile;
use App\Models\API\Car;
use App\Models\API\Map;
use App\Models\API\Pages;
use App\Models\API\Settings;
use App\Models\API\TransportationRequests;
use App\Models\API\User;
use App\Models\Place;
use App\Notifications\FcmNotification;
use App\Services\FCMService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use MongoDB\Driver\Session;
use Exception;
use Illuminate\Support\Facades\Notification;

class PassengerController extends Controller
{

    public function edit_profile(Request $request){
        $pages = Pages::query()->find(7);
        $pages->increment('count');
        $res = [
            'user' => $request->user(),
        ];
        return  $this->api_response(200,true,trans('api.user info ') , $res , 200);
    }
    public function update_profile(Request $request){
        $passenger = User::query()->where('id','=',$request->user()->id)->where('user_type','=',1)->get()->first();
        if($passenger->mobile_number == $request->mobile_number){
            $validator = Validator::make($request->all(),[
                'full_name' => 'required',
                'mobile_number' => 'required',
                'address' => 'required',

            ],[
                'full_name.required' => trans("api.full name field is required"),
                'mobile_number.required' => trans("api.mobile_number field is required"),
                'mobile_number.unique' => trans("api.The mobile number has already been taken"),
                'address.required' => trans("api.address field is required"),
            ]);
        }else{
            $validator = Validator::make($request->all(),[
                'full_name' => 'required',
                'mobile_number' => 'required|unique:users',
                'address' => 'required',

            ],[
                'full_name.required' => trans("api.full name field is required"),
                'mobile_number.required' => trans("api.mobile_number field is required"),
                'mobile_number.unique' => trans("api.The mobile number has already been taken"),
                'address.required' => trans("api.address field is required"),
            ]);
        }
        if ($validator->passes()) {
            if ($passenger){
                try {
                    $passenger->full_name = $request->full_name;
                    $passenger->mobile_number = $request->mobile_number;
                    $passenger->address = $request->address;
                    Mail::to($passenger->email)->send(new updateProfile($passenger));
                    $passenger->save();
                    $res = [
                        'user' => $passenger,
                    ];
                    return  $this->api_response(200,true,trans('api.The data has been modified successfully') , $res , 200);
                }catch (Exception $e){
                    return  $this->setError(400 ,false, trans('api.An error occurred during the modification process. Please check that the converted data is correct again') , 400);
                }
            }else{
                return  $this->setError(400 ,false, trans('api.user not found') , 400);
            }

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
            $fcm_token = $request->header('X-User-FCM-Token');
            if (Hash::check($request->current_password,$passenger->password) ){
                $passenger->password = Hash::make($request->new_password);
                $passenger->fcm_token = $fcm_token;
                $passenger->save();
                $res = [
                    'user' => $request->user(),
                ];
                Mail::to($passenger->email)->send(new updatePassword($passenger));
                return  $this->api_response(200,true,trans('api.changed password successfully') , $res , 200);
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
            return  $this->api_response(200,true,trans('api.Reset link has  been send to your email, please check it') , "" , 200);
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
    public function get_data_expected(Request $request){
        try {
            $settings = Settings::query()->find(1);
            $places =  Place::query()->find($request->destination_id);
            $price = $settings->public_price_per_km;
            if ($request->vehicle_type == 2)
                $price = $settings->private_price_per_km;

            $originLatLng = [$request->lat_from,$request->lng_from];
            $destinationLatLng = [$places->lat,$places->long];
            $apiKey = $settings->map_key;
            $result = getDistanceAndEtaByLatLng($originLatLng, $destinationLatLng, $apiKey ,$price );
            return $this->api_response(200, true, trans('api.data expected'), $result, 200);
        }catch (Exception $e){
            return  $this->setError(200,false, substr($e->getMessage(), 0, 100) , 200);
        }
    }

    public function find_transportion(Request $request){
        $validator = Validator::make($request->all(),[
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
        ],[
            'lat_from.required' => trans("api.lat_from field is required"),
            'lng_from.required' => trans("api.lng_from field is required"),
            'lat_to.required' => trans("api.lat_to field is required"),
            'lng_to.required' => trans("api.lng_to field is required"),
            'departure_time.required' => trans("api.departure_time field is required"),
            'number_of_passenger.required' => trans("api.number_of_passenger field is required"),
            'vehicle_type.required' => trans("api.The vehicle type field is required."),
            'distance.required' => trans("api.distance field is required"),
            'expected_cost.required' => trans("api.expected_cost field is required"),
            'arrival_time.required' => trans("api.arrival_time field is required"),
        ]);
        $passenger_id = User::query()->where('user_type','=',1)->where('id','=',$request->user()->id)->get()->first();
        $place = Map::query()->where('lat' ,'=',$request->lat_to)->where('long','=',$request->lng_to)->get()->first();
        $pages = Pages::query()->find(6);
        $pages->increment('count');
        if ($validator->passes()){
            /*$time = now()->format('h:i A');
            $departure_time = Carbon::parse($request->departure_time);
            if ($departure_time->lessThan($time)){
                return  $this->setError(200,false, trans("api.The time entered for departure is incorrect. Please add a value greater than the current time") , 200);
            }*/
            if ($passenger_id){
                    try {
                        $transportation_requests = new TransportationRequests();
                        if (isTimeLessThanNow($request->departure_time)){
                            return  $this->setError(200,false, trans("api.The time entered for departure is incorrect. Please add a value greater than the current time") , 200);
                        }
                        $transportation_requests->passenger_id = $request->user()->id;
                        $transportation_requests->lat_from = $request->lat_from;
                        $transportation_requests->lng_from = $request->lng_from;
                        $transportation_requests->lat_to = $request->lat_to;
                        $transportation_requests->lng_to = $request->lng_to;
                        $transportation_requests->departure_time = mb_convert_encoding($request->departure_time, 'UTF-8', 'auto');;
                        $transportation_requests->number_of_passenger = $request->number_of_passenger;
                        $transportation_requests->vehicle_type = $request->vehicle_type;
                        $transportation_requests->distance = $request->distance;
                        $transportation_requests->expected_cost = $request->expected_cost;
                        $transportation_requests->arrival_time = $request->arrival_time;
                        $transportation_requests->destination = '';
                        if ($place){
                            $transportation_requests->destination = $place->name;
                        }
                        $transportation_requests->save();
                        $transportation_requests->passenger_name = getUserName($transportation_requests->passenger_id);

                        /*$fcm = User::query()->find(12)->notify(new FcmNotification($transportation_requests));*/
                        $users = User::query()->where('vehicle_type','=',$request->vehicle_type)->where('user_type','=',2)->get();
                        foreach ($users as $user){
                            $car = Car::query()->where('user_id','=',$user->id)->where('status','=',1)->get()->first();
                            if ($car){
                                try {
                                    $user->notify(new FcmNotification($transportation_requests));
                                } catch (Exception $e) {
                                    if ($e->getCode() === 'messaging/registration-token-not-registered') {
                                        return  $this->setError(200 ,false, substr($e->getMessage(), 0, 100) , 200);

                                    } else {
                                        // Handle other messaging exceptions
                                        // Log the error or take appropriate action
                                    }
                                }
                            }
                        }

                       /* $time_wating = 1 ;
                        $status = TransportationRequests::query()->find($transportation_requests->id);

                        while($status->status == 1 && $time_wating <= 10){
                            sleep(2);
                            $status->refresh()->status;
                            $time_wating ++ ;
                        }
                        if ($time_wating == 11){
                            $status->status = 5;
                            $status->save();
                            return $this->api_response(200, true, trans('api.There are currently no drivers available, please try again later'), $status, 200);
                        }*/

                        return $this->api_response(200, true, trans('api.find_transportion'), $transportation_requests, 200);
                    }catch (Exception $e){
                        return  $this->setError(200 ,false, substr($e->getMessage(), 0, 100) , 200);
                    }
            }else{
                return  $this->setError(200,false, "api.Passenger id not correct" , 200);

            }
        }else{
            return  $this->setError(200,false, $validator->errors()->first() , 200);
        }

    }

    public function get_transportion_by_id(Request $request){
        $validator = Validator::make($request->all(),[
            'transportion_id' => 'required',
        ],[
            'transportion_id.required' => trans("api.transportion_id field is required"),
        ]);
        if ($validator->passes()){
            $transportation_requests =  TransportationRequests::find($request->transportion_id);
            /*$departure_time = Carbon::parse($transportation_requests->departure_time);
            $time = now()->format('h:i A');
            if ($transportation_requests->status == 1 && $departure_time->lessThan($time)){
                TransportationRequests::query()->where('id', $request->transportion_id)->update(['status' => 5]);
            }*/
            $transportation_requests->passenger_name = getUserName($transportation_requests->passenger_id);
            $transportation_requests->driver_name = getUserName($transportation_requests->driver_id);
            $transportation_requests->status_name = getStatusTypeAttribute($transportation_requests->status);
            $transportation_requests->driver_phone = getUserNumber($transportation_requests->driver_id);
            $transportation_requests->passenger_phone = getUserNumber($transportation_requests->passenger_id);

            return $this->api_response(200, true, trans('api.find_transportion'), $transportation_requests, 200);

        }else{
            return  $this->setError(200,false, $validator->errors()->first() , 200);
        }
    }

    public function my_transportion(Request $request){
        $type = $request->input('status_type');
        $value = 0;
        try {
            $Mytransportation  = TransportationRequests::query()->where('passenger_id','=',$request->user()->id)
                ->where('status', '!=', 5)
                ->when($type == 'End_Trip', function ($query) use ($value) {
                    $query->where('status', '=', 4);
                })
                ->when($type == 'All', function ($query) use ($value) {
                    $query->where('status', '!=', 4);
                })
                ->orderBy('id', 'DESC')->get();
            foreach ($Mytransportation as $mytransportation){
                if ($mytransportation->status == 1 && isTimeLessThanNow($mytransportation->departure_time)){
                    TransportationRequests::query()->where('id', $mytransportation->id)->update(['status' => 5]);
                }

                    $place = Map::query()->where('lat' ,'=',$mytransportation->lat_to)->where('long','=',$mytransportation->lng_to)->get()->first();

                    $mytransportation->passenger_name = getUserName($mytransportation->passenger_id);
                    if ($place){
                        $mytransportation->destination = $place->name;

                    }
                    $mytransportation->driver_name = getUserName($mytransportation->driver_id);
                    $mytransportation->status_name = getStatusTypeAttribute($mytransportation->status);
                    $mytransportation->driver_phone = getUserNumber($mytransportation->driver_id);
                    $mytransportation->passenger_phone = getUserNumber($mytransportation->passenger_id);

            }
            return  $this->api_response(200,true,trans('api.my transportation') , $Mytransportation , 200);
        }catch (Exception $e){
            return  $this->api_response(200,true, substr($e->getMessage() , 0, 100) , '' , 200);
        }
    }
    public function verification_email(Request $request){
        try {
            $request->user()->sendEmailVerificationNotification();
            return $this->api_response(200, true, trans('api.An email has been sent to verify your email'), "", 200);

        }catch (Exception $e){
            return  $this->setError(200,false, substr($e->getMessage(), 0, 100) , 200);
        }
    }
    public function rating(Request $request){
        $validator = Validator::make($request->all(),[
            'transportion_id' => 'required',
            'car' => 'required',

        ],[
            'transportion_id.required' => trans("api.transportation_id field is required"),
            'car.required' => trans("api.rating car is required"),

        ]);
        if ($validator->passes()) {
            $transportation = TransportationRequests::query()->find($request->transportion_id);
            if ($transportation->status == 4){
                $transportation->rating_car = $request->car;
                $transportation->rating_driver = $request->driver;
                $transportation->rating_time = $request->time;
                $transportation->save();
                $transportation->passenger_name = getUserName($transportation->passenger_id);
                $transportation->driver_name = getUserName($transportation->driver_id);
                $transportation->status_name = getStatusTypeAttribute($transportation->status);

                return  $this->api_response(200,true,trans('api.Rating successfully') , $transportation , 200);
            }else{
                return  $this->setError(200,false, "api.You can't rate because the trip is not finished yet" , 200);
            }
        }else{
            return  $this->setError(200,false, $validator->errors()->first() , 200);
        }
    }
    public function report_driver(Request $request){
        $validator = Validator::make($request->all(),[
            'transportion_id' => 'required',
            'text_report' => 'required',
        ],[
            'transportion_id.required' => trans("api.transportation_id field is required"),
            'text_report.required' => trans("api.text_report field is required"),
        ]);
        if ($validator->passes()) {
            $transportation = TransportationRequests::query()->find($request->transportion_id);
            if ($transportation->status == 4){
                $transportation->complaint = $request->text_report;
                $transportation->save();
                $transportation->passenger_name = getUserName($transportation->passenger_id);
                $transportation->driver_name = getUserName($transportation->driver_id);
                $transportation->status_name = getStatusTypeAttribute($transportation->status);
                return  $this->api_response(200,true,trans('api.Report Driver Successfully') , $transportation , 200);
            }else{
                return  $this->setError(200,false, "api.You can't rate because the trip is not finished yet" , 200);
            }
        }else{
            return  $this->setError(200,false, $validator->errors()->first() , 200);
        }
    }


    public function settings(){
        $settings = Settings::query()->get();
        return  $this->api_response(200,true,trans('api.Settings ') , $settings , 200);
    }
}
