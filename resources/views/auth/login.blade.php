<!DOCTYPE html>
<html @if(App::getLocale() == 'en') lang="en" dir="ltr" @else lang="ar" dir="rtl" @endif>
<!--begin::Head-->
<head><base href="../../../">
    <title>Tuqu' Municipality Login</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <link rel="shortcut icon" href="{{asset('images/logo_n.jpg')}}" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    @if(App::getLocale() == 'ar')
        <link href="{{asset('assets/css/style.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/plugins/global/plugins.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
        <style>
            div.dataTables_wrapper div.dataTables_length {
                padding-left: 10px;
            }
        </style>
    @else
        <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
        <link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
        <!--end::Global Stylesheets Bundle-->
    @endif
    <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="bg-dark">
<!--begin::Main-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root" style="background-color: #312e2e">
    <!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url({{asset('assets/media/illustrations/sketchy-1/14-dark.png')}}">
        <!--begin::Content-->
        <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
            <!--begin::Logo-->
            <a class="mb-12">
                <img alt="Logo" src="{{asset('images/logo_n.jpg')}}" class="h-75px" />
            </a>
            <!--end::Logo-->
            <!--begin::Wrapper-->
            <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                <!--begin::Form-->
                <form class="form w-100" novalidate="novalidate" {{--id="kt_sign_in_form"--}} method="POST" action="{{ route('login') }}">
                    @csrf
                     <!--begin::Heading-->
                    <div class="text-center mb-10">
                        <!--begin::Title-->
                        <h1 class="text-dark mb-3">@lang('login.Sign In to Tegoa')</h1>
                        <!--end::Title-->
                    </div>
                    @if ($errors->any())
                        <!--begin::Alert-->
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach ($errors->all() as $error) {{ $error }}<br> @endforeach
                        </div>

                    @endif
                    <!--begin::Heading-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="form-label fs-6 fw-bolder text-dark">@lang('login.email')</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-lg form-control-solid" type="text" name="email" placeholder="@lang('web.emaillEnter')" autocomplete="off" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack mb-2">
                            <!--begin::Label-->
                            <label class="form-label fw-bolder text-dark fs-6 mb-0">@lang('login.password')</label>
                            <!--end::Label-->
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Input-->
                        <input class="form-control form-control-lg form-control-solid" type="password" name="password" placeholder="@lang('web.passwordEnter')" autocomplete="off" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Actions-->
                    <div class="text-center">
                        <!--begin::Submit button-->
                        <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                            <span class="indicator-label">@lang('login.login')</span>
                            <span class="indicator-progress">@lang('login.Please wait...')
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <!--end::Submit button-->
                    </div>
                    <!--end::Actions-->
                    <!--begin::Footer-->
                     <div class="d-flex flex-center flex-column-auto p-10">
                            <!--begin::Links-->
                            <div class="d-flex align-items-center fw-bold fs-6">
                                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        <a class="text-muted text-hover-primary px-2" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                            {{ $properties['native'] }}
                                        </a>
                                @endforeach
                            </div>
                            <!--end::Links-->
                        </div>
                    <!--end::Footer-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Authentication - Sign-in-->
</div>
<!--end::Root-->
<!--end::Main-->
<!--begin::Javascript-->
<script>var hostUrl = "assets/";</script>
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Page Custom Javascript(used by this page)-->
{{--<script src="assets/js/custom/authentication/sign-in/general.js"></script>--}}
<!--end::Page Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>
