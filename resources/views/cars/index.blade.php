@extends('layouts.master')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <style>
        #block_container {
            width: 40%;
            padding: 20px;
            display: inline-block;
        }

        #block_containers {
            width: 50%;
            padding: 20px;
            display: inline-block;
        }

         #photos_edit {
             margin-left: 0.3rem;
             font-family: sans-serif;
         }


        /*.photos_show_edit {*/
        /*    position: relative;*/
        /*    width: 100%;*/
        /*    !*border: 2px solid blue;*!*/
        /*}*/
        /*img {*/
        /*    width: 100%;*/

        /*}*/
        /*.button1{*/
        /*    position: absolute;*/
        /*    !*padding: 16px;*!*/
        /*    !*background-color: green;*!*/
        /*    border-radius: 16px;*/
        /*    !*bottom: 10px;*!*/
        /*    left: 260px;*/
        /*    top: 20px;*/
        /*    !*box-sizing: border-box;*!*/

        /*    !*width: 100px;*!*/
        /*}*/

    </style>
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">@lang('web.Cars_List')</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="../../demo1/dist/index.html"
                           class="text-muted text-hover-primary">@lang('web.Home')</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">@lang('web.Cars_Management')</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->

        </div>
        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Card-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header mt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1 me-5">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
														<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
															<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                                                  height="2" rx="1"
                                                                  transform="rotate(45 17.0365 15.1223)"
                                                                  fill="currentColor"/>
															<path
                                                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                                fill="currentColor"/>
														</svg>
													</span>
                            <!--end::Svg Icon-->
                            <input type="text" data-kt-ecommerce-forms-filter="search"
                                   class="form-control form-control-solid w-250px ps-15"
                                   placeholder="@lang('web.Search')"/>
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->

                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="kt_cars_table">
                        <!--begin::Table head-->
                        <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">@lang('web.Driver')</th>
                            <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">@lang('web.Car_number')</th>
                            <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">@lang('web.Car_brand')</th>
                            <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">@lang('web.Car_insurance')</th>
                            <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">@lang('web.status')</th>
                            <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">@lang('web.others')</th>
                        </tr>
                        <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="fw-semibold text-gray-600">
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
            <!--begin::Modals-->
            <!--begin::Modal - Update permissions-->
            <div class="modal fade" id="kt_modal_update_car" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered w-500px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2 class="fw-bold">@lang('web.Edit_car_info')</h2>
                            <!--end::Modal title-->
                            <!--begin::Close-->
                            <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                 data-kt-permissions-modal-action="close">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                <span class="svg-icon svg-icon-1">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                                 xmlns="http://www.w3.org/2000/svg">
																<rect opacity="0.5" x="6" y="17.3137" width="16"
                                                                      height="2" rx="1"
                                                                      transform="rotate(-45 6 17.3137)"
                                                                      fill="currentColor"/>
																<rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                                      transform="rotate(45 7.41422 6)"
                                                                      fill="currentColor"/>
															</svg>
														</span>
                                <!--end::Svg Icon-->
                            </div>
                            <!--end::Close-->
                        </div>
                        <!--end::Modal header-->
                        <!--begin::Modal body-->
                        <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                            <!--begin::Notice-->
                            <!--end::Notice-->
                            <!--begin::Form-->
                            <form id="kt_modal_update_car_form" class="form" action="#" enctype="multipart/form-data" style="font-size: 15px;">
                                @csrf
                                <div class="d-flex flex-column scroll-y me-n7 pe-7"
                                     id="kt_modal_edit_event_scroll" data-kt-scroll="true"
                                     data-kt-scroll-activate="{default: false, lg: true}"
                                     data-kt-scroll-max-height="auto"
                                     data-kt-scroll-dependencies="#kt_modal_edit_event_header"
                                     data-kt-scroll-wrappers="#kt_modal_edit_event_scroll"
                                     data-kt-scroll-offset="300px">
                                    <input id="car_edit_id" type="hidden">
                                    <div class="fv-row col-12 mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold form-label mb-2">
                                            <span class="required">@lang('web.type')</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                               data-bs-trigger="hover" data-bs-html="true"
                                               data-bs-content="@lang('web.required')"></i>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select id="type_edit" class="form-select form-select-solid" name="type_edit">
                                            @foreach(\App\Models\Car::type as $type)
                                                <option value="{{$type}}">
                                                    @if($type == 1)
                                                        @lang('web.public')
                                                    @else
                                                        @lang('web.private')
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        <strong id="type_edit_error" class="errors text-danger"
                                                role="alert"></strong>
                                        <!--end::Input-->
                                    </div>

                                    <div class="fv-row col-12 mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold form-label mb-2">
                                            <span class="required">@lang('web.Car_number')</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                               data-bs-trigger="hover" data-bs-html="true"
                                               data-bs-content="@lang('web.required')"></i>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input id="number_edit" type="number" @if(\Illuminate\Support\Facades\App::getLocale() == "ar")  style="direction: rtl;" @endif class="form-control form-control-solid"
                                               placeholder="@lang('web.numberEnter')" name="number_edit"/>
                                        <strong id="number_edit_error" class="errors text-danger"
                                                role="alert"></strong>
                                        <!--end::Input-->
                                    </div>

                                    <div class="fv-row col-12 mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold form-label mb-2">
                                            <span class="required">@lang('web.Car_brand')</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                               data-bs-trigger="hover" data-bs-html="true"
                                               data-bs-content="@lang('web.required')"></i>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input id="brand_edit" class="form-control form-control-solid"
                                               placeholder="@lang('web.brandEnter')" name="brand_edit"/>
                                        <strong id="brand_edit_error" class="errors text-danger"
                                                role="alert"></strong>
                                        <!--end::Input-->
                                    </div>


                                    <div class="fv-row col-12 mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold form-label mb-2">
                                            <span class="required">@lang('web.Car_insurance')</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                               data-bs-trigger="hover" data-bs-html="true"
                                               data-bs-content="@lang('web.required')"></i>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input id="insurance_number_edit" type="number" @if(\Illuminate\Support\Facades\App::getLocale() == "ar")  style="direction: rtl;" @endif class="form-control form-control-solid"
                                               placeholder="@lang('web.insurance_numberEnter')"
                                               name="insurance_number_edit"/>
                                        <strong id="insurance_number_edit_error" class="errors text-danger"
                                                role="alert"></strong>
                                        <!--end::Input-->
                                    </div>

                                    <div class="fv-row col-12 mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold form-label mb-2">
                                            <span class="required">@lang('web.insurance_expiry_date')</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                               data-bs-trigger="hover" data-bs-html="true"
                                               data-bs-content="@lang('web.required')"></i>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="date" id="insurance_expiry_date_edit"
                                               class="form-control form-control-solid"
                                               placeholder="@lang('web.insurance_expiry_dateEnter')"
                                               name="insurance_expiry_date_edit"/>
                                        <strong id="insurance_expiry_date_edit_error" class="errors text-danger"
                                                role="alert"></strong>
                                        <!--end::Input-->
                                    </div>


                                    <div class="fv-row col-12 mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold form-label mb-2">
                                            <span>@lang('web.Photos')</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                               data-bs-trigger="hover" data-bs-html="true"
                                               data-bs-content="@lang('web.Allowed file types: png, jpg, jpeg.')"></i>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->


                                        <!--begin::Input-->

                                        <input type="file" id="photos_edit" name="photos_edit[]" accept="image/png, image/jpg, image/jpeg" multiple
                                               hidden/>

                                        @if(\Illuminate\Support\Facades\App::getLocale() == "en")
                                            <label for="photos_edit"
                                                   class="form-control form-control-solid"
                                                   style="color: CCCCCC">Choose File: <span
                                                    id="file-chosen" style="color: #5a6268">    No file chosen</span></label>
                                        @else
                                            <label for="photos_edit"
                                                   class="form-control form-control-solid"
                                                   style="color: white;">اختر ملف : <span
                                                    id="file-chosen" style="color: #5a6268">    لم يتم اختيار ملف     </span></label>
                                        @endif
                                        <!--end::Input-->
                                        <div class="photos_show_edit" id="photos_show_edit">

                                        </div>
                                        <strong id="passengers_insurance_error" class="errors text-danger"
                                                role="alert"></strong>
                                        <!--end::Input-->
                                    </div>
                                </div>
                                <!--begin::Actions-->
                                <div class="text-center pt-15">
                                    <button type="reset" class="btn btn-light me-3"
                                            data-kt-permissions-modal-action="cancel">@lang('web.Discard')</button>
                                    <button type="submit" class="btn btn-primary"
                                            data-kt-permissions-modal-action="submit">
                                        <span class="indicator-label">@lang('web.Submit')</span>
                                        <span class="indicator-progress">@lang('web.Please wait...')
																<span
                                                                    class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                                <!--end::Actions-->

                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Modal body-->
                    </div>
                    <!--end::Modal content-->
                </div>
                <!--end::Modal dialog-->
            </div>
            <!--end::Modal - Update permissions-->
            <!--begin::Modal - Update permissions-->
            <div class="modal fade" id="kt_modal_detail_car" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-600px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2 class="fw-bold">@lang('web.Car_Details')</h2>
                            <!--end::Modal title-->
                            <!--begin::Close-->
                            <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                 data-kt-permissions-modal-actions="close">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                <span class="svg-icon svg-icon-1">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                                 xmlns="http://www.w3.org/2000/svg">
																<rect opacity="0.5" x="6" y="17.3137" width="16"
                                                                      height="2" rx="1"
                                                                      transform="rotate(-45 6 17.3137)"
                                                                      fill="currentColor"/>
																<rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                                      transform="rotate(45 7.41422 6)"
                                                                      fill="currentColor"/>
															</svg>
														</span>
                                <!--end::Svg Icon-->
                            </div>
                            <!--end::Close-->
                        </div>
                        <!--end::Modal header-->
                        <!--begin::Modal body-->
                        <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                            <!--begin::Notice-->
                            <!--end::Notice-->
                            <!--begin::Form-->
                            <form id="kt_modal_detail_car_form" class="form" action="#" style="font-size: 15px;">
                                @csrf
                                <div class="d-flex flex-column scroll-y me-n7 pe-7"
                                     id="kt_modal_detail_car_scroll" data-kt-scroll="true"
                                     data-kt-scroll-activate="{default: false, lg: true}"
                                     data-kt-scroll-max-height="auto"
                                     data-kt-scroll-dependencies="#kt_modal_detail_car_header"
                                     data-kt-scroll-wrappers="#kt_modal_detail_car_scroll"
                                     data-kt-scroll-offset="300px">

                                    <input id="car_show_id" name="car_show_id" type="hidden">

                                    <!--begin::Input group-->
                                    <div class="row">
                                        <div id="block_containers">
                                            @lang('web.Driver')
                                        </div>
                                        <div id="block_container">
                                            <span id="user_show"></span>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div id="block_containers">
                                            @lang('web.Car_number')
                                        </div>
                                        <div id="block_container">
                                            <span id="number_show"></span>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div id="block_containers">
                                            @lang('web.Car_brand')
                                        </div>
                                        <div id="block_container">
                                            <span id="brand_show"></span>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div id="block_containers">
                                            @lang('web.Car_insurance')
                                        </div>
                                        <div id="block_container">
                                            <span id="insurance_number_show"></span>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div id="block_containers">
                                            @lang('web.type')
                                        </div>
                                        <div id="block_container">
                                            <span id="type_show"></span>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div id="block_containers">
                                            @lang('web.insurance_expiry_date')
                                        </div>
                                        <div id="block_container">
                                            <span id="insurance_expiry_date_show"></span>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div id="block_containers">
                                            @lang('web.Photos')
                                        </div>
                                        <div id="photos_show">

                                        </div>
                                    </div>
                                    <br>
                                    <hr>
                                    <div class="row">
                                        <div id="block_containers">
                                            @lang('web.Photos_license')
                                        </div>
                                        <div id="photos_carlicense_show">

                                        </div>
                                    </div>
                                    <br>
                                    <hr>
                                    <div class="row">
                                        <div id="block_containers">
                                            @lang('web.Photos_insurance')
                                        </div>
                                        <div id="photos_carinsurance_show">

                                        </div>
                                    </div>
                                    <br>
                                    <hr>
                                    <div class="row">
                                        <div id="block_containers">
                                            @lang('web.Photos_passengersinsurance')
                                        </div>
                                        <div id="photos_passengersinsurance_show">

                                        </div>
                                    </div>

                                    <!--end::Input group-->
                                    <!--begin::Actions-->
                                </div>
                                <div class="text-center pt-15">
                                    <button type="reset" class="btn btn-light me-3"
                                            data-kt-permissions-modal-actions="cancel">@lang('web.Decline')</button>
                                    <button type="submit" class="btn btn-primary"
                                            data-kt-permissions-modal-actions="submit">
                                        <span class="indicator-label">@lang('web.Accept')</span>
                                        <span class="indicator-progress">@lang('web.Please wait...')
																<span
                                                                    class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                                <!--end::Actions-->

                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Modal body-->
                    </div>
                    <!--end::Modal content-->
                </div>
                <!--end::Modal dialog-->
            </div>
            <!--end::Modal - Update permissions-->
            <!--end::Modals-->
        </div>
        <!--end::Content container-->
        <input type="hidden" id="trans" value="{{trans('web.Selected')}}">
    </div>
    <!--end::Content-->
@endsection
@section('js')
    <script>
        const trans = $('#trans').val();
        const actualBtn = document.getElementById('photos_edit');

        const fileChosen = document.getElementById('file-chosen');

        actualBtn.addEventListener('change', function () {
            fileChosen.textContent = trans;
        })

    </script>
    <script>const
            language = $('#language').val(),
            app_url = $('#app_url').val();</script>
    <script type="text/javascript">
        $(function () {

            $(document).on('click', '#show', function () {
                let id = $(this).data('id');
                $.ajax({
                    type: 'GET',
                    url: "/cars/" + id,
                    success: function (response) {
                        $("#car_show_id").html(response.car.id);
                        $("#number_show").html(response.car.car_number);
                        $("#brand_show").html(response.car.car_brand);
                        $("#insurance_number_show").html(response.car.insurance_number);
                        $("#insurance_expiry_date_show").html(response.car.insurance_expiry_date);
                        $("#type_show").html(response.type);
                        $("#user_show").html(response.user);
                        $('div#photos_show').empty();
                        $.each(response.image, function (index, value) {
                            var img = $('<img id="image_id" style="max-width: 400px;max-height: 300px;">');
                            img.attr('src', app_url + '/images/cars/' + value);
                            img.appendTo('#photos_show');
                        });
                        $('div#photos_carlicense_show').empty();
                        var img_carlicense = $('<img id="image_carlicense_id" style="max-width: 400px;max-height: 300px;">');
                        img_carlicense.attr('src', app_url + '/images/cars/' + response.car.carlicense);
                        img_carlicense.appendTo('#photos_carlicense_show');
                        $('div#photos_carinsurance_show').empty();
                        var img_carlicense = $('<img id="image_carlicense_id" style="max-width: 400px;max-height: 300px;">');
                        img_carlicense.attr('src', app_url + '/images/cars/' + response.car.carinsurance);
                        img_carlicense.appendTo('#photos_carinsurance_show');
                        $('div#photos_passengersinsurance_show').empty();
                        var img_carlicense = $('<img id="image_carlicense_id" style="max-width: 400px;max-height: 300px;">');
                        img_carlicense.attr('src', app_url + '/images/cars/' + response.car.passengersinsurance);
                        img_carlicense.appendTo('#photos_passengersinsurance_show');


                    },
                });

            });
        });
    </script>
    <script type="text/javascript">
        $(function () {

            $(document).on('click', '#edit', function () {
                let id = $(this).data('id');
                $.ajax({
                    type: 'GET',
                    url:  "/cars/" + id + "/edit",
                    success: function (response) {
                        $("#car_edit_id").html(response.car.id);
                        $("#number_edit").val(response.car.car_number);
                        $("#brand_edit").val(response.car.car_brand);
                        $("#insurance_number_edit").val(response.car.insurance_number);
                        $("#insurance_expiry_date_edit").val(response.car.insurance_expiry_date);
                        $("#type_edit").val(response.car.type);
                        $("#user_edit").val(response.user);
                        $('div#photos_show_edit').empty();
                        $.each(response.image, function (index, value) {
                            var img = $('<img class="btn" id="image_id" style="max-width: 400px;max-height: 300px;">');
                            var btn = $('<input type="hidden" id="id_image"><button type="button" class="btn btn-icon btn-circle btn-active-color-danger w-25px h-25px bg-body shadow"  id="button1"><i class="bi bi-trash"></i></button>');
                            img.attr('src', app_url + '/images/cars/' + value);
                            btn.attr('data-id', value);
                            img.appendTo('#photos_show_edit');
                            btn.appendTo('#photos_show_edit');
                        });


                    },
                });

            });
        });
    </script>

    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" defer></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{asset('pages/js/admin-management/cars/update-cars.js')}}" defer></script>
    <script src="{{asset('pages/js/admin-management/cars/edit-cars.js')}}" defer></script>
    <script src="{{asset('pages/js/admin-management/cars/list.js')}}" defer></script>
    <script src="{{asset('pages/js/admin-management/cars/index.js')}}" defer></script>
    <script src="{{asset('assets/js/widgets.bundle.js')}}" defer></script>
    <script src="{{asset('assets/js/custom/widgets.js')}}" defer></script>
    <script src="{{asset('assets/js/custom/apps/chat/chat.js')}}" defer></script>
    <script src="{{asset('assets/js/custom/utilities/modals/upgrade-plan.js')}}" defer></script>
    <script src="{{asset('assets/js/custom/utilities/modals/create-app.js')}}" defer></script>
    <script src="{{asset('assets/js/custom/utilities/modals/users-search.js')}}" defer></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
@endsection
