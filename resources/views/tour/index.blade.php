@extends('layouts.master')
@section('content')
    <style>
        #file-chosens {
            margin-left: 0.3rem;
            font-family: sans-serif;
        }
        @if(\Illuminate\Support\Facades\App::getLocale() == "ar")
            .select2-container--bootstrap5 .select2-selection--multiple:not(.form-select-sm):not(.form-select-lg) {
            direction: rtl;
        }
        .select2-container--bootstrap5 .select2-selection--multiple:not(.form-select-sm):not(.form-select-lg) .select2-selection__choice {
            direction: ltr;
        }
        @endif
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">@lang('web.tour_list')</h1>
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
                    <li class="breadcrumb-item text-muted">@lang('web.tour_Management')</li>
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
                        @can('tour_create')
                        <button type="button" class="btn btn-light-primary" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_add_tour">
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
                            <!--end::Svg Icon-->@lang('web.Add_Tour')
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
                    <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="kt_tours_table">
                        <!--begin::Table head-->
                        <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">@lang('web.ID')</th>
                            <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">@lang('web.name')</th>
                            <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">@lang('web.Email')</th>
                            <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">@lang('web.phone_number')</th>
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
            <div class="modal fade" id="kt_modal_add_tour" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2 class="fw-bold">@lang('web.Add_Tour')</h2>
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
                            <form id="kt_modal_add_tours_form" class="form" action="#" enctype="multipart/form-data">
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
                                                      placeholder="@lang('web.nameTourEnter')" name="name_en">
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
                                                      placeholder="@lang('web.nameTourEnter')" name="name_ar">
                                            <strong id="name_ar_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span class="required">@lang('web.address') (@lang('web.english'))</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input id="address_en" type="text" class="form-control form-control-solid"
                                                   placeholder="@lang('web.addressTourEnter')" name="address_en">
                                            <strong id="address_en_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>

                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span class="required">@lang('web.address') (@lang('web.arabic'))</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input id="address_ar" type="text" class="form-control form-control-solid"
                                                   placeholder="@lang('web.addressTourEnter')" name="address_ar">
                                            <strong id="address_ar_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span
                                                    class="required">@lang('web.gender')</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select id="gender" class="form-control form-control-solid" name="gender">
                                                <option value="1">@lang('web.Male')</option>
                                                <option value="2">@lang('web.Female')</option>
                                            </select>
                                            <strong id="gender_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>

                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span class="required">@lang('web.spoken_languages')</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select  id="spoken_languages" data-kt-select2="true" data-placeholder="@lang('web.selectSearch')" name="spoken_languages[]" class="form-select form-select-solid" multiple>
                                                <option value="English">English-إنجليزي</option>
                                                <option value="Arabic">Arabic-عربي</option>
                                                <option value="French">French-فرنسي</option>
                                                <option value="Dutch">Dutch-هولندي</option>
                                                <option value="Persian">Persian-الفارسية</option>
                                                <option value="Hebrew">Hebrew-العبرية</option>
                                                <option value="German">German-ألمانية</option>
                                                <option value="Japanese">Japanese-اليابانية</option>
                                                <option value="Chinese">Chinese-صينى</option>
                                                <option value="Latin">Latin-لاتيني</option>
                                                <option value="Western Frisian">Western Frisian-الفريزية الغربية</option>
                                                <option value="Vietnamese">Vietnamese-فيتنامي</option>
                                                <option value="Uzbek">Uzbek-أوزبكي</option>
                                                <option value="Uyghur">Uyghur-الأويغور</option>
                                                <option value="Albanian">Albanian-الألبانية</option>
                                                <option value="Amharic">Amharic-الأمهرية</option>
                                                <option value="Armenian">Armenian-أرميني</option>
                                                <option value="Azerbaijani">Azerbaijani-الأذربيجانية</option>
                                                <option value="Belarusian">Belarusian-البيلاروسية</option>
                                                <option value="Bengali">Bengali-البنغالية</option>
                                                <option value="Bosnian">Bosnian-البوسنية</option>
                                                <option value="Bulgarian">Bulgarian-البلغارية</option>
                                                <option value="Catalan">Catalan-الكاتالونية</option>
                                                <option value="Croatian">Croatian-الكرواتية</option>
                                                <option value="Czech">Czech-التشيكية</option>
                                                <option value="Danish">Danish-دانماركي</option>
                                                <option value="Filipino">Filipino-الفلبينية</option>
                                                <option value="Finnish">Finnish-الفنلندية</option>
                                                <option value="Galician">Galician-الجاليكية</option>
                                                <option value="Georgian">Georgian-الجورجية</option>
                                                <option value="Greek">Greek-اليونانية</option>
                                                <option value="Hawaiian">Hawaiian-هاواي</option>
                                                <option value="Hindi">Hindi-هندي</option>
                                                <option value="Hungarian">Hungarian-المجرية</option>
                                                <option value="Icelandic">Icelandic-الآيسلندية</option>
                                                <option value="Indonesian">Indonesian-الأندونيسية</option>
                                                <option value="Irish">Irish-إيرلندي</option>
                                                <option value="Italian">Italian-إيطالي</option>
                                                <option value="Kannada">Kannada-الكانادا</option>
                                                <option value="Kazakh">Kazakh-الكازاخستانية</option>
                                                <option value="Korean">Korean-الكورية</option>
                                                <option value="Kurdish">Kurdish-كردي</option>
                                                <option value="Kyrgyz">Kyrgyz-قيرغيزستان</option>
                                                <option value="Macedonian">Macedonian-المقدونية</option>
                                                <option value="Maltese">Maltese-المالطية</option>
                                                <option value="Mongolian">Mongolian-المنغولية</option>
                                                <option value="Nepali">Nepali-النيبالية</option>
                                                <option value="Norwegian">Norwegian-النرويجية</option>
                                                <option value="Portuguese">Portuguese-البرتغالية</option>
                                                <option value="Romanian">Romanian-روماني</option>
                                                <option value="Russian">Russian-الروسية</option>
                                                <option value="Scottish">Scottish-اسكتلندي</option>
                                                <option value="Serbian">Serbian-الصربية</option>
                                                <option value="Slovenian">Slovenian-السلوفينية</option>
                                                <option value="Somali">Somali-صومالي</option>
                                                <option value="Southern">Southern-الجنوب</option>
                                                <option value="Spanish">Spanish-الأسبانية</option>
                                                <option value="Swedish">Swedish-السويدية</option>
                                                <option value="Tajik">Tajik-طاجيك</option>
                                                <option value="Tatar">Tatar</option>
                                                <option value="Thai">Thai</option>
                                                <option value="Tigrinya">Tigrinya</option>
                                                <option value="Turkish">Turkish-التركية</option>
                                                <option value="Turkmen">Turkmen</option>
                                                <option value="Ukrainian">Ukrainian</option>
                                                <option value="Urdu">Urdu</option>
                                            </select>

                                            <strong id="spoken_languages_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span
                                                    class="required">@lang('web.Email')</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input id="email" type="email" @if(\Illuminate\Support\Facades\App::getLocale() == "ar") style="direction: rtl;" @endif
                                                      class="form-control form-control-solid"
                                                      placeholder="@lang('web.emailEnter')"
                                                      name="email">
                                            <strong id="email_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>

                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span
                                                    class="required">@lang('web.phone_number')</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input id="phone_number" type="number" @if(\Illuminate\Support\Facades\App::getLocale() == "ar") style="direction: rtl;" @endif
                                                      class="form-control form-control-solid"
                                                      placeholder="@lang('web.phone_numberEnter')"
                                                      name="phone_number">
                                            <strong id="phone_number_error" class="errors text-danger"
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
            <div class="modal fade" id="kt_modal_update_tours" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2 class="fw-bold">@lang('web.Edit_tour_info')</h2>
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
                            <form id="kt_modal_update_tours_form" class="form" action="#" enctype="multipart/form-data"
                                  style="font-size: 15px;">
                                @csrf
                                <div class="d-flex flex-column scroll-y me-n7 pe-7"
                                     id="kt_modal_detail_car_scroll" data-kt-scroll="true"
                                     data-kt-scroll-activate="{default: false, lg: true}"
                                     data-kt-scroll-max-height="auto"
                                     data-kt-scroll-dependencies="#kt_modal_detail_car_header"
                                     data-kt-scroll-wrappers="#kt_modal_detail_car_scroll"
                                     data-kt-scroll-offset="300px">
                                    <input type="hidden" name="tours_edit_id" id="tours_edit_id">
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
                                                   placeholder="@lang('web.nameTourEnter')" name="name_en_edit">
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
                                                   placeholder="@lang('web.nameTourEnter')" name="name_ar_edit">
                                            <strong id="name_ar_edit_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span class="required">@lang('web.address') (@lang('web.english'))</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input id="address_en_edit" type="text" class="form-control form-control-solid"
                                                   placeholder="@lang('web.addressTourEnter')" name="address_en_edit">
                                            <strong id="address_en_edit_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>

                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span class="required">@lang('web.address') (@lang('web.arabic'))</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input id="address_ar_edit" type="text" class="form-control form-control-solid"
                                                   placeholder="@lang('web.addressTourEnter')" name="address_ar_edit">
                                            <strong id="address_ar_edit_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span
                                                    class="required">@lang('web.gender')</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select id="gender_edit" class="form-control form-control-solid" name="gender_edit">
                                                <option value="1">@lang('web.Male')</option>
                                                <option value="2">@lang('web.Female')</option>
                                            </select>
                                            <strong id="gender_edit_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>

                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span class="required">@lang('web.spoken_languages')</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select  id="spoken_languages_edit" data-kt-select2="true" data-placeholder="@lang('web.selectSearch')" name="spoken_languages_edit[]" class="form-select form-select-solid" multiple>
                                                <option value="English">English-إنجليزي</option>
                                                <option value="Arabic">Arabic-عربي</option>
                                                <option value="French">French-فرنسي</option>
                                                <option value="Dutch">Dutch-هولندي</option>
                                                <option value="Persian">Persian-الفارسية</option>
                                                <option value="Hebrew">Hebrew-العبرية</option>
                                                <option value="German">German-ألمانية</option>
                                                <option value="Japanese">Japanese-اليابانية</option>
                                                <option value="Chinese">Chinese-صينى</option>
                                                <option value="Latin">Latin-لاتيني</option>
                                                <option value="Western Frisian">Western Frisian-الفريزية الغربية</option>
                                                <option value="Vietnamese">Vietnamese-فيتنامي</option>
                                                <option value="Uzbek">Uzbek-أوزبكي</option>
                                                <option value="Uyghur">Uyghur-الأويغور</option>
                                                <option value="Albanian">Albanian-الألبانية</option>
                                                <option value="Amharic">Amharic-الأمهرية</option>
                                                <option value="Armenian">Armenian-أرميني</option>
                                                <option value="Azerbaijani">Azerbaijani-الأذربيجانية</option>
                                                <option value="Belarusian">Belarusian-البيلاروسية</option>
                                                <option value="Bengali">Bengali-البنغالية</option>
                                                <option value="Bosnian">Bosnian-البوسنية</option>
                                                <option value="Bulgarian">Bulgarian-البلغارية</option>
                                                <option value="Catalan">Catalan-الكاتالونية</option>
                                                <option value="Croatian">Croatian-الكرواتية</option>
                                                <option value="Czech">Czech-التشيكية</option>
                                                <option value="Danish">Danish-دانماركي</option>
                                                <option value="Filipino">Filipino-الفلبينية</option>
                                                <option value="Finnish">Finnish-الفنلندية</option>
                                                <option value="Galician">Galician-الجاليكية</option>
                                                <option value="Georgian">Georgian-الجورجية</option>
                                                <option value="Greek">Greek-اليونانية</option>
                                                <option value="Hawaiian">Hawaiian-هاواي</option>
                                                <option value="Hindi">Hindi-هندي</option>
                                                <option value="Hungarian">Hungarian-المجرية</option>
                                                <option value="Icelandic">Icelandic-الآيسلندية</option>
                                                <option value="Indonesian">Indonesian-الأندونيسية</option>
                                                <option value="Irish">Irish-إيرلندي</option>
                                                <option value="Italian">Italian-إيطالي</option>
                                                <option value="Kannada">Kannada-الكانادا</option>
                                                <option value="Kazakh">Kazakh-الكازاخستانية</option>
                                                <option value="Korean">Korean-الكورية</option>
                                                <option value="Kurdish">Kurdish-كردي</option>
                                                <option value="Kyrgyz">Kyrgyz-قيرغيزستان</option>
                                                <option value="Macedonian">Macedonian-المقدونية</option>
                                                <option value="Maltese">Maltese-المالطية</option>
                                                <option value="Mongolian">Mongolian-المنغولية</option>
                                                <option value="Nepali">Nepali-النيبالية</option>
                                                <option value="Norwegian">Norwegian-النرويجية</option>
                                                <option value="Portuguese">Portuguese-البرتغالية</option>
                                                <option value="Romanian">Romanian-روماني</option>
                                                <option value="Russian">Russian-الروسية</option>
                                                <option value="Scottish">Scottish-اسكتلندي</option>
                                                <option value="Serbian">Serbian-الصربية</option>
                                                <option value="Slovenian">Slovenian-السلوفينية</option>
                                                <option value="Somali">Somali-صومالي</option>
                                                <option value="Southern">Southern-الجنوب</option>
                                                <option value="Spanish">Spanish-الأسبانية</option>
                                                <option value="Swedish">Swedish-السويدية</option>
                                                <option value="Tajik">Tajik-طاجيك</option>
                                                <option value="Tatar">Tatar</option>
                                                <option value="Thai">Thai</option>
                                                <option value="Tigrinya">Tigrinya</option>
                                                <option value="Turkish">Turkish-التركية</option>
                                                <option value="Turkmen">Turkmen</option>
                                                <option value="Ukrainian">Ukrainian</option>
                                                <option value="Urdu">Urdu</option>
                                            </select>

                                            <strong id="spoken_languages_edit_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span
                                                    class="required">@lang('web.Email')</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input id="email_edit" type="email" @if(\Illuminate\Support\Facades\App::getLocale() == "ar") style="direction: rtl;" @endif
                                            class="form-control form-control-solid"
                                                   placeholder="@lang('web.emailEnter')"
                                                   name="email_edit">
                                            <strong id="email_edit_error" class="errors text-danger"
                                                    role="alert"></strong>
                                            <!--end::Input-->
                                        </div>

                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span
                                                    class="required">@lang('web.phone_number')</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                   data-bs-trigger="hover" data-bs-html="true"
                                                   data-bs-content="@lang('web.required')"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input id="phone_number_edit" type="number" @if(\Illuminate\Support\Facades\App::getLocale() == "ar") style="direction: rtl;" @endif
                                            class="form-control form-control-solid"
                                                   placeholder="@lang('web.phone_numberEnter')"
                                                   name="phone_number_edit">
                                            <strong id="phone_number_edit_error" class="errors text-danger"
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
            <div class="modal fade" id="kt_modal_show_tour" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2 class="fw-bold">@lang('web.Tour_Details')</h2>
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
                                                <span style="font-weight: bold">@lang('web.status') :</span>
                                            </label>
                                            <br>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <span id="status_show"></span>
                                            <!--end::Input-->
                                        </div>

                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span style="font-weight: bold">@lang('web.spoken_languages') :</span>
                                            </label>
                                            <br>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select  id="spoken_languages_show" data-kt-select2="true" data-placeholder="" name="spoken_languages_show[]" class="form-select form-select-solid" disabled multiple>
                                                <option value="English">English-إنجليزي</option>
                                                <option value="Arabic">Arabic-عربي</option>
                                                <option value="French">French-فرنسي</option>
                                                <option value="Dutch">Dutch-هولندي</option>
                                                <option value="Persian">Persian-الفارسية</option>
                                                <option value="Hebrew">Hebrew-العبرية</option>
                                                <option value="German">German-ألمانية</option>
                                                <option value="Japanese">Japanese-اليابانية</option>
                                                <option value="Chinese">Chinese-صينى</option>
                                                <option value="Latin">Latin-لاتيني</option>
                                                <option value="Western Frisian">Western Frisian-الفريزية الغربية</option>
                                                <option value="Vietnamese">Vietnamese-فيتنامي</option>
                                                <option value="Uzbek">Uzbek-أوزبكي</option>
                                                <option value="Uyghur">Uyghur-الأويغور</option>
                                                <option value="Albanian">Albanian-الألبانية</option>
                                                <option value="Amharic">Amharic-الأمهرية</option>
                                                <option value="Armenian">Armenian-أرميني</option>
                                                <option value="Azerbaijani">Azerbaijani-الأذربيجانية</option>
                                                <option value="Belarusian">Belarusian-البيلاروسية</option>
                                                <option value="Bengali">Bengali-البنغالية</option>
                                                <option value="Bosnian">Bosnian-البوسنية</option>
                                                <option value="Bulgarian">Bulgarian-البلغارية</option>
                                                <option value="Catalan">Catalan-الكاتالونية</option>
                                                <option value="Croatian">Croatian-الكرواتية</option>
                                                <option value="Czech">Czech-التشيكية</option>
                                                <option value="Danish">Danish-دانماركي</option>
                                                <option value="Filipino">Filipino-الفلبينية</option>
                                                <option value="Finnish">Finnish-الفنلندية</option>
                                                <option value="Galician">Galician-الجاليكية</option>
                                                <option value="Georgian">Georgian-الجورجية</option>
                                                <option value="Greek">Greek-اليونانية</option>
                                                <option value="Hawaiian">Hawaiian-هاواي</option>
                                                <option value="Hindi">Hindi-هندي</option>
                                                <option value="Hungarian">Hungarian-المجرية</option>
                                                <option value="Icelandic">Icelandic-الآيسلندية</option>
                                                <option value="Indonesian">Indonesian-الأندونيسية</option>
                                                <option value="Irish">Irish-إيرلندي</option>
                                                <option value="Italian">Italian-إيطالي</option>
                                                <option value="Kannada">Kannada-الكانادا</option>
                                                <option value="Kazakh">Kazakh-الكازاخستانية</option>
                                                <option value="Korean">Korean-الكورية</option>
                                                <option value="Kurdish">Kurdish-كردي</option>
                                                <option value="Kyrgyz">Kyrgyz-قيرغيزستان</option>
                                                <option value="Macedonian">Macedonian-المقدونية</option>
                                                <option value="Maltese">Maltese-المالطية</option>
                                                <option value="Mongolian">Mongolian-المنغولية</option>
                                                <option value="Nepali">Nepali-النيبالية</option>
                                                <option value="Norwegian">Norwegian-النرويجية</option>
                                                <option value="Portuguese">Portuguese-البرتغالية</option>
                                                <option value="Romanian">Romanian-روماني</option>
                                                <option value="Russian">Russian-الروسية</option>
                                                <option value="Scottish">Scottish-اسكتلندي</option>
                                                <option value="Serbian">Serbian-الصربية</option>
                                                <option value="Slovenian">Slovenian-السلوفينية</option>
                                                <option value="Somali">Somali-صومالي</option>
                                                <option value="Southern">Southern-الجنوب</option>
                                                <option value="Spanish">Spanish-الأسبانية</option>
                                                <option value="Swedish">Swedish-السويدية</option>
                                                <option value="Tajik">Tajik-طاجيك</option>
                                                <option value="Tatar">Tatar</option>
                                                <option value="Thai">Thai</option>
                                                <option value="Tigrinya">Tigrinya</option>
                                                <option value="Turkish">Turkish-التركية</option>
                                                <option value="Turkmen">Turkmen</option>
                                                <option value="Ukrainian">Ukrainian</option>
                                                <option value="Urdu">Urdu</option>
                                            </select>

                                            <!--end::Input-->
                                        </div>

                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span style="font-weight: bold">@lang('web.gender') :</span>
                                            </label>
                                            <br>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <span id="gender_show"></span>
                                            <!--end::Input-->
                                        </div>

                                        <div class="fv-row col-md-6 mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span style="font-weight: bold">@lang('web.Email') :</span>
                                            </label>
                                            <br>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <span id="email_show"></span>
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
        function getStatus(el)
        {
            var id = el.id;
            var isChecked = el.checked;
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '/changeStatus/',
                data: {id:id,isChecked:isChecked},
                success: function(data){
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
                $('#kt_modal_show_tour').modal('hide');
            });
            $(document).on('click', '#cancel_modal', function () {
                $('#kt_modal_show_tour').modal('hide');
            });
        });
    </script>

    <script>
        $(function () {

            $(document).on('click', '#show', function () {
                let id = $(this).data('id');
                $.ajax({
                    type: 'GET',
                    url: "/tour/" + id,
                    success: function (response) {
                        $("#name_en_show").html(response.tour.full_name['en']);
                        $("#name_ar_show").html(response.tour.full_name['ar']);
                        $("#address_en_show").html(response.tour.address['en']);
                        $("#address_ar_show").html(response.tour.address['ar']);
                        $("#gender_show").html(response.gender);
                        $("#email_show").html(response.tour.email);
                        $("#status_show").html(response.status);
                        $("#phone_number_show").html(response.tour.address);
                        jQuery.each(response.spoken, function (index, item) {
                            $("#spoken_languages_show").val(item).trigger('change');
                        });
                        $('div#show_image_div').empty();
                        var img_carlicense = $('<img id="image_carlicense_id" style="max-width: 100%;max-height: 100%;">');
                        img_carlicense.attr('src', app_url + '/images/tours/' + response.tour.image);
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
    <script src="{{asset('pages/js/admin-management/tours/add-tours.js')}}" defer></script>
    <script src="{{asset('pages/js/admin-management/tours/edit-tours.js')}}" defer></script>
    <script src="{{asset('pages/js/admin-management/tours/list.js')}}" defer></script>
    <script src="{{asset('pages/js/admin-management/tours/index.js')}}" defer></script>
    <script src="{{asset('assets/js/widgets.bundle.js')}}" defer></script>
    <script src="{{asset('assets/js/custom/widgets.js')}}" defer></script>
    <script src="{{asset('assets/js/custom/apps/chat/chat.js')}}" defer></script>
    <script src="{{asset('assets/js/custom/utilities/modals/upgrade-plan.js')}}" defer></script>
    <script src="{{asset('assets/js/custom/utilities/modals/create-app.js')}}" defer></script>
    <script src="{{asset('assets/js/custom/utilities/modals/users-search.js')}}" defer></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
@endsection
