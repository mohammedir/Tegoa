@extends('layouts.master')
@section('content')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">@lang('web.Roles List')</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a class="text-muted text-hover-primary">@lang('web.dashboard1')</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">@lang('web.Roles Management')</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">@lang('web.Roles')</li>
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
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <input id="role_id" type="hidden" value="{{$role->id}}">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Layout-->
            <div class="d-flex flex-column flex-lg-row">
                <!--begin::Sidebar-->
                <div class="flex-column flex-lg-row-auto w-100 w-lg-200px w-xl-300px mb-10">
                    <!--begin::Card-->
                    <div class="card card-flush">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2 class="mb-0">{{$role->name}}</h2>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Permissions-->
                            <div id="permissions_content" class="d-flex flex-column text-gray-600">
                                @foreach($role->role_permissions as $role_permission)
                                    @if(!str_contains($role_permission->permission->name,"_"))
                                        <div class="d-flex align-items-center py-2">
                                                <span
                                                    class="bullet bg-primary me-3"></span>@lang("web.".$role_permission->permission->name)
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <!--end::Permissions-->
                        </div>
                        <!--end::Card body-->
                        <!--begin::Card footer-->
                        @if($role->id != 1)
                        <div class="card-footer pt-0">
                                    <button data-id="{{$role->id}}" type="button"
                                            class="kt_modal_edit_role btn btn-light btn-active-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_update_role">{{__("web.Edit Role")}}
                                    </button>
                                    <button type="button" data-id="{{$role->id}}"
                                            class="d-none btn delete_role btn btn-light btn-active-light-danger my-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_delete_role">{{__("web.Delete")}}
                                    </button>
                        </div>
                        @endif
                        <!--end::Card footer-->
                    </div>
                    <!--end::Card-->
                    <!--begin::Modal-->
                    <!--begin::Modal - Update role-->
                    <div class="modal fade" id="kt_modal_update_role" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-750px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header">
                                    <!--begin::Modal title-->
                                    <h2 class="fw-bolder">{{__("web.Update Role")}}</h2>
                                    <!--end::Modal title-->
                                    <!--begin::Close-->
                                    <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                         data-kt-roles-modal-action="close">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                        <span class="svg-icon svg-icon-1">
																<svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                     height="24" viewBox="0 0 24 24" fill="none">
																	<rect opacity="0.5" x="6" y="17.3137" width="16"
                                                                          height="2" rx="1"
                                                                          transform="rotate(-45 6 17.3137)"
                                                                          fill="black"/>
																	<rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                                          transform="rotate(45 7.41422 6)"
                                                                          fill="black"/>
																</svg>
															</span>
                                        <!--end::Svg Icon-->
                                    </div>
                                    <!--end::Close-->
                                </div>
                                <!--end::Modal header-->
                                <!--begin::Modal body-->
                                <div class="modal-body scroll-y mx-5 my-7">
                                    <!--begin::Form-->
                                    <form id="kt_modal_update_role_form" class="form" action="#">
                                        <!--begin::Scroll-->
                                        <div class="d-flex flex-column scroll-y me-n7 pe-7"
                                             id="kt_modal_update_role_scroll" data-kt-scroll="true"
                                             data-kt-scroll-activate="{default: false, lg: true}"
                                             data-kt-scroll-max-height="auto"
                                             data-kt-scroll-dependencies="#kt_modal_update_role_header"
                                             data-kt-scroll-wrappers="#kt_modal_update_role_scroll"
                                             data-kt-scroll-offset="300px">
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-10">
                                                <!--begin::Label-->
                                                <label class="fs-5 fw-bolder form-label mb-2">
                                                    <span class="required">{{__("web.Role name")}}</span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input id="permission_name_update"
                                                       class="form-control form-control-solid"
                                                       placeholder="@lang("web.Enter Here")" name="role_name"
                                                       value="{{$role->name}}"/>
                                                <!--end::Input-->
                                                <strong id="name_update_error" class="errors text-danger"
                                                        role="alert"></strong>
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Permissions-->
                                            <div class="fv-row">
                                                <!--begin::Label-->
                                                <label
                                                    class="fs-5 fw-bolder form-label mb-2">{{__("web.Role Permissions")}}</label>
                                                <strong id="permissions_update_error" class="errors text-danger"
                                                        role="alert"></strong>
                                                <!--end::Label-->
                                                <!--begin::Table wrapper-->
                                                <div class="table-responsive">
                                                    <!--begin::Table-->
                                                    <table class="table align-middle table-row-dashed fs-6 gy-5">
                                                        <!--begin::Table body-->
                                                        <tbody class="text-gray-600 fw-bold">
                                                        {{--@php
                                                            $old_role_permissions = [];
                                                            foreach ($role->role_permissions as $item) {
                                                                array_push($old_role_permissions,$item->permission_id);
                                                            }
                                                        @endphp--}}
                                                        <input id="role_permissions_array" type="hidden"
                                                               value="{{$role->role_permissions}}">
                                                        <!--begin::Table rows-->
                                                        <tr>
                                                            <td class="text-gray-800">{{__("web.Administrator Access")}}
                                                                <i class="fas fa-exclamation-circle ms-1 fs-7"
                                                                   data-bs-toggle="tooltip" title=""
                                                                   data-bs-original-title="Allows a full access to the system"
                                                                   aria-label="@lang('web.Allows a full access to the system')"></i>
                                                            </td>
                                                            <td>
                                                                <!--begin::Checkbox-->
                                                                <label
                                                                    class="form-check form-check-sm form-check-custom form-check-solid me-9">
                                                                    <input class="form-check-input" type="checkbox"
                                                                           value="" id="kt_roles_select_all">
                                                                    <span class="form-check-label"
                                                                          for="kt_roles_select_all">{{__("web.Select all")}}</span>
                                                                </label>
                                                                <!--end::Checkbox-->
                                                            </td>
                                                        </tr>
                                                        <!--end::Table rows-->
                                                        <!--begin::Table row-->
                                                        @foreach($permissions as $permission)
                                                            <!--end::Table row-->
                                                            @if(!str_contains($permission->name,"_"))
                                                                <tr>
                                                                    <!--begin::Label-->
                                                                    <td class="text-gray-800">@lang("web.$permission->name")</td>
                                                                    <!--end::Label-->
                                                                    <!--begin::Options-->
                                                                    <td class="float-end" style="">
                                                                    @php
                                                                        $id_id = "";
                                                                    @endphp

                                                                    <!--begin::Wrapper-->
                                                                        <div class="d-flex">
                                                                            <!--begin::Checkbox-->
                                                                            <label
                                                                                class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                                                <input data-id="{{$permission->id}}"
                                                                                       class="action_permission_selected form-check-input"
                                                                                       type="checkbox"
                                                                                       value="@php $id_id = get_permission_by_name($permission->name.'_view')->id; @endphp {{$id_id}}"
                                                                                       {{get_role_permission_checked($role->id,$id_id)? "checked": ""}}
                                                                                       name="user_management_view">
                                                                                <span
                                                                                    class="form-check-label">{{__("web.View")}}</span>
                                                                            </label>
                                                                            @if(get_permission_by_name($permission->name.'_create') != null)
                                                                            <label
                                                                                class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                                                <input data-id="{{$permission->id}}"
                                                                                       class="action_permission_selected form-check-input"
                                                                                       type="checkbox"
                                                                                       value="@php $id_id = get_permission_by_name($permission->name.'_create')->id; @endphp {{$id_id}}"
                                                                                       {{get_role_permission_checked($role->id,$id_id)? "checked": ""}}
                                                                                       name="user_management_create">
                                                                                <span
                                                                                    class="form-check-label">{{__("web.Create")}}</span>
                                                                            </label>
                                                                            @endif
                                                                            @if(get_permission_by_name($permission->name.'_edit') != null)
                                                                            <label
                                                                                class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                                                <input data-id="{{$permission->id}}"
                                                                                       class="action_permission_selected form-check-input"
                                                                                       type="checkbox"
                                                                                       value="@php $id_id = get_permission_by_name($permission->name.'_edit')->id; @endphp {{$id_id}}"
                                                                                       {{get_role_permission_checked($role->id,$id_id)? "checked": ""}}
                                                                                       name="user_management_edit">
                                                                                <span
                                                                                    class="form-check-label">{{__("web.Edit")}}</span>
                                                                            </label>
                                                                            @endif
                                                                            @if(get_permission_by_name($permission->name.'_delete') != null)
                                                                            <label
                                                                                class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                                                <input data-id="{{$permission->id}}"
                                                                                       class="action_permission_selected form-check-input"
                                                                                       type="checkbox"
                                                                                       value="@php $id_id = get_permission_by_name($permission->name.'_delete')->id; @endphp {{$id_id}}"
                                                                                       {{get_role_permission_checked($role->id,$id_id)? "checked": ""}}
                                                                                       name="user_management_delete">
                                                                                <span
                                                                                    class="form-check-label">{{__("web.Delete")}}</span>
                                                                            </label>
                                                                            @endif
                                                                            <!--end::Checkbox-->
                                                                        </div>
                                                                        <!--end::Wrapper-->
                                                                    </td>
                                                                    <!--end::Options-->
                                                                </tr>
                                                                <!--begin::Table row-->
                                                            @endif
                                                        @endforeach
                                                        <!--end::Table row-->
                                                        </tbody>
                                                        <!--end::Table body-->
                                                    </table>
                                                    <!--end::Table-->
                                                </div>
                                                <!--end::Table wrapper-->
                                            </div>
                                            <!--end::Permissions-->
                                        </div>
                                        <!--end::Scroll-->
                                        <!--begin::Actions-->
                                        <div class="text-center pt-15">
                                            <button type="reset" class="btn btn-light me-3"
                                                    data-kt-roles-modal-action="cancel">{{__("web.Discard")}}
                                            </button>
                                            <button type="submit" class="btn btn-primary"
                                                    data-kt-roles-modal-action="submit">
                                                <span class="indicator-label">{{__("web.Submit")}}</span>
                                                <span class="indicator-progress">{{__("web.Please wait...")}}
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
                    <!--end::Modal - Update role-->
                    <!--end::Modal-->
                </div>
                <!--end::Sidebar-->
                <!--begin::Content-->
                <div class="flex-lg-row-fluid ms-lg-10">
                    <!--begin::Card-->
                    <div class="card card-flush mb-6 mb-xl-9">
                        <!--begin::Card header-->
                        <div class="card-header pt-5">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2 class="d-flex align-items-center">@lang("web.Users Assigned")
                                    <span class="text-gray-600 fs-6 ms-1">({{count($role->admin_roles)}})</span>
                                </h2>
                            </div>
                            <!--end::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Search-->
                                <div class="d-flex align-items-center position-relative my-1"
                                     data-kt-view-roles-table-toolbar="base">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
															<svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                 height="24" viewBox="0 0 24 24" fill="none">
																<rect opacity="0.5" x="17.0365" y="15.1223"
                                                                      width="8.15546" height="2" rx="1"
                                                                      transform="rotate(45 17.0365 15.1223)"
                                                                      fill="black"/>
																<path
                                                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                                    fill="black"/>
															</svg>
														</span>
                                    <!--end::Svg Icon-->
                                    <input type="text" data-kt-roles-table-filter="search"
                                           class="form-control form-control-solid w-250px ps-15"
                                           placeholder="@lang("web.Search Here")"/>
                                </div>
                                <!--end::Search-->
                                <!--begin::Group actions-->
                                <div class="d-flex justify-content-end align-items-center d-none"
                                     data-kt-view-roles-table-toolbar="selected">
                                    <div class="fw-bolder me-5">
                                        <span class="me-2" data-kt-view-roles-table-select="selected_count"></span>Selected
                                    </div>
                                    <button type="button" class="btn btn-danger"
                                            data-kt-view-roles-table-select="delete_selected">Delete Selected
                                    </button>
                                </div>
                                <!--end::Group actions-->
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0"
                                   id="kt_roles_view_table">
                                <!--begin::Table head-->
                                <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">@lang("web.ID")</th>
                                    <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">@lang("web.User")</th>
                                    <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">@lang("web.status")</th>
                                    <th class="@if(\Illuminate\Support\Facades\App::getLocale() == "en") min-w-125px @else text-start @endif">@lang("web.Joined Date")</th>
                                </tr>
                                <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600">

                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Layout-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
@endsection
@section('js')
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"defer></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{asset('pages/js/admin-management/role/update.js')}}"defer></script>
    <script src="{{asset('pages/js/admin-management/role/users.js')}}"defer></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
@endsection
