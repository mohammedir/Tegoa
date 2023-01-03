{{--
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
--}}
@extends('layouts.master')
@section('content')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Default</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">Dashboards</li>
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
        <div id="kt_app_content_container" class="app-container container-fluid">

        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
@endsection
@section('js')
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="{{asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js')}}" defer></script>
    <script src="{{asset('https://cdn.amcharts.com/lib/5/index.js')}}" defer></script>
    <script src="{{asset('https://cdn.amcharts.com/lib/5/xy.js')}}" defer></script>
    <script src="{{asset('https://cdn.amcharts.com/lib/5/percent.js')}}" defer></script>
    <script src="{{asset('https://cdn.amcharts.com/lib/5/radar.js')}}" defer></script>
    <script src="{{asset('https://cdn.amcharts.com/lib/5/themes/Animated.js')}}" defer></script>
    <script src="{{asset('https://cdn.amcharts.com/lib/5/map.js')}}" defer></script>
    <script src="{{asset('https://cdn.amcharts.com/lib/5/geodata/worldLow.js')}}" defer></script>
    <script src="{{asset('https://cdn.amcharts.com/lib/5/geodata/continentsLow.js')}}" defer></script>
    <script src="{{asset('https://cdn.amcharts.com/lib/5/geodata/usaLow.js')}}" defer></script>
    <script src="{{asset('https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js')}}" defer></script>
    <script src="{{asset('https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js')}}" defer></script>
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" defer></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->

    <script src="{{asset('assets/js/custom/widgets.js')}}" defer></script>
    <script src="{{asset('assets/js/custom/apps/chat/chat.js')}}" defer></script>
    <script src="{{asset('assets/js/custom/utilities/modals/upgrade-plan.js')}}" defer></script>
    <script src="{{asset('assets/js/custom/utilities/modals/create-app.js')}}" defer></script>
    <script src="{{asset('assets/js/custom/utilities/modals/new-target.js')}}" defer></script>
    <script src="{{asset('assets/js/custom/utilities/modals/users-search.js')}}" defer></script>
    <!--end::Custom Javascript-->

@endsection
