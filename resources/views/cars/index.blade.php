@extends('layouts.master')
@section('content')
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
                    <div class="card-toolbar">
                        <!--begin::Button-->
                        @can('places_create')
                            <button type="button" class="btn btn-light-primary addNew" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_add_car" id="save">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
                                <span class="svg-icon svg-icon-3">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
														<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5"
                                                              fill="currentColor"/>
														<rect x="10.8891" y="17.8033" width="12" height="2" rx="1"
                                                              transform="rotate(-90 10.8891 17.8033)"
                                                              fill="currentColor"/>
														<rect x="6.01041" y="10.9247" width="12" height="2" rx="1"
                                                              fill="currentColor"/>
													</svg>
												</span>
                                <!--end::Svg Icon-->@lang('web.Add_Car')
                            </button>
                        @endcan
                        <!--end::Button-->
                    </div>
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
                            <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">@lang('web.ID')</th>
                            <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">@lang('web.Driver')</th>
                            <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">@lang('web.Car_number')</th>
                            <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">@lang('web.Car_brand')</th>
                            <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">@lang('web.Car_insurance')</th>
                            <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">@lang('web.status')</th>
                            <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">@lang('web.verified')</th>
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
            <!--begin::Modal - create cars-->
            <div class="modal fade" id="kt_modal_add_car" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered w-500px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2 class="fw-bold">@lang('web.creat_car_info')</h2>
                            <!--end::Modal title-->
                            <!--begin::Close-->
                            <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                 data-kt-permissionss-modal-action="close">
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
                            <form id="kt_modal_add_car_form" class="form" action="#" enctype="multipart/form-data"
                                  style="font-size: 15px;">
                                @csrf
                                <div class="d-flex flex-column scroll-y me-n7 pe-7"
                                     id="kt_modal_edit_event_scroll" data-kt-scroll="true"
                                     data-kt-scroll-activate="{default: false, lg: true}"
                                     data-kt-scroll-max-height="auto"
                                     data-kt-scroll-dependencies="#kt_modal_edit_event_header"
                                     data-kt-scroll-wrappers="#kt_modal_edit_event_scroll"
                                     data-kt-scroll-offset="300px">
                                    <div class="fv-row col-12 mb-7">
                                        <!--begin::Block-->
                                        <div class="alert alert-warning d-flex align-items-center p-5 mb-10">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen048.svg-->
                                            <span class="svg-icon svg-icon-2hx svg-icon-warning me-4"><svg width="24"
                                                                                                           height="24"
                                                                                                           viewBox="0 0 24 24"
                                                                                                           fill="none"
                                                                                                           xmlns="http://www.w3.org/2000/svg">
<path opacity="0.3"
      d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z"
      fill="currentColor"/>
<path
    d="M10.5606 11.3042L9.57283 10.3018C9.28174 10.0065 8.80522 10.0065 8.51412 10.3018C8.22897 10.5912 8.22897 11.0559 8.51412 11.3452L10.4182 13.2773C10.8099 13.6747 11.451 13.6747 11.8427 13.2773L15.4859 9.58051C15.771 9.29117 15.771 8.82648 15.4859 8.53714C15.1948 8.24176 14.7183 8.24176 14.4272 8.53714L11.7002 11.3042C11.3869 11.6221 10.874 11.6221 10.5606 11.3042Z"
    fill="currentColor"/>
</svg>
</span>
                                            <!--end::Svg Icon-->
                                            <div class="d-flex flex-column">
                                                <h4 class="mb-1 text-warning">@lang('web.alert')</h4>
                                                <span>@lang('web.alert1')</span>
                                            </div>
                                        </div>
                                        <!--end::Svg Icon-->
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold form-label mb-2">
                                            <span class="required">@lang('web.driver')</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                               data-bs-trigger="hover" data-bs-html="true"
                                               data-bs-content="@lang('web.required')"></i>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select id="driver" class="form-select form-select-solid" name="driver">
                                            {{--                                            @foreach(\App\Models\User::all() as $user)--}}
                                            {{--                                                <option value="{{$user->id}}">--}}
                                            {{--                                                   {{$user->full_name}}--}}
                                            {{--                                                </option>--}}
                                            {{--                                            @endforeach--}}
                                        </select>
                                        <strong id="driver_error" class="errors text-danger"
                                                role="alert"></strong>
                                        <!--end::Input-->
                                    </div>

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
                                        <select id="type" class="form-select form-select-solid" name="type">
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
                                        <strong id="type_error" class="errors text-danger"
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
                                        <input id="number" type="text"
                                               @if(\Illuminate\Support\Facades\App::getLocale() == "ar")  style="direction: rtl;"
                                               @endif class="form-control form-control-solid"
                                               placeholder="@lang('web.numberEnter')" name="number"/>
                                        <strong id="number_error" class="errors text-danger"
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
                                        <input id="brand" class="form-control form-control-solid"
                                               placeholder="@lang('web.brandEnter')" name="brand"/>
                                        <strong id="brand_error" class="errors text-danger"
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
                                        <input id="insurance_number" type="text"
                                               @if(\Illuminate\Support\Facades\App::getLocale() == "ar")  style="direction: rtl;"
                                               @endif class="form-control form-control-solid"
                                               placeholder="@lang('web.insurance_numberEnter')"
                                               name="insurance_number"/>
                                        <strong id="insurance_number_error" class="errors text-danger"
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
                                        <input type="date" id="insurance_expiry_date_"
                                               @if(\Illuminate\Support\Facades\App::getLocale() == "ar") style="direction: rtl"
                                               @endif
                                               class="form-control form-control-solid"
                                               placeholder="@lang('web.insurance_expiry_dateEnter')"
                                               name="insurance_expiry_date"/>
                                        <strong id="insurance_expiry_date_error" class="errors text-danger"
                                                role="alert"></strong>
                                        <!--end::Input-->
                                    </div>


                                    <div class="fv-row col-12 mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold form-label mb-2">
                                            <span>@lang('web.Photos_cars')</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                               data-bs-trigger="hover" data-bs-html="true"
                                               data-bs-content="@lang('web.Allowed file types: png, jpg, jpeg.')"></i>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->


                                        <!--begin::Input-->

                                        <input type="file" id="photos" name="photos[]"
                                               accept="image/png, image/jpg, image/jpeg"
                                               hidden/>

                                        @if(\Illuminate\Support\Facades\App::getLocale() == "en")
                                            <label for="photos"
                                                   class="form-control form-control-solid"
                                                   style="color: #999595FF">Choose File: <span
                                                    id="file-chosens"
                                                    style="color: #5a6268">    No file chosen</span></label>
                                        @else
                                            <label for="photos"
                                                   class="form-control form-control-solid"
                                                   style="color: #999595FF;">اختر ملف : <span
                                                    id="file-chosens"
                                                    style="color: #5a6268">    لم يتم اختيار ملف     </span></label>
                                        @endif
                                        <!--end::Input-->
                                        <strong id="photos_error" class="errors text-danger"
                                                role="alert"></strong>
                                        <!--end::Input-->
                                    </div>

                                    <div class="fv-row col-12 mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold form-label mb-2">
                                            <span>@lang('web.Photo_carlicense')</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                               data-bs-trigger="hover" data-bs-html="true"
                                               data-bs-content="@lang('web.Allowed file types: png, jpg, jpeg.')"></i>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->


                                        <!--begin::Input-->

                                        <input type="file" id="photos_carlicense" name="photos_carlicense"
                                               accept="image/png, image/jpg, image/jpeg"
                                               hidden/>

                                        @if(\Illuminate\Support\Facades\App::getLocale() == "en")
                                            <label for="photos_carlicense"
                                                   class="form-control form-control-solid"
                                                   style="color: #999595FF">Choose File: <span
                                                    id="file-chosens_photos_carlicense" style="color: #5a6268">    No file chosen</span></label>
                                        @else
                                            <label for="photos_carlicense"
                                                   class="form-control form-control-solid"
                                                   style="color: #999595FF;">اختر ملف : <span
                                                    id="file-chosens_photos_carlicense" style="color: #5a6268">    لم يتم اختيار ملف     </span></label>
                                        @endif
                                        <!--end::Input-->
                                        <strong id="photos_carlicense_error" class="errors text-danger"
                                                role="alert"></strong>
                                        <!--end::Input-->
                                    </div>

                                    <div class="fv-row col-12 mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold form-label mb-2">
                                            <span>@lang('web.Photo_carinsurance')</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                               data-bs-trigger="hover" data-bs-html="true"
                                               data-bs-content="@lang('web.Allowed file types: png, jpg, jpeg.')"></i>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->


                                        <!--begin::Input-->

                                        <input type="file" id="photos_carinsurance" name="photos_carinsurance"
                                               accept="image/png, image/jpg, image/jpeg"
                                               hidden/>

                                        @if(\Illuminate\Support\Facades\App::getLocale() == "en")
                                            <label for="photos_carinsurance"
                                                   class="form-control form-control-solid"
                                                   style="color: #999595FF">Choose File: <span
                                                    id="file-chosens_photos_carinsurance" style="color: #5a6268">    No file chosen</span></label>
                                        @else
                                            <label for="photos_carinsurance"
                                                   class="form-control form-control-solid"
                                                   style="color: #999595FF;">اختر ملف : <span
                                                    id="file-chosens_photos_carinsurance" style="color: #5a6268">    لم يتم اختيار ملف     </span></label>
                                        @endif
                                        <!--end::Input-->
                                        <strong id="photos_carinsurance_error" class="errors text-danger"
                                                role="alert"></strong>
                                        <!--end::Input-->
                                    </div>

                                    <div class="fv-row col-12 mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold form-label mb-2">
                                            <span>@lang('web.Photo_passengersinsurance')</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                               data-bs-trigger="hover" data-bs-html="true"
                                               data-bs-content="@lang('web.Allowed file types: png, jpg, jpeg.')"></i>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->


                                        <!--begin::Input-->

                                        <input type="file" id="photos_passengersinsurance"
                                               name="photos_passengersinsurance"
                                               accept="image/png, image/jpg, image/jpeg"
                                               hidden/>

                                        @if(\Illuminate\Support\Facades\App::getLocale() == "en")
                                            <label for="photos_passengersinsurance"
                                                   class="form-control form-control-solid"
                                                   style="color: #999595FF">Choose File: <span
                                                    id="file-chosens_photos_passengersinsurance" style="color: #5a6268">    No file chosen</span></label>
                                        @else
                                            <label for="photos_passengersinsurance"
                                                   class="form-control form-control-solid"
                                                   style="color: #999595FF;">اختر ملف : <span
                                                    id="file-chosens_photos_passengersinsurance" style="color: #5a6268">    لم يتم اختيار ملف     </span></label>
                                        @endif
                                        <!--end::Input-->
                                        <strong id="photos_passengersinsurance_error" class="errors text-danger"
                                                role="alert"></strong>
                                        <!--end::Input-->
                                    </div>
                                </div>
                                <!--begin::Actions-->
                                <div class="text-center pt-15">
                                    <button type="reset" class="btn btn-light me-3"
                                            data-kt-permissionss-modal-action="cancel">@lang('web.Discard')</button>
                                    <button type="submit" class="btn btn-primary"
                                            data-kt-permissionss-modal-action="submit">
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
            <!--end::Modal - create cars-->
            <!--begin::Modal - Update cars-->
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
                            <form id="kt_modal_update_car_form" class="form" action="#" enctype="multipart/form-data"
                                  style="font-size: 15px;">
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
                                            <span class="required">@lang('web.status')</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                               data-bs-trigger="hover" data-bs-html="true"
                                               data-bs-content="@lang('web.required')"></i>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select id="status" class="form-select form-select-solid" name="status">
                                            @foreach(\App\Models\Car::Status as $status)
                                                <option value="{{$status}}">
                                                    @if($status == 0)
                                                        @lang('web.review')
                                                    @elseif($status == 1)
                                                        @lang('web.accepted')
                                                    @else
                                                        @lang('web.declined')
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
                                        <input id="number_edit" type="text"
                                               @if(\Illuminate\Support\Facades\App::getLocale() == "ar")  style="direction: rtl;"
                                               @endif class="form-control form-control-solid"
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
                                        <input id="insurance_number_edit" type="text"
                                               @if(\Illuminate\Support\Facades\App::getLocale() == "ar")  style="direction: rtl;"
                                               @endif class="form-control form-control-solid"
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
                                               @if(\Illuminate\Support\Facades\App::getLocale() == "ar") style="direction: rtl"
                                               @endif
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

                                        <input type="file" id="photos_edit" name="photos_edit"
                                               accept="image/png, image/jpg, image/jpeg"
                                               hidden/>

                                        @if(\Illuminate\Support\Facades\App::getLocale() == "en")
                                            <label for="photos_edit"
                                                   class="form-control form-control-solid"
                                                   style="color: #999595FF">Choose File: <span
                                                    id="file-chosen"
                                                    style="color: #5a6268">    No file chosen</span></label>
                                        @else
                                            <label for="photos_edit"
                                                   class="form-control form-control-solid"
                                                   style="color: #999595FF;">اختر ملف : <span
                                                    id="file-chosen"
                                                    style="color: #5a6268">    لم يتم اختيار ملف     </span></label>
                                        @endif
                                        <!--end::Input-->
                                        <div class="photos_show_edit" id="photos_show_edit">

                                        </div>
                                        <strong id="passengers_insurance_error" class="errors text-danger"
                                                role="alert"></strong>
                                        <!--end::Input-->
                                    </div>

                                    <div class="fv-row col-12 mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold form-label mb-2">
                                            <span>@lang('web.Photos_carlicense')</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                               data-bs-trigger="hover" data-bs-html="true"
                                               data-bs-content="@lang('web.Allowed file types: png, jpg, jpeg.')"></i>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->


                                        <!--begin::Input-->

                                        <input type="file" id="photos_carlicense_edit" name="photos_carlicense_edit"
                                               accept="image/png, image/jpg, image/jpeg"
                                               hidden/>

                                        @if(\Illuminate\Support\Facades\App::getLocale() == "en")
                                            <label for="photos_carlicense_edit"
                                                   class="form-control form-control-solid"
                                                   style="color: #999595FF">Choose File: <span
                                                    id="file-chosens_photos_carlicense_edit"
                                                    style="color: #5a6268">    No file chosen</span></label>
                                        @else
                                            <label for="photos_carlicense_edit"
                                                   class="form-control form-control-solid"
                                                   style="color: #999595FF;">اختر ملف : <span
                                                    id="file-chosens_photos_carlicense_edit"
                                                    style="color: #5a6268">    لم يتم اختيار ملف     </span></label>
                                        @endif
                                        <!--end::Input-->
                                        <div class="photos_show_photos_carlicense_edit" id="photos_show_photos_carlicense_edit">

                                        </div>
                                        <strong id="photos_carlicense_edit_error" class="errors text-danger"
                                                role="alert"></strong>
                                        <!--end::Input-->
                                    </div>

                                    <div class="fv-row col-12 mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold form-label mb-2">
                                            <span>@lang('web.Photos_carinsurance')</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                               data-bs-trigger="hover" data-bs-html="true"
                                               data-bs-content="@lang('web.Allowed file types: png, jpg, jpeg.')"></i>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->


                                        <!--begin::Input-->

                                        <input type="file" id="photos_carinsurance_edit" name="photos_carinsurance_edit"
                                               accept="image/png, image/jpg, image/jpeg"
                                               hidden/>

                                        @if(\Illuminate\Support\Facades\App::getLocale() == "en")
                                            <label for="photos_carinsurance_edit"
                                                   class="form-control form-control-solid"
                                                   style="color: #999595FF">Choose File: <span
                                                    id="file-chosens_photos_carinsurance_edit"
                                                    style="color: #5a6268">    No file chosen</span></label>
                                        @else
                                            <label for="photos_carinsurance_edit"
                                                   class="form-control form-control-solid"
                                                   style="color: #999595FF;">اختر ملف : <span
                                                    id="file-chosens_photos_carinsurance_edit"
                                                    style="color: #5a6268">    لم يتم اختيار ملف     </span></label>
                                        @endif
                                        <!--end::Input-->
                                        <div class="photos_show_photos_carinsurance_edit" id="photos_show_photos_carinsurance_edit">

                                        </div>
                                        <strong id="photos_carinsurance_edit_error" class="errors text-danger"
                                                role="alert"></strong>
                                        <!--end::Input-->
                                    </div>

                                    <div class="fv-row col-12 mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold form-label mb-2">
                                            <span>@lang('web.Photos_passengersinsurance')</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                               data-bs-trigger="hover" data-bs-html="true"
                                               data-bs-content="@lang('web.Allowed file types: png, jpg, jpeg.')"></i>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->


                                        <!--begin::Input-->

                                        <input type="file" id="photos_passengersinsurance_edit" name="photos_passengersinsurance_edit"
                                               accept="image/png, image/jpg, image/jpeg"
                                               hidden/>

                                        @if(\Illuminate\Support\Facades\App::getLocale() == "en")
                                            <label for="photos_passengersinsurance_edit"
                                                   class="form-control form-control-solid"
                                                   style="color: #999595FF">Choose File: <span
                                                    id="file-chosens_photos_passengersinsurance_edit"
                                                    style="color: #5a6268">    No file chosen</span></label>
                                        @else
                                            <label for="photos_passengersinsurance_edit"
                                                   class="form-control form-control-solid"
                                                   style="color: #999595FF;">اختر ملف : <span
                                                    id="file-chosens_photos_passengersinsurance_edit"
                                                    style="color: #5a6268">    لم يتم اختيار ملف     </span></label>
                                        @endif
                                        <!--end::Input-->
                                        <div class="photos_show_photos_passengersinsurance_edit" id="photos_show_photos_passengersinsurance_edit">

                                        </div>
                                        <strong id="photos_passengersinsurance_edit_error" class="errors text-danger"
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
            <!--end::Modal - Update cars-->
            <!--begin::Modal - show cars-->
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
            <!--end::Modal - show cars-->
            <!--end::Modals-->
        </div>
        <!--end::Content container-->
        <input type="hidden" id="trans" value="{{trans('web.Selected')}}">
    </div>
    <!--end::Content-->
@endsection
@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        const trans = $('#trans').val();
        const actualBtn = document.getElementById('photos_edit');

        const fileChosen = document.getElementById('file-chosen');

        actualBtn.addEventListener('change', function () {
            fileChosen.textContent = trans;
        })

        const actualBtns = document.getElementById('photos');

        const fileChosens = document.getElementById('file-chosens');

        actualBtns.addEventListener('change', function () {
            fileChosens.textContent = trans;
        })

        const actualBtnsss = document.getElementById('photos_carlicense');

        const fileChosensss = document.getElementById('file-chosens_photos_carlicense');

        actualBtnsss.addEventListener('change', function () {
            fileChosensss.textContent = trans;
        })

        const actualBtnssss = document.getElementById('photos_carinsurance');

        const fileChosenssss = document.getElementById('file-chosens_photos_carinsurance');

        actualBtnssss.addEventListener('change', function () {
            fileChosenssss.textContent = trans;
        })

        const actualBtnsssss = document.getElementById('photos_passengersinsurance');

        const fileChosensssss = document.getElementById('file-chosens_photos_passengersinsurance');

        actualBtnsssss.addEventListener('change', function () {
            fileChosensssss.textContent = trans;
        })

        const actualBtnssssss = document.getElementById('photos_carlicense_edit');

        const fileChosenssssss = document.getElementById('file-chosens_photos_carlicense_edit');

        actualBtnssssss.addEventListener('change', function () {
            fileChosenssssss.textContent = trans;
        })

        const actualBtnsssssss = document.getElementById('photos_carinsurance_edit');

        const fileChosensssssss = document.getElementById('file-chosens_photos_carinsurance_edit');

        actualBtnsssssss.addEventListener('change', function () {
            fileChosensssssss.textContent = trans;
        })

        const actualBtnssssssss = document.getElementById('photos_passengersinsurance_edit');

        const fileChosenssssssss = document.getElementById('file-chosens_photos_passengersinsurance_edit');

        actualBtnssssssss.addEventListener('change', function () {
            fileChosenssssssss.textContent = trans;
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
                        // $.each(response.image, function (index, value) {
                        //     var img = $('<img id="image_id" style="max-width: 400px;max-height: 300px;"><br>');
                        //     img.attr('src', app_url + '/images/cars/' + value);
                        //     img.appendTo('#photos_show');
                        // });

                        var img = $('<img id="image_id" style="max-width: 400px;max-height: 300px;"><br>');
                        img.attr('src', app_url + '/images/cars/' + response.image);
                        img.appendTo('#photos_show');


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
                    url: "/cars/" + id + "/edit",
                    success: function (response) {
                        $("#car_edit_id").html(response.car.id);
                        $("#number_edit").val(response.car.car_number);
                        $("#brand_edit").val(response.car.car_brand);
                        $("#insurance_number_edit").val(response.car.insurance_number);
                        $("#insurance_expiry_date_edit").val(response.car.insurance_expiry_date);
                        $("#type_edit").val(response.car.type);
                        $("#status").val(response.car.status);
                        $("#user_edit").val(response.user);
                        $('div#photos_show_edit').empty();
                        $('div#photos_show_photos_carlicense_edit').empty();
                        $('div#photos_show_photos_carinsurance_edit').empty();
                        $('div#photos_show_photos_passengersinsurance_edit').empty();
                        // $.each(response.image, function (index, value) {
                        //     var img = $('<br><img class="btn" id="image_id" style="max-width: 300px;max-height: 300px;">');
                        //     img.attr('src', app_url + '/images/cars/' + value);
                        //     img.appendTo('#photos_show_edit');
                        // });

                        var img = $('<br><img class="btn" id="image_id" style="max-width: 300px;max-height: 300px;">');
                        img.attr('src', app_url + '/images/cars/' + response.image);
                        img.appendTo('#photos_show_edit');

                            var imgs = $('<br><img class="btn" id="image_id" style="max-width: 300px;max-height: 300px;">');
                            imgs.attr('src', app_url + '/images/cars/' + response.car.carlicense);
                            imgs.appendTo('#photos_show_photos_carlicense_edit');

                            var imgss = $('<br><img class="btn" id="image_id" style="max-width: 300px;max-height: 300px;">');
                            imgss.attr('src', app_url + '/images/cars/' + response.car.carinsurance);
                            imgss.appendTo('#photos_show_photos_carinsurance_edit');

                            var imgsss = $('<br><img class="btn" id="image_id" style="max-width: 300px;max-height: 300px;">');
                            imgsss.attr('src', app_url + '/images/cars/' + response.car.passengersinsurance);
                            imgsss.appendTo('#photos_show_photos_passengersinsurance_edit');



                    },
                });

            });
        });
    </script>

    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" defer></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{asset('pages/js/admin-management/cars/add-cars.js')}}" defer></script>
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
