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
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">@lang('web.activities_list')</h1>
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
                    <li class="breadcrumb-item text-muted">@lang('web.activity_Management')</li>
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
                        <button type="button" class="btn btn-light-primary" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_add_activities">
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
                            <!--end::Svg Icon-->@lang('web.Add_activity')</button>
                        <!--end::Button-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="kt_activities_table">
                        <!--begin::Table head-->
                        <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">@lang('web.name')</th>
                            <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">@lang('web.description')</th>
                            <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">@lang('web.start_date')</th>
                            <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">@lang('web.end_date')</th>
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
            <div class="modal fade" id="kt_modal_add_activities" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2 class="fw-bold">@lang('web.Add_activity')</h2>
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
                            <form id="kt_modal_add_activities_form" class="form" action="#"
                                  enctype="multipart/form-data">
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
                                                   placeholder="@lang('web.nameActivityEnter')" name="name_en">
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
                                                   placeholder="@lang('web.nameActivityEnter')" name="name_ar">
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
                                                      placeholder="@lang('web.descriptionActivityEnter')"
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
                                                      placeholder="@lang('web.descriptionActivityEnter')"
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
                                                    class="required">@lang('web.required_tools') (@lang('web.english'))</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <textarea class="form-control form-control-solid" type="text"
                                                      id="required_tools_en" name="required_tools_en"
                                                      placeholder="@lang('web.required_toolsEnter')"></textarea>
                                            <strong id="required_tools_en_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>

                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span
                                                    class="required">@lang('web.required_tools') (@lang('web.arabic'))</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <textarea class="form-control form-control-solid" type="text"
                                                      id="required_tools_ar" name="required_tools_ar"
                                                      placeholder="@lang('web.required_toolsEnter')"></textarea>
                                            <strong id="required_tools_ar_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span
                                                    class="required">@lang('web.start_date')</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control form-control-solid" type="date" id="start_date"
                                                   name="start_date">
                                            <strong id="start_date_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>

                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span
                                                    class="required">@lang('web.end_date')</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control form-control-solid" type="date" id="end_date"
                                                   name="end_date">
                                            <strong id="end_date_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>
                                    </div>


                                    <div class="row">
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
                                            <input type="file" id="fileupload" name="fileupload"
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
            <div class="modal fade" id="kt_modal_update_activities" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2 class="fw-bold">@lang('web.Edit_avtivity_info')</h2>
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
                            <form id="kt_modal_update_activities_form" class="form" action="#"
                                  enctype="multipart/form-data"
                                  style="font-size: 15px;">
                                @csrf
                                <div class="d-flex flex-column scroll-y me-n7 pe-7"
                                     id="kt_modal_detail_car_scroll" data-kt-scroll="true"
                                     data-kt-scroll-activate="{default: false, lg: true}"
                                     data-kt-scroll-max-height="auto"
                                     data-kt-scroll-dependencies="#kt_modal_detail_car_header"
                                     data-kt-scroll-wrappers="#kt_modal_detail_car_scroll"
                                     data-kt-scroll-offset="300px">
                                    <input type="hidden" name="activities_edit_id" id="activities_edit_id">
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
                                            <input id="name_en_edit" type="text" class="form-control form-control-solid"
                                                   placeholder="@lang('web.nameActivityEnter')" name="name_en_edit">
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
                                            <input id="name_ar_edit" type="text" class="form-control form-control-solid"
                                                   placeholder="@lang('web.nameActivityEnter')" name="name_ar_edit">
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
                                                      placeholder="@lang('web.descriptionActivityEnter')"
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
                                                      placeholder="@lang('web.descriptionActivityEnter')"
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
                                                    class="required">@lang('web.required_tools') (@lang('web.english'))</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <textarea class="form-control form-control-solid" type="text"
                                                      id="required_tools_en_edit" name="required_tools_en_edit"
                                                      placeholder="@lang('web.required_toolsEnter')"></textarea>
                                            <strong id="required_tools_en_edit_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>

                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span
                                                    class="required">@lang('web.required_tools') (@lang('web.arabic'))</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <textarea class="form-control form-control-solid" type="text"
                                                      id="required_tools_ar_edit" name="required_tools_ar_edit"
                                                      placeholder="@lang('web.required_toolsEnter')"></textarea>
                                            <strong id="required_tools_ar_edit_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span
                                                    class="required">@lang('web.start_date')</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control form-control-solid" type="date"
                                                   id="start_date_edit" name="start_date_edit">
                                            <strong id="start_date_edit_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>

                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span
                                                    class="required">@lang('web.end_date')</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control form-control-solid" type="date"
                                                   id="end_date_edit" name="end_date_edit">
                                            <strong id="end_date_edit_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>
                                    </div>

                                    <div class="row">
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
            <div class="modal fade" id="kt_modal_show_activities" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2 class="fw-bold">@lang('web.Activity_Details')</h2>
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
                            <form id="kt_modal_detail_tour_form" class="form" action="#" style="font-size: 15px;">
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
                                                <span>@lang('web.name') (@lang('web.english'))</span>
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
                                                <span>@lang('web.name') (@lang('web.arabic'))</span>
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
                                                <span>@lang('web.description') (@lang('web.english'))</span>
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
                                                <span>@lang('web.description') (@lang('web.arabic'))</span>
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
                                                <span>@lang('web.required_tools') (@lang('web.english'))</span>
                                            </label>
                                            <br>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <span id="required_tools_en_show"></span>
                                            <!--end::Input-->
                                        </div>

                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span>@lang('web.required_tools') (@lang('web.arabic'))</span>
                                            </label>
                                            <br>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <span id="required_tools_ar_show"></span>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span>@lang('web.start_date')</span>
                                            </label>
                                            <br>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <span id="start_date_show"></span>
                                            <!--end::Input-->
                                        </div>

                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span>@lang('web.end_date')</span>
                                            </label>
                                            <br>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <span id="end_date_show"></span>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span>@lang('web.PhotosNews')</span>
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
                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span
                                                >@lang('web.status')</span>
                                            </label>
                                            <br>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <span id="status_show"></span>
                                            <!--end::Input-->
                                        </div>
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
        function getStatusEmergency(el) {
            var id = el.id;
            var isChecked = el.checked;
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '/changeStatus/activities/',
                data: {id: id, isChecked: isChecked},
                success: function (data) {
                    Swal.fire(
                        '@lang('web.Status changed successfully')',
                        '',
                        'success'
                    )
                }
            });
        }
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
                $('#kt_modal_show_activities').modal('hide');
            });
            $(document).on('click', '#cancel_modal', function () {
                $('#kt_modal_show_activities').modal('hide');
            });
        });
    </script>
    <script>
        $(function () {
            $(document).on('click', '#show', function () {
                let id = $(this).data('id');
                $.ajax({
                    type: 'GET',
                    url: "/activities/" + id,
                    success: function (response) {
                        $("#name_en_show").html(response.activity.name['en']);
                        $("#name_ar_show").html(response.activity.name['ar']);
                        $("#description_en_show").html(response.activity.description['en']);
                        $("#description_ar_show").html(response.activity.description['ar']);
                        $("#required_tools_en_show").html(response.activity.required_tools['en']);
                        $("#required_tools_ar_show").html(response.activity.required_tools['ar']);
                        $("#start_date_show").html(response.activity.start_date);
                        $("#end_date_show").html(response.activity.end_date);
                        $("#status_show").html(response.status);
                        $('div#show_image_div').empty();
                        var img_carlicense = $('<img id="image_carlicense_id" style="max-width: 100%;max-height: 300px;">');
                        img_carlicense.attr('src', app_url + '/images/activities/' + response.activity.image);
                        img_carlicense.appendTo('#show_image_div');
                    },
                });

            });
        });

    </script>
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" defer></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{asset('pages/js/admin-management/activities/add-activities.js')}}" defer></script>
    <script src="{{asset('pages/js/admin-management/activities/edit-activities.js')}}" defer></script>
    <script src="{{asset('pages/js/admin-management/activities/list.js')}}" defer></script>
    <script src="{{asset('pages/js/admin-management/activities/index.js')}}" defer></script>
    <script src="{{asset('assets/js/widgets.bundle.js')}}" defer></script>
    <script src="{{asset('assets/js/custom/widgets.js')}}" defer></script>
    <script src="{{asset('assets/js/custom/apps/chat/chat.js')}}" defer></script>
    <script src="{{asset('assets/js/custom/utilities/modals/upgrade-plan.js')}}" defer></script>
    <script src="{{asset('assets/js/custom/utilities/modals/create-app.js')}}" defer></script>
    <script src="{{asset('assets/js/custom/utilities/modals/users-search.js')}}" defer></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
@endsection
