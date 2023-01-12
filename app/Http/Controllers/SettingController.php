<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:settings_view|settings_edit']);
    }

    public function index()
    {
        $settings = Setting::all()->where('id',1)->first();
        return view('settings.index',compact('settings'));
    }

    public function updateOne(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'public_price' => 'required|numeric|min:1',
            'private_price' => 'required|numeric|min:1',
            'key' => 'required|string|max:255',
        ], [
            'public_price.required' => trans("web.required"),
            'public_price.numeric' => trans("web.numeric"),
            'public_price.min' => trans("web.minPrice"),

            'private_price.required' => trans("web.required"),
            'private_price.numeric' => trans("web.numeric"),
            'private_price.min' => trans("web.minPrice"),

            'key.required' => trans("web.required"),
            'key.string' => trans("web.string"),
            'key.max' => trans("web.max"),
        ]);
        if ($validator->passes()) {
            $data = Setting::find(1);
            $data->public_price_per_km = $request->public_price;
            $data->private_price_per_km = $request->private_price;
            $data->map_key = $request->key;
            $data->save();
            return response()->json(['success' => $data]);
        }
        return response()->json(['error' => $validator->errors()->toArray()]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
