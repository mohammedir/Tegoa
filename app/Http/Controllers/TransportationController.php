<?php

namespace App\Http\Controllers;

use App\Models\Transportation;
use App\Models\User;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransportationController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:transportations_view']);
    }

    public function index(Request $request)
    {
        $transportations_all = DB::table('transportation_requests')->where('status','=',4)->orderBy('id', 'desc')->paginate(10);
        return view('transportations.index', compact('transportations_all'));
    }

    function fetch_data(Request $request)
    {
        if ($request->ajax()) {
            if ($request->search) {
                $values = [];
                $transportations_all = [];
                $data = DB::table('users')->where('full_name', 'LIKE', '%' . $request->search . "%")->get();
                if (array($data)) {
                    foreach ($data as $product) {
                        $values[] = $product->id;
                    }
                }
                foreach ($values as $value) {
                    $transportations_Values = DB::table('transportation_requests')->where('driver_id', 'LIKE', '%' . $value . "%")->orderBy('id', 'desc')->get();
                    foreach ($transportations_Values as $v) {
                        $transportations_all[] = $v;
                    }
                }
                return view('transportations.search', compact('transportations_all'))->render();
            }else{
                $transportations_alls = DB::table('transportation_requests')->orderBy('id', 'desc')->paginate(10);
                return view('transportations.searchEmpty', compact('transportations_alls'))->render();
            }
        }
    }

    public function SearchDate(Request $request)
    {
        if ($request->ajax()) {
            $transportations_all = Transportation::whereBetween('created_at', [$request->start, $request->end])->orderBy('id', 'desc')->get();
            if ($transportations_all->isEmpty()) {
                $transportations_alls = [];
                return view('transportations.searchEmpty', compact('transportations_alls'))->render();
            } else {
                return view('transportations.search', compact('transportations_all'))->render();
            }
        }
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        //
    }

    public function show(Request $request, Transportation $transportation)
    {
        if ($request->ajax()) {
            $activity = Transportation::find($transportation->id);
            return response()->json($activity->complaint);
        }
    }

    public function edit(Transportation $transportation)
    {
        //
    }

    public function update(Request $request, Transportation $transportation)
    {
        //
    }

    public function destroy(Transportation $transportation)
    {
        //
    }


}
