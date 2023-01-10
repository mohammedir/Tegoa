@extends('layouts.master')
@section('content')
    <style>
        #file-chosens {
            margin-left: 0.3rem;
            font-family: sans-serif;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">@lang('web.places_list')</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a
                            class="text-muted text-hover-primary">@lang('web.Home')</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">@lang('web.Places_Management')</li>
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
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Button-->
                        <button type="button" class="btn btn-light-primary addNew" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_add_places"  onclick="showlocation()">
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
                            <!--end::Svg Icon-->@lang('web.Add_place')</button>
                        <!--end::Button-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="kt_places_table">
                        <!--begin::Table head-->
                        <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">@lang('web.place')</th>
                            <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">@lang('web.description')</th>
                            <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">@lang('web.address')</th>
                            <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">@lang('web.map')</th>
                            <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">@lang('web.type')</th>
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
            <div class="modal fade" id="kt_modal_add_places" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2 class="fw-bold">@lang('web.Add_place')</h2>
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
                            <!--begin::Form-->
                            <form id="kt_modal_add_places_form" class="form" action="#" enctype="multipart/form-data">
                                @csrf
                                <div class="d-flex flex-column scroll-y me-n7 pe-7"
                                     id="kt_modal_detail_car_scroll" data-kt-scroll="true"
                                     data-kt-scroll-activate="{default: false, lg: true}"
                                     data-kt-scroll-max-height="auto"
                                     data-kt-scroll-dependencies="#kt_modal_detail_car_header"
                                     data-kt-scroll-wrappers="#kt_modal_detail_car_scroll"
                                     data-kt-scroll-offset="300px">
                                    <!--begin::Input group-->
                                    <div class="row">
                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span class="required">@lang('web.name') (@lang('web.english'))</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input id="name_en" type="text" class="form-control form-control-solid"
                                                   placeholder="@lang('web.nameEnter')" name="name_en">
                                            <strong id="name_en_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>

                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span class="required">@lang('web.name') (@lang('web.arabic'))</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input id="name_ar" type="text" class="form-control form-control-solid"
                                                   placeholder="@lang('web.nameEnter')" name="name_ar">
                                            <strong id="name_ar_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span
                                                    class="required">@lang('web.description') (@lang('web.english'))</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <textarea id="description_en" type="text"
                                                      class="form-control form-control-solid"
                                                      placeholder="@lang('web.descriptionPlaceEnter')"
                                                      name="description_en"></textarea>
                                            <strong id="description_en_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>

                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span
                                                    class="required">@lang('web.description') (@lang('web.arabic'))</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <textarea id="description_ar" type="text"
                                                      class="form-control form-control-solid"
                                                      placeholder="@lang('web.descriptionEnter')"
                                                      name="description_ar"></textarea>
                                            <strong id="description_ar_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span
                                                    class="required">@lang('web.address') (@lang('web.english'))</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input id="address_en" type="text"
                                                   class="form-control form-control-solid"
                                                   placeholder="@lang('web.addressEnter')"
                                                   name="address_en">
                                            <strong id="address_en_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>

                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span
                                                    class="required">@lang('web.address') (@lang('web.arabic'))</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input id="address_ar" type="text"
                                                   class="form-control form-control-solid"
                                                   placeholder="@lang('web.addressEnter')"
                                                   name="address_ar">
                                            <strong id="address_ar_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span class="required">@lang('web.type')</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select id="type" name="type" class="form-select form-select-solid">
                                                @foreach(\App\Models\Place::type as $type)
                                                    <option value="{{$type}}">
                                                        @if($type == 1)
                                                            @lang('web.places')
                                                        @elseif($type == 2)
                                                            @lang('web.tourism sites')
                                                        @else
                                                            @lang('web.stations')
                                                        @endif
                                                    </option>
                                                @endforeach

                                            </select>
                                            <strong id="type_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>

                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span class="required">@lang('web.PhotosNews')</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.Allowed file types: png, jpg, jpeg.')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->


                                            <!--begin::Input-->

                                            <input type="file" id="fileupload" name="fileupload[]"
                                                   accept="image/png, image/jpg, image/jpeg"
                                                   hidden/>

                                            @if(\Illuminate\Support\Facades\App::getLocale() == "en")
                                                <label for="fileupload"
                                                       class="form-control form-control-solid"
                                                       style="color :#999595FF">Choose File: <span
                                                        id="file-chosen-input"
                                                        style="color: #5a6268">    No file chosen</span></label>
                                            @else
                                                <label for="fileupload"
                                                       class="form-control form-control-solid"
                                                       style="color: #999595FF;">اختر ملف : <span
                                                        id="file-chosen-input" style="color: #5a6268">    لم يتم اختيار ملف     </span></label>
                                            @endif
                                            <!--end::Input-->
                                            <strong id="fileupload_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>

                                        <div class="fv-row col-md-4 mb-3">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mb-2">
                                                <span class="required">Lat</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->

                                            <input type="text" id="lat"
                                                   class="form-control form-control-solid"
                                                   name="lat">


                                            <!--end::Input-->
                                            <strong id="lat_error" class="errors text-danger"
                                                    role="alert"></strong>
                                        </div>

                                        <div class="fv-row col-md-4 mb-3">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mb-2">
                                                <span class="required">Long</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->

                                            <input type="text" id="long"
                                                   class="form-control form-control-solid"
                                                   name="long">

                                            <!--end::Input-->
                                            <strong id="long_error" class="errors text-danger"
                                                    role="alert"></strong>
                                        </div>

                                        <div class="fv-row col-sm-1 mb-3" style="padding-top: 28px;">

                                            <button type="button" class="btn btn-light-primary"
                                                    onclick="showlocation()">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                     fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                                    <path
                                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="fv-row col-sm-1 mb-3"
                                             style="padding-top: 28px; @if(\Illuminate\Support\Facades\App::getLocale() == "en") padding-left: 30px; @else padding-right: 30px; @endif">

                                            <button type="button" class="btn btn-light-success"
                                                    onclick="resetMap()">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                     fill="currentColor" class="bi bi-geo-fill" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                          d="M4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999zm2.493 8.574a.5.5 0 0 1-.411.575c-.712.118-1.28.295-1.655.493a1.319 1.319 0 0 0-.37.265.301.301 0 0 0-.057.09V14l.002.008a.147.147 0 0 0 .016.033.617.617 0 0 0 .145.15c.165.13.435.27.813.395.751.25 1.82.414 3.024.414s2.273-.163 3.024-.414c.378-.126.648-.265.813-.395a.619.619 0 0 0 .146-.15.148.148 0 0 0 .015-.033L12 14v-.004a.301.301 0 0 0-.057-.09 1.318 1.318 0 0 0-.37-.264c-.376-.198-.943-.375-1.655-.493a.5.5 0 1 1 .164-.986c.77.127 1.452.328 1.957.594C12.5 13 13 13.4 13 14c0 .426-.26.752-.544.977-.29.228-.68.413-1.116.558-.878.293-2.059.465-3.34.465-1.281 0-2.462-.172-3.34-.465-.436-.145-.826-.33-1.116-.558C3.26 14.752 3 14.426 3 14c0-.599.5-1 .961-1.243.505-.266 1.187-.467 1.957-.594a.5.5 0 0 1 .575.411z"/>
                                                </svg>
                                            </button>
                                        </div>


                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mb-2">
                                                <span class="">@lang('web.location')</span>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div id="map1"
                                                 style="width: 100%; height:400px;"></div>


                                            <!--end::Input-->
                                            <strong id="name_error" class="errors text-danger"
                                                    role="alert"></strong>

                                        </div>
                                    </div>
                                </div>

                                <!--end::Input group-->
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
            <div class="modal fade" id="kt_modal_update_places" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2 class="fw-bold">@lang('web.Edit_place_info')</h2>
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
                            <form id="kt_modal_update_places_form" class="form" action="#" enctype="multipart/form-data"
                                  style="font-size: 15px;">
                                @csrf
                                <div class="d-flex flex-column scroll-y me-n7 pe-7"
                                     id="kt_modal_detail_car_scroll" data-kt-scroll="true"
                                     data-kt-scroll-activate="{default: false, lg: true}"
                                     data-kt-scroll-max-height="auto"
                                     data-kt-scroll-dependencies="#kt_modal_detail_car_header"
                                     data-kt-scroll-wrappers="#kt_modal_detail_car_scroll"
                                     data-kt-scroll-offset="300px">
                                    <input type="hidden" name="place_edit_id" id="place_edit_id">
                                    <!--begin::Input group-->
                                    <div class="row">
                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span class="required">@lang('web.name') (@lang('web.english'))</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input id="name_en_edit" type="text"
                                                   class="form-control form-control-solid"
                                                   placeholder="@lang('web.nameEnter')"
                                                   name="name_en_edit">
                                            <strong id="name_en_edit_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>

                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span class="required">@lang('web.name') (@lang('web.arabic'))</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input id="name_ar_edit" type="text"
                                                   class="form-control form-control-solid"
                                                   placeholder="@lang('web.nameEnter')"
                                                   name="name_ar_edit">
                                            <strong id="name_ar_edit_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span
                                                    class="required">@lang('web.description') (@lang('web.english'))</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <textarea id="description_en_edit" type="text"
                                                      class="form-control form-control-solid"
                                                      placeholder="@lang('web.descriptionEnter')"
                                                      name="description_en_edit"></textarea>
                                            <strong id="description_en_edit_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>

                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span
                                                    class="required">@lang('web.description') (@lang('web.arabic'))</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <textarea id="description_ar_edit" type="text"
                                                      class="form-control form-control-solid"
                                                      placeholder="@lang('web.descriptionEnter')"
                                                      name="description_ar_edit"></textarea>
                                            <strong id="description_ar_edit_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span
                                                    class="required">@lang('web.address') (@lang('web.english'))</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input id="address_en_edit" type="text"
                                                   class="form-control form-control-solid"
                                                   placeholder="@lang('web.addressEnter')"
                                                   name="address_en_edit">
                                            <strong id="address_en_edit_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>

                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span
                                                    class="required">@lang('web.address') (@lang('web.arabic'))</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input id="address_ar_edit" type="text"
                                                   class="form-control form-control-solid"
                                                   placeholder="@lang('web.addressEnter')"
                                                   name="address_ar_edit">
                                            <strong id="address_ar_edit_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span class="required">@lang('web.type')</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select id="type_edit" name="type_edit"
                                                    class="form-select form-select-solid">
                                                @foreach(\App\Models\Place::type as $type)
                                                    <option value="{{$type}}">
                                                        @if($type == 1)
                                                            @lang('web.places')
                                                        @elseif($type == 2)
                                                            @lang('web.tourism sites')
                                                        @else
                                                            @lang('web.stations')
                                                        @endif
                                                    </option>
                                                @endforeach

                                            </select>
                                            <strong id="type_edit_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>

                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span>@lang('web.PhotosNews')</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.Allowed file types: png, jpg, jpeg.')"></i>
                                            </label>
                                            <!--end::Label-->

                                            <!--begin::Input-->

                                            <input type="file" id="fileuploads" name="fileuploads"
                                                   accept="image/png, image/jpg, image/jpeg"
                                                   hidden/>

                                            @if(\Illuminate\Support\Facades\App::getLocale() == "en")
                                                <label for="fileuploads"
                                                       class="form-control form-control-solid"
                                                       style="color :#999595FF">Choose File: <span
                                                        id="file-chosens"
                                                        style="color: #5a6268">    No file chosen</span></label>
                                            @else
                                                <label for="fileuploads"
                                                       class="form-control form-control-solid"
                                                       style="color: #999595FF;">اختر ملف : <span
                                                        id="file-chosens"
                                                        style="color: #5a6268">    لم يتم اختيار ملف     </span></label>
                                            @endif
                                            <!--end::Input-->
                                            <strong id="fileuploads_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="fv-row col-md-4 mb-3">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mb-2">
                                                <span class="required">Lat</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->

                                            <input type="text" id="lat_edit"
                                                   class="form-control form-control-solid"
                                                   name="lat_edit">


                                            <!--end::Input-->
                                            <strong id="lat_edit_error" class="errors text-danger"
                                                    role="alert"></strong>
                                        </div>

                                        <div class="fv-row col-md-4 mb-3">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mb-2">
                                                <span class="required">Long</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->

                                            <input type="text" id="long_edit"
                                                   class="form-control form-control-solid"
                                                   name="long_edit">

                                            <!--end::Input-->
                                            <strong id="long_edit_error" class="errors text-danger"
                                                    role="alert"></strong>
                                        </div>

                                        <div class="fv-row col-sm-1 mb-3" style="padding-top: 28px;">

                                            <button type="button" class="btn btn-light-primary"
                                                    onclick="initMaps()">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                     fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                                    <path
                                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                                </svg>
                                            </button>
                                        </div>


                                        <div class="fv-row col-sm-1 mb-3"
                                             style="padding-top: 28px; @if(\Illuminate\Support\Facades\App::getLocale() == "en") padding-left: 30px; @else padding-right: 30px; @endif">

                                            <button type="button" class="btn btn-light-success"
                                                    onclick="resetMaps()">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                     fill="currentColor" class="bi bi-geo-fill" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                          d="M4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999zm2.493 8.574a.5.5 0 0 1-.411.575c-.712.118-1.28.295-1.655.493a1.319 1.319 0 0 0-.37.265.301.301 0 0 0-.057.09V14l.002.008a.147.147 0 0 0 .016.033.617.617 0 0 0 .145.15c.165.13.435.27.813.395.751.25 1.82.414 3.024.414s2.273-.163 3.024-.414c.378-.126.648-.265.813-.395a.619.619 0 0 0 .146-.15.148.148 0 0 0 .015-.033L12 14v-.004a.301.301 0 0 0-.057-.09 1.318 1.318 0 0 0-.37-.264c-.376-.198-.943-.375-1.655-.493a.5.5 0 1 1 .164-.986c.77.127 1.452.328 1.957.594C12.5 13 13 13.4 13 14c0 .426-.26.752-.544.977-.29.228-.68.413-1.116.558-.878.293-2.059.465-3.34.465-1.281 0-2.462-.172-3.34-.465-.436-.145-.826-.33-1.116-.558C3.26 14.752 3 14.426 3 14c0-.599.5-1 .961-1.243.505-.266 1.187-.467 1.957-.594a.5.5 0 0 1 .575.411z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mb-2">
                                            <span class="">@lang('web.location')</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div id="map2"
                                             style="width: 100%; height:400px;"></div>


                                        <!--end::Input-->
                                        <strong id="name_error" class="errors text-danger"
                                                role="alert"></strong>

                                    </div>
                                </div>
                                <!--begin::Actions-->
                                <div class="text-center pt-15">
                                    <button type="reset" class="btn btn-light me-3"
                                            data-kt-permissions-modal-actions="cancel">@lang('web.Discard')</button>
                                    <button type="submit" class="btn btn-primary"
                                            data-kt-permissions-modal-actions="submit">
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
            <div class="modal fade" id="kt_modal_show_places" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2 class="fw-bold">@lang('web.Place_Details')</h2>
                            <!--end::Modal title-->
                            <!--begin::Close-->
                            <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                 id="cancel_modal">
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
                                    <input type="hidden" name="news_edit_id" id="news_edit_id">
                                    <!--begin::Input group-->
                                    <div class="row">
                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span style="font-weight: bold">@lang('web.name') (@lang('web.english')) :</span>
                                            </label>
                                            <br>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <span id="name_en_show"></span>
                                            <!--end::Input-->
                                        </div>

                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span style="font-weight: bold">@lang('web.name') (@lang('web.arabic')) :</span>
                                            </label>
                                            <br>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <span id="name_ar_show"></span>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span style="font-weight: bold">@lang('web.description') (@lang('web.english')) :</span>
                                            </label>
                                            <br>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <span id="description_en_show"></span>
                                            <!--end::Input-->
                                        </div>

                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span style="font-weight: bold">@lang('web.description') (@lang('web.arabic')) :</span>
                                            </label>
                                            <br>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <span id="description_ar_show"></span>
                                            <!--end::Input-->
                                        </div>

                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span style="font-weight: bold">@lang('web.address') (@lang('web.english')) :</span>
                                            </label>
                                            <br>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <span id="address_en_show"></span>
                                            <!--end::Input-->
                                        </div>

                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span style="font-weight: bold">@lang('web.address') (@lang('web.arabic')) :</span>
                                            </label>
                                            <br>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <span id="address_ar_show"></span>
                                            <!--end::Input-->
                                        </div>

                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span style="font-weight: bold">@lang('web.type') :</span>
                                            </label>
                                            <br>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <span id="type_show"></span>
                                            <!--end::Input-->
                                        </div>

                                    </div>
                                    <hr>

                                    <div class="row">

                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold form-label mb-2">
                                            <span style="font-weight: bold">@lang('web.PhotosNews') :</span>
                                        </label>
                                        <br>
                                        <br>
                                        <!--end::Label-->
                                        <!--begin::Input-->


                                        <!--begin::Input-->
                                        <div id="show_image_div">
                                            <span id="image_show"></span>

                                        </div>
                                        <!--end::Input-->
                                    </div>
                                </div>
                                <div class="text-center pt-15">
                                    <button type="button" class="btn btn-light me-3"
                                            id="close_modal">@lang('web.Discard')</button>
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

            <div class="modal fade" tabindex="-1" id="kt_modal_show_maps">
                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">@lang('web.location')</h5>

                            <!--begin::Close-->
                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                                 aria-label="Close">
                                <span class="svg-icon svg-icon-2x"></span>
                            </div>
                            <!--end::Close-->
                        </div>

                        <div class="modal-body">
                            <div class="fv-row mb-7">
                                <!--begin::Input-->
                                <div id="map3"
                                     style="width: 100%; height:400px;"></div>


                                <!--end::Input-->
                                <strong id="name_error" class="errors text-danger"
                                        role="alert"></strong>

                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('web.Discard')</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Modals-->
        </div>
        <!--end::Content container-->
        <input type="hidden" id="trans" value="{{trans('web.Selected')}}">
    </div>
    <!--end::Content-->
@endsection
@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" defer></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{asset('pages/js/admin-management/places/add-places.js')}}" defer></script>
    <script src="{{asset('pages/js/admin-management/places/edit-places.js')}}" defer></script>
    <script src="{{asset('pages/js/admin-management/places/list.js')}}" defer></script>
    <script src="{{asset('pages/js/admin-management/places/index.js')}}" defer></script>
    <script src="{{asset('assets/js/widgets.bundle.js')}}" defer></script>
    <script src="{{asset('assets/js/custom/widgets.js')}}" defer></script>
    <script src="{{asset('assets/js/custom/apps/chat/chat.js')}}" defer></script>
    <script src="{{asset('assets/js/custom/utilities/modals/upgrade-plan.js')}}" defer></script>
    <script src="{{asset('assets/js/custom/utilities/modals/create-app.js')}}" defer></script>
    <script src="{{asset('assets/js/custom/utilities/modals/users-search.js')}}" defer></script>
    <!--end::Custom Javascript-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSNQLhR2yEuFkYAoU_q4sXlvsd_8lOMBA&callback=initMap"
            async>
    </script>

    <script>
        const actualBtn = document.getElementById('fileupload');

        const fileChosen = document.getElementById('file-chosen-input');

        actualBtn.addEventListener('change', function () {
            fileChosen.textContent = this.files[0].name
        })

        const actualBtns = document.getElementById('fileuploads');

        const fileChosens = document.getElementById('file-chosens');

        actualBtns.addEventListener('change', function () {
            fileChosens.textContent = this.files[0].name
        })

    </script>

    <script>
        const
            language = $('#language').val(),
            app_url = $('#app_url').val();

        $(function () {

            $(document).on('click', '#close_modal', function () {
                $('#kt_modal_show_places').modal('hide');
            });
            $(document).on('click', '#cancel_modal', function () {
                $('#kt_modal_show_places').modal('hide');
            });
        });
    </script>

    <script>
        $(function () {
            $('body').on('click', '.addNew', function () {
                window.onload = showlocation();
            });
        });

        $(document).on('click', '#show', function () {
            let id = $(this).data('id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                url: "places/"+id,
                success: function (response) {
                    $("#name_en_show").html(response.place.name['en']);
                    $("#name_ar_show").html(response.place.name['ar']);
                    $("#description_en_show").html(response.place.description['en']);
                    $("#description_ar_show").html(response.place.description['ar']);
                    $("#address_en_show").html(response.place.address['en']);
                    $("#address_ar_show").html(response.place.address['ar']);
                    $("#type_show").html(response.type);
                    $('div#show_image_div').empty();
                    var img_carlicense = $('<img id="image_carlicense_id" style="max-width: 100%;max-height: 300px;">');
                    img_carlicense.attr('src', app_url + '/images/places/' + response.place.image);
                    img_carlicense.appendTo('#show_image_div');

                }
            });
        });

        $(document).on('click', '#showMap', function () {
            let id = $(this).data('id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                data: {id: id},
                url: "/get/map/",
                success: function (response) {
                    var lat = response.lat;
                    var lon = response.long;
                    var myLatlng = new google.maps.LatLng(lat, lon);
                    var mapOptions = {
                        zoom: 13,
                        center: myLatlng
                    }
                    var map = new google.maps.Map(document.getElementById("map3"), mapOptions);
                    var marker = new google.maps.Marker({
                        position: myLatlng,
                        draggable: false,
                    });
                    marker.setMap(map);
                    window.initMap = initMap;

                }
            });
        });

        let map, activeInfoWindow, markers = [];
        var marker;

        /* ----------------------------- Initialize Map ----------------------------- */
        function resetMap() {
            $("#lat").val('');
            $("#long").val('');
            showlocation();
        }

        function showlocation() {
            navigator.geolocation.getCurrentPosition(initMap);
        }

        function initMap(position) {
            if (document.getElementById("lat").value.length === 0) {
                var lat = parseFloat(position.coords.latitude);
                var lon = parseFloat(position.coords.longitude);
            } else {
                var lat = $('#lat').val();
                var lon = $('#long').val();
            }
            document.getElementById('lat').value = lat;
            document.getElementById('long').value = lon;
            var myLatlng = new google.maps.LatLng(lat, lon);
            var mapOptions = {
                zoom: 10,
                center: myLatlng
            }
            var map = new google.maps.Map(document.getElementById("map1"), mapOptions);
            var marker = new google.maps.Marker({
                position: myLatlng,
                draggable: true,
            });
            marker.setMap(map);
            window.initMap = initMap;
            map.addListener("click", function (event) {
                mapClicked(event);
            });
            marker.addListener("dragend", (event) => {
                $("#lat").val(event.latLng.lat());
                $("#long").val(event.latLng.lng());
            });
        }
    </script>
    <!--end::Javascript-->
    <script>
        function resetMaps() {
            $("#lat_edit").val('');
            $("#long_edit").val('');
            showlocations();
        }

        function showlocations() {
            navigator.geolocation.getCurrentPosition(initMaps);
        }

        function initMaps(position) {
            if (document.getElementById("lat_edit").value.length == 0) {
                var lat = parseFloat(position.coords.latitude);
                var lon = parseFloat(position.coords.longitude);
            } else {
                var lat = $('#lat_edit').val();
                var lon = $('#long_edit').val();
            }
            document.getElementById('lat_edit').value = lat;
            document.getElementById('long_edit').value = lon;
            var myLatlng = new google.maps.LatLng(lat, lon);
            var mapOptions = {
                zoom: 10,
                center: myLatlng
            }
            var map = new google.maps.Map(document.getElementById("map2"), mapOptions);
            var marker = new google.maps.Marker({
                position: myLatlng,
                draggable: true,
            });
            marker.setMap(map);
            window.initMap = initMap;
            map.addListener("click", function (event) {
                mapClicked(event);
            });
            marker.addListener("dragend", (event) => {
                $("#lat_edit").val(event.latLng.lat());
                $("#long_edit").val(event.latLng.lng());
            });
        }
    </script>

@endsection
