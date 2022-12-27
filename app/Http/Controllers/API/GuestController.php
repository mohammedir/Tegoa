<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\API\Announcements;
use App\Models\API\ContactEmergency;
use App\Models\API\News;
use App\Models\API\TourGuids;
use App\Models\API\TourismActivities;


class GuestController extends Controller
{
    //

    public function news(){

        $news = News::query()->where('type','=',1)->where('status','=',1)->get()->all();
        return  $this->api_response(200,true,trans('api.News List') , $news , 200);
    }

    public function announcements(){
        $announcements = Announcements::query()->where('type','=',2)->where('status','=',1)->get()->all();
        return  $this->api_response(200,true,trans('api.Announcements List') , $announcements , 200);
    }

    public function tourism_activities(){
        $tourismActivities = TourismActivities::query()->where('status','=',1)->get()->all();
        return  $this->api_response(200,true,trans('api.Tourism Activities List') , $tourismActivities , 200);
    }
    public function tour_guids(){
        $tourGuids = TourGuids::query()->where('status','=',1)->get()->all();
        return  $this->api_response(200,true,trans('api.Tour Guids List') , $tourGuids , 200);
    }
    public function contact_emergency(){
        $contactEmergency = ContactEmergency::query()->where('status','=',1)->get()->all();
        return  $this->api_response(200,true,trans('api.Contact Emergency List') , $contactEmergency , 200);
    }

}
