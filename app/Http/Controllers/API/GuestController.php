<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\changePassword;
use App\Models\API\Announcements;
use App\Models\API\ContactEmergency;
use App\Models\API\Map;
use App\Models\API\News;
use App\Models\API\Pages;
use App\Models\API\Stations;
use App\Models\API\TourGuids;
use App\Models\API\TourismActivities;
use App\Models\API\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class GuestController extends Controller
{
    //
    public function stations(){
        $stations = Stations::query()->where('type','=',3)->get();
        return  $this->api_response(200,true,trans('api.Stations List') , $stations , 200);


    }
    public function map(){
        $map = Map::query()->where('type','!=',3)->get();
        return  $this->api_response(200,true,trans('api.Map List') , $map , 200);
    }
    public function tourism_activities(){
        $tourismActivities = TourismActivities::query()->where('status','=',1)->get()->all();
        $pages = Pages::query()->find(3);
        $pages->increment('count');
        return  $this->api_response(200,true,trans('api.Tourism Activities List') , $tourismActivities , 200);
    }
    public function tour_guids(){
        $tourGuids = TourGuids::query()->where('status','=',1)->get()->all();
        $pages = Pages::query()->find(4);
        $pages->increment('count');
        return  $this->api_response(200,true,trans('api.Tour Guids List') , $tourGuids , 200);
    }
    public function contact_emergency(){
        $contactEmergency = ContactEmergency::query()->where('status','=',1)->get()->all();
        $pages = Pages::query()->find(5);
        $pages->increment('count');
        return  $this->api_response(200,true,trans('api.Contact Emergency List') , $contactEmergency , 200);
    }
    public function news(){
        $news = News::query()->where('type','=',1)->where('status','=',1)->get()->all();
        $pages = Pages::query()->find(2);
        $pages->increment('count');
        return  $this->api_response(200,true,trans('api.News List') , $news , 200);
    }
    public function announcements(){
        $announcements = Announcements::query()->where('type','=',2)->where('status','=',1)->get()->all();
        return  $this->api_response(200,true,trans('api.Announcements List') , $announcements , 200);
    }
    public function get_all_places(){
        $places = Map::query()->get()->all();
        return  $this->api_response(200,true,trans('api.Places List') , $places , 200);
    }

    public function reset_using_email(Request $request){
        try {
            $user = User::query()->where('email','=',$request->email)->where('user_type','=',$request->user_type)->get()->first();
            if ($user){
                Mail::to($user->email)->send(new changePassword($user));
                return  $this->api_response(200,true,trans('api.Reset link has  been send to your email, please check it') , "" , 200);
            }else{
                return  $this->api_response(200,true,trans('api.This e-mail is not registered') , "" , 200);
                return  $this->setError(200,false, (string)$request->user_type , 200);

            }
        } catch (\Exception $e) {
            return  $this->setError(200,false, "api.Something went wrong, please try again later!" , 200);
        }
    }

}
