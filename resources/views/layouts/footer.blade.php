<!--begin::Footer-->

<!--end::Footer-->
<!--begin::Javascript-->
<script>var hostUrl = "{{asset('assets/')}}";</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"defer></script>
<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
<!--end::Global Javascript Bundle-->
<!--end::Javascript-->
@yield('js')
