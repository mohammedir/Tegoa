<?php

namespace App\Http\Controllers;

use App\Models\Transportation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransportationController extends Controller
{

    public function index(Request $request)
    {
        $transportations_all = DB::table('transportation_requests')->orderBy('id', 'desc')->paginate(10);

        if ($request->ajax()) {
            $output = "";
            $values = [];
            if ($transportations_all->isEmpty()) {
                return response('');
            }
            if ($request->search) {
                $products = DB::table('users')->where('full_name', 'LIKE', '%' . $request->search . "%")->get();
                if ($products->isEmpty()) {
                    return response('<br><span>'.trans('web.No data available in table').'</span><br>');
                } else {
                    foreach ($products as $product) {
                        $values[] = $product->id;
                    }
                }
            } elseif (is_null($request->search)) {
                $transportationss = DB::table('transportation_requests')->orderBy('id', 'desc')->paginate(10);
                foreach ($transportationss as $v) {
                    $btn = "";
                    if ($v->complaint != null){
                        $btn = ' <button id="show" data-id="' . $v->id . '" class="btn btn-icon btn-outline btn-outline-dashed btn-outline-primary btn-active-dark-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_show_complaint"><i class="bi bi-eye"></i></button>';
                    }
                    $output .=
                        '<tr>
                                <td>' . User::find($v->driver_id)->full_name . '</td>
                                <td>' . User::find($v->passenger_id)->full_name . '</td>
                                <td>
                                    <div class="ratings">
                                        ' . str_repeat('<span> <i class="fa fa-star rating-color"></i>', $v->rating_car) . '
                                        ' . str_repeat('<span><i class="fa fa-star"></i>', 5 - $v->rating_car) . '
                                    </div>
                                </td>
                                <td>
                                    <div class="ratings">
                                        <div class="ratings">
                                            ' . str_repeat('<span> <i class="fa fa-star rating-color"></i>', $v->rating_time) . '
                                            ' . str_repeat('<span><i class="fa fa-star"></i>', 5 - $v->rating_time) . '
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="ratings">
                                        <div class="ratings">
                                            ' . str_repeat('<span> <i class="fa fa-star rating-color"></i>', $v->rating_driver) . '
                                            ' . str_repeat('<span><i class="fa fa-star"></i>', 5 - $v->rating_driver) . '
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="ratings">
                                        <div class="ratings">
                                            ' . str_repeat('<span> <i class="fa fa-star rating-color"></i>', $v->rating_passenger) . '
                                            ' . str_repeat('<span><i class="fa fa-star"></i>', 5 - $v->rating_passenger) . '
                                        </div>
                                    </div>
                                </td>
                                <td>
                                '.$btn.'
                                </td>
                            </tr>';
                }
                return Response($output);
            }
            if ($values) {
                foreach ($values as $key => $value) {
                    $transportation = DB::table('transportation_requests')->where('driver_id', 'LIKE', '%' . $value . "%")->get();
                    foreach ($transportation as $v) {
                        $btn = "";
                        if ($v->complaint != null){
                            $btn = ' <button id="show" data-id="' . $v->id . '" class="btn btn-icon btn-outline btn-outline-dashed btn-outline-primary btn-active-dark-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_show_complaint"><i class="bi bi-eye"></i></button>';
                        }
                        $output .=
                            '<tr>
                                <td>' . User::find($v->driver_id)->full_name . '</td>
                                <td>' . User::find($v->passenger_id)->full_name . '</td>
                                <td>
                                    <div class="ratings">
                                        ' . str_repeat('<span> <i class="fa fa-star rating-color"></i>', $v->rating_car) . '
                                        ' . str_repeat('<span><i class="fa fa-star"></i>', 5 - $v->rating_car) . '
                                    </div>
                                </td>
                                <td>
                                    <div class="ratings">
                                        <div class="ratings">
                                            ' . str_repeat('<span> <i class="fa fa-star rating-color"></i>', $v->rating_time) . '
                                            ' . str_repeat('<span><i class="fa fa-star"></i>', 5 - $v->rating_time) . '
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="ratings">
                                        <div class="ratings">
                                            ' . str_repeat('<span> <i class="fa fa-star rating-color"></i>', $v->rating_driver) . '
                                            ' . str_repeat('<span><i class="fa fa-star"></i>', 5 - $v->rating_driver) . '
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="ratings">
                                        <div class="ratings">
                                            ' . str_repeat('<span> <i class="fa fa-star rating-color"></i>', $v->rating_passenger) . '
                                            ' . str_repeat('<span><i class="fa fa-star"></i>', 5 - $v->rating_passenger) . '
                                        </div>
                                    </div>
                                </td>
                                <td>
                                '.$btn.'
                                </td>
                            </tr>';
                    }

                }
                return Response($output);
            }
        }
        return view('transportations.index', compact('transportations_all'));
    }

    public function SearchDate(Request $request)
    {
        if ($request->ajax()) {
            $output = "";
            $btn = "";
            $data = Transportation::whereBetween('created_at', [$request->start, $request->end])->orderBy('id', 'desc')->get();
            if (!$data->isEmpty()) {
                foreach ($data as $v) {
                    $btn = "";
                    if ($v->complaint != null){
                        $btn = ' <button id="show" data-id="' . $v->id . '" class="btn btn-icon btn-outline btn-outline-dashed btn-outline-primary btn-active-dark-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_show_complaint"><i class="bi bi-eye"></i></button>';
                    }
                    $output .=
                        '<tr>
                                <td>' . User::find($v->driver_id)->full_name . '</td>
                                <td>' . User::find($v->passenger_id)->full_name . '</td>
                                <td>
                                    <div class="ratings">
                                        ' . str_repeat('<span> <i class="fa fa-star rating-color"></i>', $v->rating_car) . '
                                        ' . str_repeat('<span><i class="fa fa-star"></i>', 5 - $v->rating_car) . '
                                    </div>
                                </td>
                                <td>
                                    <div class="ratings">
                                        <div class="ratings">
                                            ' . str_repeat('<span> <i class="fa fa-star rating-color"></i>', $v->rating_time) . '
                                            ' . str_repeat('<span><i class="fa fa-star"></i>', 5 - $v->rating_time) . '
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="ratings">
                                        <div class="ratings">
                                            ' . str_repeat('<span> <i class="fa fa-star rating-color"></i>', $v->rating_driver) . '
                                            ' . str_repeat('<span><i class="fa fa-star"></i>', 5 - $v->rating_driver) . '
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="ratings">
                                        <div class="ratings">
                                            ' . str_repeat('<span> <i class="fa fa-star rating-color"></i>', $v->rating_passenger) . '
                                            ' . str_repeat('<span><i class="fa fa-star"></i>', 5 - $v->rating_passenger) . '
                                        </div>
                                    </div>
                                </td>
                                <td>
                                '.$btn.'
                                </td>
                            </tr>';
                }
                return Response($output);
            }else{
                return response('<br><span>'.trans('web.No data available in table').'</span><br>');
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

    public function show(Request $request,Transportation $transportation)
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
