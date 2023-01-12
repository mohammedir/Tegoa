@extends('layouts.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">@lang('web.Settings_list')</h1>
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
                    <li class="breadcrumb-item text-muted">@lang('web.Settings_Management')</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->

        </div>
        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Post-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xl">
            <!--begin::Card-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header mt-10">
                    <!--begin::Card title-->

                    <div id="kt_modal_edit_user" class="card-body pt-0 pb-6" style="padding:0px;">
                        <div id="kt_modal_edit_user_form" data-kt-redirect="">
                            <!--begin::Scroll-->
                            <div id="kt_modal_edit_user_scroll">
                                <form id="kt_modal_edit_user_only">
                                    <!--begin::Input group-->
                                    <div class="row">
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label
                                                class="required fw-bold fs-6 mb-2">{{ __('web.public_price_per_km') }}
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input id="public_price" type="number" name="public_price" @if(\Illuminate\Support\Facades\App::getLocale() == "ar") style="direction: rtl;" @endif
                                                   class="form-control form-control-solid mb-3 mb-lg-0"
                                                   placeholder="{{ __('web.public_price_per_kmPlace') }}" value="{{$settings->public_price_per_km}}"
                                            >
                                            <strong id="public_price_error" class="errors text-danger"
                                                    role="alert">
                                            </strong>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label
                                                class="required fw-bold fs-6 mb-2">{{ __('web.private_price_per_km') }}</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input id="private_price" type="number" name="private_price"  @if(\Illuminate\Support\Facades\App::getLocale() == "ar") style="direction: rtl;" @endif
                                                   class="form-control form-control-solid mb-3 mb-lg-0"
                                                   placeholder="{{ __('web.private_price_per_kmPlace') }}" value="{{$settings->private_price_per_km}}"
                                            >
                                            <strong id="private_price_error" class="errors text-danger"
                                                    role="alert">
                                            </strong>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label
                                                class="required fw-bold fs-6 mb-2">{{ __('web.License') }}</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input id="key" type="text" name="key"
                                                   class="form-control form-control-solid"
                                                   placeholder="{{ __('web.keyEnter') }}" value="{{$settings->map_key}}"
                                            >
                                            <strong id="key_error" class="errors text-danger"
                                                    role="alert">
                                            </strong>
                                            <!--end::Input-->
                                        </div>

                                    </div>
                                    <!--end::Scroll-->
                                </form>

                            </div>
                            <!--end::Card body-->
                            <!--end:::Tab content-->
                            <!--end::Content-->
                        </div>
                        <!--begin::Actions-->
                        @can('settings_edit')
                        <div class="d-flex justify-content-end">
                            <button id="kt_modal_update_user_submit" class="btn btn-primary">
                                <span class="indicator-label">{{ __('web.Submit') }}</span>
                                <span class="indicator-progress">{{ __('web.Please wait...') }}
												<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        @endcan

                        <!--end::Actions-->
                        <!--end::Layout-->
                        <!--begin::Modals-->
                        <!--begin::Modal - Update user details-->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>const language = $('#language').val();</script>
    <script src="{{ asset('pages/js/admin-management/settings/edit_settings.js') }}" defer></script>

@endsection

