<!--begin::Footer-->
<div id="kt_app_footer" class="app-footer">
    <!--begin::Footer container-->
    <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
        <!--begin::Copyright-->
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted fw-semibold me-1">2022&copy;</span>
            <a href="https://keenthemes.com" target="_blank" class="text-gray-800 text-hover-primary">Keenthemes</a>
        </div>
        <!--end::Copyright-->
    </div>
    <!--end::Footer container-->
</div>
<!--end::Footer-->
<!--begin::Javascript-->
<script>var hostUrl = "{{asset('assets/')}}";</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"defer></script>
<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
<!--end::Global Javascript Bundle-->

<!--end::Javascript-->
@yield('js')
