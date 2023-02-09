<!DOCTYPE html>
<html @if(App::getLocale() == 'en') lang="en" dir="ltr" @else lang="ar" dir="rtl" @endif>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
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
            @lang('web.status')
        </th>
        <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">
            @lang('web.complaint')
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach ($pd as $p)
        <tr>
            <td>@if($p->driver_id) {{getUserName($p->driver_id)}} @endif</td>
            <td>@if($p->passenger_id) {{getUserName($p->passenger_id)}} @endif</td>
            <td>
                <div class="ratings">
                    {{$p->rating_car}} star
                </div>
            </td>
            <td>
                <div class="ratings">
                    <div class="ratings">
                        {{$p->rating_time}} star
                    </div>
                </div>
            </td>
            <td>
                <div class="ratings">
                    <div class="ratings">
                        {{$p->rating_driver}} star
                    </div>
                </div>
            </td>
            <td>
                <div class="ratings">
                    <div class="ratings">
                        {{$p->rating_passenger}} star
                    </div>
                </div>
            </td>
            <td>
                @switch($transportation->status)
                    @case(1)
                        <span class="badge badge-secondary">{{getStatusAttribute($transportation->status)}}</span>
                        @break
                    @case(2)
                        <span class="badge badge-primary">{{getStatusAttribute($transportation->status)}}</span>
                        @break
                    @case(3)
                        <span class="badge badge-info">{{getStatusAttribute($transportation->status)}}</span>
                        @break
                    @case(4)
                        <span class="badge badge-success">{{getStatusAttribute($transportation->status)}}</span>
                        @break
                    @case(5)
                        <span class="badge badge-danger">{{getStatusAttribute($transportation->status)}}</span>
                        @break
                    @default
                        {{$transportation->status}}
                @endswitch
            </td>
            <td>
                @if($p->complaint)
                    {{$p->complaint}}
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
<script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>

</html>


