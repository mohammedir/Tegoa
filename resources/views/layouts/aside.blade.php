<!--begin::Aside Menu-->
@php
    $language = config('app.locale');
    $url = \Illuminate\Support\Facades\URL::current();
    $previous_url = \Illuminate\Support\Facades\URL::previous();
@endphp
    <!--begin::Sidebar-->
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
     data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
     data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Logo-->
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <!--begin::Logo image-->
        <a href="{{url('/')}}">
            <div class="symbol-label">
                @if(auth()->user()->personalphoto)
                    <img alt="Logo"
                         src="{{asset('images/users/' . \Illuminate\Support\Facades\Auth::user()->personalphoto)}}"
                         style="border-radius: 50%;width: 20% !important;"
                         class=" app-sidebar-logo-default"/>
                    <img alt="Logo"
                         src="{{asset('images/users/' . \Illuminate\Support\Facades\Auth::user()->personalphoto)}}"
                         style="border-radius: 50%;width: 20% !important;"
                         class=" app-sidebar-logo-minimize"/>
                @else
                    <img alt="Logo" src="{{asset('assets/media/avatars/300-1.jpg')}}"
                         style="border-radius: 50%;width: 20% !important;"/>
                @endif
                <a class="text-hover-primary mb-1"
                   style="@if(\Illuminate\Support\Facades\App::getLocale() == "ar")padding-right: 15px; @else padding-left: 15px; @endif color: white; font-size:14px; display: inline">{{\Illuminate\Support\Facades\Auth::user()->full_name}}</a>
            </div>
        </a>
        <!--end::Logo image-->

    </div>
    <!--end::Logo-->
    <!--begin::sidebar menu-->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <!--begin::Menu wrapper-->
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5"
             data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
             data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
             data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px"
             data-kt-scroll-save-state="true">
            <!--begin::Menu-->
            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
                 data-kt-menu="true" data-kt-menu-expand="false">
                <!--begin:Menu item-->
                @can('dashboard_view')
                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                        <!--begin:Menu link-->
                        <a href="{{url('dashboard')}}"><span
                                class="menu-link {{str_contains($url,"dashboard") ? "active":""}}">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
												<span class="svg-icon svg-icon-2">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
														<rect x="2" y="2" width="9" height="9" rx="2"
                                                              fill="currentColor"/>
														<rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2"
                                                              fill="currentColor"/>
														<rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2"
                                                              fill="currentColor"/>
														<rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2"
                                                              fill="currentColor"/>
													</svg>
												</span>
                                                <!--end::Svg Icon-->
											</span>
											<span class="menu-title">@lang('web.dashboard')</span>
										</span></a>
                        <!--end:Menu link.-->
                    </div>
                    <!--end:Menu item.-->
                @endcan
                <!--begin:Menu item-->
                <div class="menu-item pt-5">
                    <!--begin:Menu content-->
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase fs-7">@lang('web.Pages')</span>
                    </div>
                    <!--end:Menu content.-->
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click"
                     class="menu-item menu-accordion {{str_contains($url,"admins") || str_contains($url,"roles") || str_contains($url,"permissions") || str_contains($url,"drivers") || str_contains($url,"passengers") ? "hover show":""}} ">
                    <!--begin:Menu link-->
                    @if(\Illuminate\Support\Facades\Auth::user()->hasAnyPermission(['admins_view','drivers_view','passengers_view','roles_view']))

                    <span class="menu-link">

                            <span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/abstract/abs029.svg-->
												<span class="svg-icon svg-icon-2">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
														<path
                                                            d="M6.5 11C8.98528 11 11 8.98528 11 6.5C11 4.01472 8.98528 2 6.5 2C4.01472 2 2 4.01472 2 6.5C2 8.98528 4.01472 11 6.5 11Z"
                                                            fill="currentColor"/>
														<path opacity="0.3"
                                                              d="M13 6.5C13 4 15 2 17.5 2C20 2 22 4 22 6.5C22 9 20 11 17.5 11C15 11 13 9 13 6.5ZM6.5 22C9 22 11 20 11 17.5C11 15 9 13 6.5 13C4 13 2 15 2 17.5C2 20 4 22 6.5 22ZM17.5 22C20 22 22 20 22 17.5C22 15 20 13 17.5 13C15 13 13 15 13 17.5C13 20 15 22 17.5 22Z"
                                                              fill="currentColor"/>
													</svg>
												</span>
                                <!--end::Svg Icon-->
											</span>
                            <span class="menu-title">@lang('web.Users Management')</span>
                            <span class="menu-arrow"></span>
										</span>
                    @endif

                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        @can('admins_view')
                            <div data-kt-menu-trigger="click"
                                 class="menu-item menu-accordion mb-1 {{str_contains($url,"admins") ? "hover show":""}} ">
                                <!--begin:Menu link-->
                                <a href="{{url("admins")}}"><span
                                        class="menu-link {{str_contains($url,"admins") ? "active":""}} ">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">@lang('web.Admins')</span>

												</span>
                                </a>
                                <!--end:Menu link-->

                            </div>
                        @endcan
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        @can('drivers_view')
                            <div data-kt-menu-trigger="click"
                                 class="menu-item menu-accordion mb-1 {{str_contains($url,"drivers") ? "hover show":""}} ">
                                <!--begin:Menu link-->
                                <a href="{{route("drivers.index")}}"><span
                                        class="menu-link {{str_contains($url,"drivers") ? "active":""}} ">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">@lang('web.Drivers')</span>

												</span>
                                </a>
                                <!--end:Menu link-->

                            </div>
                        @endcan
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        @can('passengers_view')
                            <div data-kt-menu-trigger="click"
                                 class="menu-item menu-accordion mb-1 {{str_contains($url,"passengers") ? "hover show":""}} ">
                                <!--begin:Menu link-->
                                <a href="{{route("passengers.index")}}"><span
                                        class="menu-link {{str_contains($url,"passengers") ? "active":""}} ">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">@lang('web.Passengers')</span>

												</span>
                                </a>
                                <!--end:Menu link-->

                            </div>
                        @endcan
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        @can('roles_view')
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                <!--begin:Menu link-->
                                <a href="{{url("roles")}}"><span
                                        class="menu-link {{str_contains($url,"roles") ? "active":""}}">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">@lang('web.Roles')</span>

												</span>
                                </a>
                                <!--end:Menu link-->

                            </div>
                        @endcan
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
                @can('cars_view')
                    <div class="menu-item menu-accordion {{str_contains($url,"cars")  ? "hover show":""}} ">
                        <!--begin:Menu link-->
                        <a class="menu-link {{str_contains($url,"cars") ? "active":""}}" href="{{route('cars.index')}}">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/abstract/abs029.svg-->
												<span class="svg-icon svg-icon-2">
													<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-car-front-fill"
                                                         viewBox="0 0 16 16">
                                                        <path
                                                            d="M2.52 3.515A2.5 2.5 0 0 1 4.82 2h6.362c1 0 1.904.596 2.298 1.515l.792 1.848c.075.175.21.319.38.404.5.25.855.715.965 1.262l.335 1.679c.033.161.049.325.049.49v.413c0 .814-.39 1.543-1 1.997V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.338c-1.292.048-2.745.088-4 .088s-2.708-.04-4-.088V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.892c-.61-.454-1-1.183-1-1.997v-.413a2.5 2.5 0 0 1 .049-.49l.335-1.68c.11-.546.465-1.012.964-1.261a.807.807 0 0 0 .381-.404l.792-1.848ZM3 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm10 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2ZM6 8a1 1 0 0 0 0 2h4a1 1 0 1 0 0-2H6ZM2.906 5.189a.51.51 0 0 0 .497.731c.91-.073 3.35-.17 4.597-.17 1.247 0 3.688.097 4.597.17a.51.51 0 0 0 .497-.731l-.956-1.913A.5.5 0 0 0 11.691 3H4.309a.5.5 0 0 0-.447.276L2.906 5.19Z"/>
                                                    </svg>
												</span>
                                                <!--end::Svg Icon-->
											</span>
                            <span class="menu-title">@lang('web.Cars_List')</span>
                        </a>
                        <!--end:Menu link-->

                    </div>
                @endcan
                @can('places_view')
                    <div class="menu-item menu-accordion {{str_contains($url,"places")  ? "hover show":""}} ">
                        <!--begin:Menu link-->
                        <a class="menu-link {{str_contains($url,"places") ? "active":""}}"
                           href="{{route('places.index')}}">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/abstract/abs029.svg-->
												<span class="svg-icon svg-icon-2">
													<i class="bi bi-map"></i>
												</span>
                                                <!--end::Svg Icon-->
											</span>
                            <span class="menu-title">@lang('web.places_list')</span>
                        </a>
                        <!--end:Menu link-->

                    </div>
                @endcan
                @can('news_view')
                    <div class="menu-item menu-accordion {{str_contains($url,"news")  ? "hover show":""}} ">
                        <!--begin:Menu link-->
                        <a class="menu-link {{str_contains($url,"news") ? "active":""}}" href="{{route('news.index')}}">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/abstract/abs029.svg-->
												<span class="svg-icon svg-icon-2">
													<i class="bi bi-newspaper"></i>
												</span>
                                                <!--end::Svg Icon-->
											</span>
                            <span class="menu-title">@lang('web.news_list')</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                @endcan
                @can('tour_view')
                    <div class="menu-item menu-accordion {{str_contains($url,"Tour")  ? "hover show":""}} ">
                        <!--begin:Menu link-->
                        <a class="menu-link {{str_contains($url,"tour") ? "active":""}}" href="{{route('tour.index')}}">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/abstract/abs029.svg-->
												<span class="svg-icon svg-icon-2">
													<i class="bi bi-escape"></i>
												</span>
                                                <!--end::Svg Icon-->
											</span>
                            <span class="menu-title">@lang('web.tour_list')</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                @endcan
                @can('emergencies_view')
                    <div class="menu-item menu-accordion {{str_contains($url,"emergencies")  ? "hover show":""}} ">
                        <!--begin:Menu link-->
                        <a class="menu-link {{str_contains($url,"emergencies") ? "active":""}}"
                           href="{{route('emergencies.index')}}">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/abstract/abs029.svg-->
												<span class="svg-icon svg-icon-2">
													<i class="fa fa-ambulance" aria-hidden="true"></i>
												</span>
                                                <!--end::Svg Icon-->
											</span>
                            <span class="menu-title">@lang('web.emergencies')</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                @endcan
                @can('activities_view')
                    <div class="menu-item menu-accordion {{str_contains($url,"activities")  ? "hover show":""}} ">
                        <!--begin:Menu link-->
                        <a class="menu-link {{str_contains($url,"activities") ? "active":""}}"
                           href="{{route('activities.index')}}">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/abstract/abs029.svg-->
												<span class="svg-icon svg-icon-2">
													<i class="bi bi-card-checklist"></i>
												</span>
                                                <!--end::Svg Icon-->
											</span>
                            <span class="menu-title">@lang('web.activities')</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                @endcan
                @can('transportations_view')
                    <div class="menu-item menu-accordion {{str_contains($url,"transportations")  ? "hover show":""}} ">
                        <!--begin:Menu link-->
                        <a class="menu-link {{str_contains($url,"transportations") ? "active":""}}"
                           href="{{route('transportations.index')}}">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/abstract/abs029.svg-->
												<span class="svg-icon svg-icon-2">
													<i class="bi bi-exclamation-triangle"></i>
												</span>
                                                <!--end::Svg Icon-->
											</span>
                            <span class="menu-title">@lang('web.transportations')</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                @endcan
                <br>
                <br>
                <br>
                @can('settings_view')
                    <div class="menu-item menu-accordion {{str_contains($url,"settings")  ? "hover show":""}} ">
                        <!--begin:Menu link-->
                        <a class="menu-link {{str_contains($url,"settings") ? "active":""}}"
                           href="{{route('settings.index')}}">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/abstract/abs029.svg-->
												<span class="svg-icon svg-icon-2">
													<i class="bi bi-gear"></i>
												</span>
                                                <!--end::Svg Icon-->
											</span>
                            <span class="menu-title">@lang('web.Settings')</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                @endcan
                <div class="menu-item menu-accordion {{str_contains($url,"Sign Out")  ? "hover show":""}} ">
                    <!--begin:Menu link-->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="menu-link"
                           href="{{route('logout')}}" onclick="event.preventDefault(); this.closest('form').submit();">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/abstract/abs029.svg-->
												<span class="svg-icon svg-icon-2">
													<i class="bi bi-box-arrow-left"></i>
												</span>
                                                <!--end::Svg Icon-->
											</span>
                            <span class="menu-title">@lang('web.Sign Out')</span>
                        </a>
                    </form>
                    <!--end:Menu link-->
                </div>
            </div>
            <!--end::Menu-->
        </div>
        <!--end::Menu wrapper-->
    </div>
    <!--end::sidebar menu-->
</div>
<!--end::Sidebar-->
