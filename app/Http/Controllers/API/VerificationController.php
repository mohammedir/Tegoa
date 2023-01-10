<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\changePassword;
use App\Mail\emailVerified;
use App\Models\API\Car;
use App\Models\API\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VerificationController extends Controller
{
    //

    public function verify($user_id, Request $request) {
        if (!$request->hasValidSignature()) {
            return response()->json(["msg" => "Invalid/Expired url provided."], 401);
        }

        $user = User::findOrFail($user_id);
        $car = Car::query()->where('user_id','=',$user_id)->get()->first();
        $emai = User::query()->find($user_id);
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            if ($car){
                $car->is_email_verified = 1;
                Mail::to($emai->email)->send(new emailVerified($emai));
                $car->save();

            }

        }

        return view('welcome');
    }

    public function resend() {
        if (auth()->user()->hasVerifiedEmail()) {
            return response()->json(["msg" => "Email already verified."], 400);
        }

        auth()->user()->sendEmailVerificationNotification();

        return response()->json(["msg" => "Email verification link sent on your email id"]);
    }
}
