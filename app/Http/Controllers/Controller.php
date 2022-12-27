<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function api_response($code , $success , $message , $data , $status)
    {
        return response()->json([
            'code'=> $code,
            'success' => $success,
            'message'=>$message,
            'data'=>$data
        ],$status);
    }
    public function setError($code, $success , $message,$status) {
        return response()->json([
            'code'=> $code,
            'success' => $success,
            'message'=>$message,
        ],$status);
    }
}
