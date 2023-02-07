<!DOCTYPE html>
<html @if(App::getLocale() == 'en') lang="en" dir="ltr" @else lang="ar" dir="rtl" @endif>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>transportations</title>
    <style>
        body {
            font-family: arial, sans-serif;
            letter-spacing: -0.3px;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid black;
            padding: 4px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>
<strong>{{ __('web.transportations_list') }}<span> ({{count($pd)}})</span></strong>
<br>
<br>
<table class="table">
    <thead>
    <tr>
        <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">
            @lang('web.Driver name')
        </th>
        <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">
            @lang('web.Passenger name')
        </th>
        <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">
            @lang('web.Car')
        </th>
        <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">
            @lang('web.Time')
        </th>
        <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">
            @lang('web.Driver')
        </th>
        <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">
            @lang('web.Passenger')
        </th>
        <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">
            @lang('web.complaint')
        </th>
    </tr>
    </thead>
    <tbody>

    @foreach ($pd as $p)
        <tr>
            <td>{{\App\Models\User::find($p->driver_id)->full_name}}</td>
            <td>{{\App\Models\User::find($p->passenger_id)->full_name}}</td>
            <td>
                <div class="ratings">
                    {!! str_repeat('<span> <i class="fa fa-star rating-color"></i>', $p->rating_car) !!}
                    {!! str_repeat('<span><i class="fa fa-star"></i>', 5 - $p->rating_car) !!}
                </div>
            </td>
            <td>
                <div class="ratings">
                    <div class="ratings">
                        {!! str_repeat('<span> <i class="fa fa-star rating-color"></i>', $p->rating_time) !!}
                        {!! str_repeat('<span><i class="fa fa-star"></i>', 5 - $p->rating_time) !!}
                    </div>
                </div>
            </td>
            <td>
                <div class="ratings">
                    <div class="ratings">
                        {!! str_repeat('<span> <i class="fa fa-star rating-color"></i>', $p->rating_driver) !!}
                        {!! str_repeat('<span><i class="fa fa-star"></i>', 5 - $p->rating_driver) !!}
                    </div>
                </div>
            </td>
            <td>
                <div class="ratings">
                    <div class="ratings">
                        {!! str_repeat('<span> <i class="fa fa-star rating-color"></i>', $p->rating_passenger) !!}
                        {!! str_repeat('<span><i class="fa fa-star"></i>', 5 - $p->rating_passenger) !!}
                    </div>
                </div>
            </td>
            <td>
                @if($p->complaint)
                    <button id="show" data-id="{{$p->id}}"
                            class="btn btn-icon btn-outline btn-outline-dashed btn-outline-primary btn-active-dark-primary w-30px h-30px me-3"
                            data-bs-toggle="modal" data-bs-target="#kt_modal_show_complaint"><i
                            class="bi bi-eye"></i></button>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>

</html>


