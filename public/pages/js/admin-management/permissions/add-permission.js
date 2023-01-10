$(function () {
    const app_url = $('#app_url').val(),
        language = $('#language').val();

$(document).ready(function () {
    create_permission();
});
function create_permission(){
    "use strict";
    var KTUsersAddPermission = function () {
        const t = document.getElementById("kt_modal_add_permission"), e = t.querySelector("#kt_modal_add_permission_form"),
            n = new bootstrap.Modal(t);
        return {
            init: function () {
                (() => {
                    var o = FormValidation.formValidation(e, {
                        fields: {permission_name_create: {validators: {notEmpty: {message: language == 'en' ?"Permission name is required":"اسم الإذن مطلوب"}}}},
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger,
                            bootstrap: new FormValidation.plugins.Bootstrap5({
                                rowSelector: ".fv-row",
                                eleInvalidClass: "",
                                eleValidClass: ""
                            })
                        }
                    });
                    t.querySelector('[data-kt-permissions-modal-action="close"]').addEventListener("click", (t => {
                        t.preventDefault(), Swal.fire({
                            text: "Are you sure you would like to close?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Yes, close it!",
                            cancelButtonText: "No, return",
                            customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
                        }).then((function (t) {
                            t.value && n.hide()
                        }))
                    })), t.querySelector('[data-kt-permissions-modal-action="cancel"]').addEventListener("click", (t => {
                        t.preventDefault(), Swal.fire({
                            text: "Are you sure you would like to cancel?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Yes, cancel it!",
                            cancelButtonText: "No, return",
                            customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
                        }).then((function (t) {
                            t.value ? (e.reset(), n.hide()) : "cancel" === t.dismiss && Swal.fire({
                                text: "Your form has not been cancelled!.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {confirmButton: "btn btn-primary"}
                            })
                        }))
                    }));
                    const i = t.querySelector('[data-kt-permissions-modal-action="submit"]');
                    i.addEventListener("click", (function (t) {
                        $(':input[type="submit"]').prop('disabled', true);
                        t.preventDefault(), o && o.validate().then((function (t) {
                            "Valid" == t ? $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    type: "POST",
                                    url: app_url + "/permissions/store",
                                    data: {
                                        name: $("#permission_name_create").val(),
                                    },
                                    success: function (response) {
                                        if ($.isEmptyObject(response.error)) {
                                            (i.setAttribute("data-kt-indicator", "on"), i.disabled = !0, setTimeout((function () {
                                                i.removeAttribute("data-kt-indicator"), i.disabled = !1,
                                                    Swal.fire({
                                                        text: language === "en" ? "Form has been successfully submitted!" : "تم تقديم النموذج بنجاح!",
                                                        icon: "success",
                                                        buttonsStyling: !1,
                                                        confirmButtonText: language === "en" ? "Ok, got it!" : "حسنًا ، فهمت!",
                                                        customClass: {confirmButton: "btn btn-primary"}
                                                    }).then((function (t) {
                                                        t.isConfirmed && n.hide()
                                                    }))
                                            }), 2e3));
                                            $("input").val("");
                                            /*table.DataTable().ajax.reload();*/
                                            $('#kt_permissions_table').load(document.URL +  ' #kt_permissions_table');

                                        } else {
                                            Swal.fire({
                                                text: language === "en" ? "Sorry, looks like there are some errors detected, please try again." : "معذرة ، يبدو أنه تم اكتشاف بعض الأخطاء ، يرجى المحاولة مرة أخرى.",
                                                icon: "error",
                                                buttonsStyling: !1,
                                                confirmButtonText: language === "en" ? "Ok, got it!" : "حسنًا ، فهمت!",
                                                customClass: {confirmButton: "btn btn-primary"}
                                            })
                                            $(':input[type="submit"]').prop('disabled', false);
                                            print_error(response.error);
                                        }
                                    }
                                })
                                : Swal.fire({
                                    text: language === "en" ? "Sorry, looks like there are some errors detected, please try again." : "معذرة ، يبدو أنه تم اكتشاف بعض الأخطاء ، يرجى المحاولة مرة أخرى.",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: language === "en" ? "Ok, got it!" : "حسنًا ، فهمت!",
                                    customClass: {confirmButton: "btn btn-primary"}
                                })
                        }))
                    }))
                })()
            }
        }
    }();
    KTUtil.onDOMContentLoaded((function () {
        KTUsersAddPermission.init()
    }));
}

function print_error(errors) {
        $.each(errors, function (index, val) {
            $("#" + index + "_error").html(val);
            $("#" + index).focus();
        });
    }

});
