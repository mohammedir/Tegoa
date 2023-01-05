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
{{--<script type="module">
    // Import the functions you need from the SDKs you need
    import { initializeApp } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-app.js";
    import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-analytics.js";
    // TODO: Add SDKs for Firebase products that you want to use
    // https://firebase.google.com/docs/web/setup#available-libraries

    // Your web app's Firebase configuration
    // For Firebase JS SDK v7.20.0 and later, measurementId is optional
    const firebaseConfig = {
        apiKey: "AIzaSyDNboSoMB-1iRe6dKFm_7VoD3BBC5bq43w",
        authDomain: "teqoa-2b0d6.firebaseapp.com",
        projectId: "teqoa-2b0d6",
        storageBucket: "teqoa-2b0d6.appspot.com",
        messagingSenderId: "1075920682482",
        appId: "1:1075920682482:web:0c042b6b5fd6cb37823f6b",
        measurementId: "G-LE9NTVB50E"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const analytics = getAnalytics(app);


</script>--}}
<!--end::Javascript-->
@yield('js')
