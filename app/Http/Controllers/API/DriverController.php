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
use App\Models\API\Photos;
use App\Models\API\Settings;
use App\Models\API\TransportationRequests;
use App\Models\API\User;
use App\Notifications\FcmNotification;
use App\Notifications\FcmToPassengerNotification;
use App\Services\FCMService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use MongoDB\Driver\Session;
use Exception;

class DriverController extends Controller
{
    /* I use it to get data driver.*/
    public function edit_profile(Request $request){
        $pages = Pages::query()->find(7);
        $pages->increment('count');
        $car = Car::query()->where('user_id','=',$request->user()->id)->get()->first();
        /*$carphotos = Photos::query()->where('car_id','=',$car->id)->get();

        foreach ($carphotos as  $key=>$carphotos){
            $image[$key] = url(asset('/images/cars/'.$carphotos->images));
            $car->carphotos = $image;
        }*/

        $res = [
            'user' => $request->user(),
            'car' => $car,
        ];
        return  $this->api_response(200,true,trans('api.Profile Information') , $res , 200);

    }
    /* I use this function to update the data driver*/
    public function update_profile(Request $request){
        $driver = User::query()->find($request->user()->id);
        $car = Car::query()->where('user_id','=',$request->user()->id)->get()->first();
        $fcm_token = $request->header('X-User-FCM-Token');
        $validator = Validator::make($request->all(),[
            'full_name' => 'required',
            'mobile_number' => $request->mobile_number == $request->mobile_number ? 'required' : 'required|unique:users',
            'address' => 'required',

        ],[
            'full_name.required' => trans("api.full name field is required"),
            'mobile_number.required' => trans("api.mobile_number field is required"),
            'mobile_number.unique' => trans("api.The mobile number has already been taken"),
            'address.required' => trans("api.address field is required"),
        ]);
        if ($validator->passes()) {
            try {
                if ($request->hasFile('personalphoto')){
                    $compFileName =  $request->file('personalphoto')->getClientOriginalName();
                    $fileNameOnly = pathinfo($compFileName, PATHINFO_FILENAME);
                    $extenshion = $request->file('personalphoto')->getClientOriginalExtension();
                    $comPic = str_replace(' ','_',$fileNameOnly).'-'.rand().'_'.time().'.'.$extenshion;
                    $path = $request->file('personalphoto')->move('images/users',$comPic);
                    $driver->personalphoto = $comPic;
                }
                $driver->full_name = $request->full_name;
                if ($request->mobile_number != $request->mobile_number)
                    $driver->mobile_number = $request->mobile_number;
                $driver->address = $request->address;
                if ($fcm_token){
                    $driver->fcm_token = $fcm_token;
                }
                Mail::to($driver->email)->send(new updateProfile($driver));
                $driver->save();
                $res = [
                    'user' => $driver,
                    'car' => $car,
                ];
                return  $this->api_response(200,true,trans('api.The profile data has been updated successfully') , $res , 200);
            }catch (Exception $e){
                return  $this->setError(200 ,false, substr($e->getMessage() , 0, 100) , 200);
            }

        }else{
            return  $this->setError(200,false, $validator->errors()->first() , 200);

        }
    }
    public function update_car(Request $request){
        $driver = User::query()->find($request->user()->id);
        $car = Car::query()->where('user_id','=',$request->user()->id)->get()->first();
        $fcm_token = $request->header('X-User-FCM-Token');
        $validator = Validator::make($request->all(),[
            'vehicle_type' => 'required',
            'car_number' => $request->car_number == $car->car_number ? '' : 'required|unique:cars',
            'car_brand' => 'required',
            'insurance_number' => 'required',
            'insurance_expiry_date' => 'required|date',
        ],[
            'vehicle_type.required' => trans("api.The vehicle type field is required."),
            'car_number.required' => trans("api.The car number field is required"),
            'car_number.unique' => trans("api.The car number has already been taken"),
            'car_brand.required' => trans("api.The car brand field is required"),
            'insurance_number.required' => trans("api.The insurance number field is required"),
            'insurance_expiry_date.date' => trans("api.The insurance expiry date is not a valid date"),
        ]);
        if ($validator->passes()) {
            try {
                $car->type = $request->vehicle_type;
                $car->car_number = $request->car_number;
                $car->car_brand = $request->car_brand;
                $car->insurance_number = $request->insurance_number;
                $car->insurance_expiry_date = $request->insurance_expiry_date;
                if ($request->hasFile('personalphoto')){
                    $compFileName =  $request->file('personalphoto')->getClientOriginalName();
                    $fileNameOnly = pathinfo($compFileName, PATHINFO_FILENAME);
                    $extenshion = $request->file('personalphoto')->getClientOriginalExtension();
                    $comPic = str_replace(' ','_',$fileNameOnly).'-'.rand().'_'.time().'.'.$extenshion;
                    $path = $request->file('personalphoto')->move('images/users',$comPic);
                    $driver->personalphoto = $comPic;
                }
                if ($request->hasFile('driverlicense')) {
                    $compFileName =  $request->file('driverlicense')->getClientOriginalName();
                    $fileNameOnly = pathinfo($compFileName, PATHINFO_FILENAME);
                    $extenshion = $request->file('driverlicense')->getClientOriginalExtension();
                    $comPic = str_replace(' ','_',$fileNameOnly).'-'.rand().'_'.time().'.'.$extenshion;
                    $path = $request->file('driverlicense')->move('images/users',$comPic);
                    $driver->driverlicense = $comPic;
                }
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
                    $photos->images = $comPic;
                    $photos->car_id = $car->id;
                    $car->carphotos = $comPic;
                    $photos->save();
                }
                if ($request->hasFile('carphotos2')) {
                    $photos = new Photos();
                    $compFileName =  $request->file('carphotos2')->getClientOriginalName();
                    $fileNameOnly = pathinfo($compFileName, PATHINFO_FILENAME);
                    $extenshion = $request->file('carphotos2')->getClientOriginalExtension();
                    $comPic = str_replace(' ','_',$fileNameOnly).'-'.rand().'_'.time().'.'.$extenshion;
                    $path = $request->file('carphotos2')->move('images/cars',$comPic);
                    $photos->images = $comPic;
                    $photos->car_id = $car->id;
                    $car->carphotos2 = $comPic;
                    $photos->save();
                }
                if ($request->hasFile('carphotos3')) {
                    $photos = new Photos();
                    $compFileName =  $request->file('carphotos3')->getClientOriginalName();
                    $fileNameOnly = pathinfo($compFileName, PATHINFO_FILENAME);
                    $extenshion = $request->file('carphotos3')->getClientOriginalExtension();
                    $comPic = str_replace(' ','_',$fileNameOnly).'-'.rand().'_'.time().'.'.$extenshion;
                    $path = $request->file('carphotos3')->move('images/cars',$comPic);
                    $photos->images = $comPic;
                    $photos->car_id = $car->id;
                    $car->carphotos3 = $comPic;
                    $photos->save();
                }
                /*if ($files =$request->file('carphotos')) {
                    $photos = new Photos();
                    Photos::query()->where('car_id','=',$car->id)->delete();

                    foreach ($files as $file) {
                        $compFileName =  $file->getClientOriginalName();
                        $fileNameOnly = pathinfo($compFileName, PATHINFO_FILENAME);
                        $extenshion = $file->getClientOriginalExtension();
                        $comPic = str_replace(' ','_',$fileNameOnly).'-'.rand().'_'.time().'.'.$extenshion;
                        $path = $file->move('images/cars',$comPic);

                        Photos::create([
                            'images' => $comPic,
                            'car_id' => $car->id,
                        ]);
                    }
                }*/

                Mail::to($driver->email)->send(new updateProfile($driver));
                $car->save();
                $driver->save();
                $res = [
                    'user' => $driver,
                    'car' => $car,
                ];
                return  $this->api_response(200,true,trans('api.The vehicle data has been updated successfully') , $res , 200);
            }catch (Exception $e){
                return  $this->setError(200 ,false, trans('api.An error occurred during the modification process. Please check that the converted data is correct again') , 200);
            }

        }else{
            return  $this->setError(200,false, $validator->errors()->first() , 200);

        }
    }
    public function change_password(Request $request){
        $validator = Validator::make($request->all(),[
            'current_password' => 'required',
            'new_password' => 'required||min:8|confirmed',
        ]);
        if ($validator->passes()) {
            $driver = User::query()->find($request->user()->id);
            if (Hash::check($request->current_password,$driver->password) ){
                $driver->password = Hash::make($request->new_password);
                $driver->save();
                Mail::to($driver->email)->send(new updatePassword($driver));
                return  $this->api_response(200,true,trans('api.changed password successfully') , $request->user() , 200);
            }else{
                return  $this->setError(200,false, trans('api.the current password is not true') , 200);
            }
        }else{
            return  $this->setError(200,false, $validator->errors()->first() , 200);
        }
    }
    public function reset_password_with_email(Request $request){
        try {
            $driver = User::query()->find($request->user()->id);
            Mail::to($driver->email)->send(new changePassword($driver));
            return  $this->api_response(200,true,trans('api.Reset link has  been send to your email, please check it') , "" , 200);
        } catch (\Exception $e) {
            return  $this->setError(200,false, "api.Something went wrong, please try again later!" , 200);
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
    public function available_transportion(Request $request){
        try {
            $driver = User::query()->find($request->user()->id);
            $car = Car::query()->where('user_id','=',$request->user()->id)->where('status','=',1)->get()->first();
            $available_transportion = TransportationRequests::query()->where('status','=',1)->where('vehicle_type','=',$driver->vehicle_type)
                ->orWhere('status','!=',1)->where('driver_id','=',$request->user()->id)->where('vehicle_type','=',$driver->vehicle_type)->orderBy('id', 'DESC')->get();
            if ($car){
                foreach ($available_transportion as $mytransportation){
                    $place = Map::query()->where('lat','=',$mytransportation->lat_to)->where('long','=',$mytransportation->lng_to)->get()->first();
                    $mytransportation->destination = '';
                    $mytransportation->passenger_name = getUserName($mytransportation->passenger_id);
                    $mytransportation->driver_name = getUserName($mytransportation->driver_id);
                    $mytransportation->status_name = getStatusTypeAttribute($mytransportation->status);
                    if ($place){
                        $mytransportation->destination = $place->name;
                    }
                }
                return  $this->api_response(200,true,trans('api.There are no requests to display') , $available_transportion , 200);
            }else{
                return  $this->api_response(200,true, trans('api.You cannot receive requests until your identity has been verified by the administrator') , [] , 200);

            }
        }catch (Exception $e){
            return  $this->api_response(200,false, substr($e->getMessage() , 0, 100) , '' , 200);
        }
    }
    public function accept_transportion(Request $request){
        $validator = Validator::make($request->all(),[
            'transportation_id' => 'required',
        ]);
        $driver = User::query()->where('user_type','=',2)->where('id','=',$request->user()->id)->get()->first();
        $transportation = TransportationRequests::query()->find($request->transportation_id);
        if ($validator->passes()){
            if ($driver && $transportation){
                if ($transportation->status == 1){
                    $transportation->driver_id = $request->user()->id;
                    $transportation->status = 2;
                    $transportation->save();
                    $transportation->passenger_name = getUserName($transportation->passenger_id);
                    $transportation->driver_name = getUserName($transportation->driver_id);
                    $transportation->status_name = getStatusTypeAttribute($transportation->status);
                    User::query()->where('id','=',$transportation->passenger_id)->get()->first()->notify(new FcmToPassengerNotification($transportation));
                    return  $this->api_response(200,true,trans('api.The request has been successfully accepted') , $transportation, 200);
                }else if ($transportation->status == 2 && $transportation->driver_id == $request->user()->id){
                    $transportation->passenger_name = getUserName($transportation->passenger_id);
                    $transportation->driver_name = getUserName($transportation->driver_id);
                    $transportation->status_name = getStatusTypeAttribute($transportation->status);
                    return  $this->api_response(200,true,trans('api.The request has been successfully accepted') , $transportation, 200);
                }else{
                    return  $this->setError(200 ,false, trans('api.The trip was taken by another driver') , 200);
                }
            }else{
                return  $this->setError(200 ,false, trans('api.driver or transportation not found') , 200);
            }
        }
    }
    public function start_trip(Request $request){
        $validator = Validator::make($request->all(),[
            'transportation_id' => 'required',
        ]);
        $driver = User::query()->where('user_type','=',2)->where('id','=',$request->user()->id)->get()->first();
        $transportation = TransportationRequests::query()->find($request->transportation_id);
        if ($validator->passes()){
            if ($transportation){
                if ($transportation->status == 2){
                    $transportation->start_trip = now();
                    $transportation->status = 3;
                    $transportation->save();
                    $transportation->passenger_name = getUserName($transportation->passenger_id);
                    $transportation->driver_name = getUserName($transportation->driver_id);
                    $transportation->status_name = getStatusTypeAttribute($transportation->status);
                    return  $this->api_response(200,true,trans('api.The request to start the trip has been completed successfully') , $transportation , 200);
                }else if ($transportation->status == 3 && $transportation->driver_id == $request->user()->id){
                    $transportation->passenger_name = getUserName($transportation->passenger_id);
                    $transportation->driver_name = getUserName($transportation->driver_id);
                    $transportation->status_name = getStatusTypeAttribute($transportation->status);
                    return  $this->api_response(200,true,trans('api.The request to start the trip has been completed successfully') , $transportation, 200);
                }else{
                    return  $this->setError(200 ,false, trans('api.You cannot start the trip. Please check the status of the request and try again') , 200);
                }
            }else{
                return  $this->setError(200 ,false, trans('api.driver or transportation not found') , 200);
            }
        }
    }
    public function end_trip(Request $request){
        $validator = Validator::make($request->all(),[
            'transportation_id' => 'required',
        ]);
        $driver = User::query()->where('user_type','=',2)->where('id','=',$request->user()->id)->get()->first();
        $transportation = TransportationRequests::query()->find($request->transportation_id);
        if ($validator->passes()){
            if ($driver || $transportation){
                if ($transportation->status == 3){
                    $transportation->end_trip = now();
                    $transportation->status = 4;
                    $transportation->save();
                    $transportation->passenger_name = getUserName($transportation->passenger_id);
                    $transportation->driver_name = getUserName($transportation->driver_id);
                    $transportation->status_name = getStatusTypeAttribute($transportation->status);
                    return  $this->api_response(200,true,trans('api.The trip has been completed successfully') , $transportation , 200);
                }else if ($transportation->status == 4 && $transportation->driver_id == $request->user()->id){
                    $transportation->passenger_name = getUserName($transportation->passenger_id);
                    $transportation->driver_name = getUserName($transportation->driver_id);
                    $transportation->status_name = getStatusTypeAttribute($transportation->status);
                    return  $this->api_response(200,true,trans('api.The trip has been completed successfully') , $transportation, 200);
                }else{
                    return  $this->setError(200 ,false, trans('api.You cannot end the trip. Please check the status of the request and try again') , 200);
                }

            }else{
                return  $this->setError(200 ,false, trans('api.driver or transportation not found') , 200);

            }
        }
    }
    public function rating(Request $request){
        $validator = Validator::make($request->all(),[
            'transportion_id' => 'required',
            'passenger_rating' => 'required',
        ]);
        if ($validator->passes()) {
            $transportation = TransportationRequests::query()->find($request->transportion_id);
             if ($transportation->status == 4){
                $transportation->rating_passenger = $request->passenger_rating;
                $transportation->save();
                 $transportation->passenger_name = getUserName($transportation->passenger_id);
                 $transportation->driver_name = getUserName($transportation->driver_id);
                 $transportation->status_name = getStatusTypeAttribute($transportation->status);
                 return  $this->api_response(200,true,trans('api.Rating successfully') , $transportation , 200);
             }else{
                 return  $this->setError(200,false, trans("api.You can't rate because the trip is not finished yet") , 200);
             }
        }else{
            return  $this->setError(200,false, $validator->errors()->first() , 200);
        }
    }
    public function report_passenger(Request $request){
        $validator = Validator::make($request->all(),[
            'transportion_id' => 'required',
            'text_report' => 'required',
        ]);
        if ($validator->passes()) {
            $transportation = TransportationRequests::query()->find($request->transportion_id);
            if ($transportation->status == 4){
                $transportation->complaintDriver = $request->text_report;
                $transportation->save();
                $transportation->passenger_name = getUserName($transportation->passenger_id);
                $transportation->driver_name = getUserName($transportation->driver_id);
                $transportation->status_name = getStatusTypeAttribute($transportation->status);
                return  $this->api_response(200,true,trans('api.Report passenger successfully ') , $transportation , 200);
            }else{
                return  $this->setError(200,false, trans("api.You can't rate because the trip is not finished yet") , 200);
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
