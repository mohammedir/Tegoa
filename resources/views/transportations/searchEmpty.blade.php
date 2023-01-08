<table class="table align-middle table-row-dashed fs-6 gy-5 mb-0 Table1" id="Table1">
    <!--begin::Table head-->
    <thead>
    <!--begin::Table row-->
    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
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
    <!--end::Table row-->
    </thead>
    <!--end::Table head-->
    <!--begin::Table body-->
    <tbody class="fw-semibold text-gray-600">
    @if(count($transportations_alls))
    @foreach($transportations_alls as $transportation)
        <tr>
            <td>{{\App\Models\User::find($transportation->driver_id)->full_name}}</td>
            <td>{{\App\Models\User::find($transportation->passenger_id)->full_name}}</td>
            <td>
                <div class="ratings">
                    {!! str_repeat('<span> <i class="fa fa-star rating-color"></i>', $transportation->rating_car) !!}
                    {!! str_repeat('<span><i class="fa fa-star"></i>', 5 - $transportation->rating_car) !!}
                </div>
            </td>
            <td>
                <div class="ratings">
                    <div class="ratings">
                        {!! str_repeat('<span> <i class="fa fa-star rating-color"></i>', $transportation->rating_time) !!}
                        {!! str_repeat('<span><i class="fa fa-star"></i>', 5 - $transportation->rating_time) !!}
                    </div>
                </div>
            </td>
            <td>
                <div class="ratings">
                    <div class="ratings">
                        {!! str_repeat('<span> <i class="fa fa-star rating-color"></i>', $transportation->rating_driver) !!}
                        {!! str_repeat('<span><i class="fa fa-star"></i>', 5 - $transportation->rating_driver) !!}
                    </div>
                </div>
            </td>
            <td>
                <div class="ratings">
                    <div class="ratings">
                        {!! str_repeat('<span> <i class="fa fa-star rating-color"></i>', $transportation->rating_passenger) !!}
                        {!! str_repeat('<span><i class="fa fa-star"></i>', 5 - $transportation->rating_passenger) !!}
                    </div>
                </div>
            </td>
            <td>
                @if($transportation->complaint)
                    <button id="show" data-id="{{$transportation->id}}"
                            class="btn btn-icon btn-outline btn-outline-dashed btn-outline-primary btn-active-dark-primary w-30px h-30px me-3"
                            data-bs-toggle="modal" data-bs-target="#kt_modal_show_complaint"><i
                            class="bi bi-eye"></i></button>
                @endif
            </td>
        </tr>
    @endforeach
    @endif
    </tbody>

    <!--end::Table body-->
</table>
@if(count($transportations_alls))
<div class="links" id="links">{{$transportations_alls->links()}}</div>
@else
    <br>
    <span style="display: flex; justify-content: center">@lang('web.No data available in table')</span>
    <br>
@endif
