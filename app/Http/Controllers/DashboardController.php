<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class DashboardController extends Controller
{
    public function index(){

        return view('dashboard');
    }
    public function fcm(){
        return view('welcome');


    }

    public function send(){
        $token = "e4xNWiVzJwc:APA91bExghKUPj1autgHmEEJOH5IMWgTsaR-9uCVDNDUJsCDw9rs9acimSaqDlWqgiwdznps7Bie_NRJSeCi8gK-Mh2M69vAO9T04SEtqjM9XG1B4u6Z5JZBspsAffY3FyvLxBVK4Acp";
        $from = "AAAA-oHevfI:APA91bH3DodaA0lVLizEu9VYvsEc-Y4YNTtRuV1_6ne_IOc4Yvk6EeCugboLnC-QKGM_-4uGvfrt_zY2wypbo5K7lJh6T8Dxm88SEP68MkTSWjouBXaCPA8S-g_ebjVz-TRx8UtFWTGd";
        $msg = array
        (
            'body'  => "Testing Testing",
            'title' => "Hi, From Raj",
            'receiver' => 'erw',
            'icon'  => "https://image.flaticon.com/icons/png/512/270/270014.png",/*Default Icon*/
            'sound' => 'mySound'/*Default sound*/
        );

        $fields = array
        (
            'to'        => $token,
            'notification'  => $msg
        );

        $headers = array
        (
            'Authorization: key=' . $from,
            'Content-Type: application/json'
        );
        //#Send Reponse To FireBase Server
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
    }
}
