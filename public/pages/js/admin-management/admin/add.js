$(function () {
    const language = $('#language').val(),
        id = $('#customer_id').val(),
        app_url = $('#app_url').val(),
        name_input = $("#name"),
        email_input = $("#email"),
        mobile_input = $("#mobile"),
        password_input = $("#password"),
        password_confirmation_input = $("#password_confirmation"),
        uploaded_image = $("#uploaded_image"),
        uploaded_image_view = $("#uploaded_image_view"),
        image_file_input = $("#image_file_input"),
        radio_roles = $(".radio_roles");

    let role_name = $("#first_role").data("name"),
        role_id = $("#first_role").data("id"),
        image_updated = 0, r;

    $(document).ready(function () {
        image_update();
        create_user();
        role_radio();
    });

    function role_radio() {
        radio_roles.click(function () {
            role_id = $(this).data("id");
            role_name = $(this).data("name");
        });
    }

    function create_user() {
        "use strict";
        var KTUsersAddUser = function () {
            const t = document.getElementById("kt_modal_add_user"), e = t.querySelector("#kt_modal_add_user_form"),
                n = new bootstrap.Modal(t);
            return {
                init: function () {
                    (() => {
                        var o = FormValidation.formValidation(e, {
                            fields: {
                            },
                            plugins: {
                                trigger: new FormValidation.plugins.Trigger,
                                bootstrap: new FormValidation.plugins.Bootstrap5({
                                    rowSelector: ".fv-row",
                                    eleInvalidClass: "",
                                    eleValidClass: ""
                                })
                            }
                        });
                        const i = t.querySelector('[data-kt-users-modal-action="submit"]');
                        i.addEventListener("click", (t => {
                            $(':input[type="submit"]').prop('disabled', true);
                            t.preventDefault(), o && o.validate().then((function (t) {
                                $(".errors").html("");
                                let name = name_input.val(),
                                    email = email_input.val(),
                                    password = password_input.val(),
                                    mobile = mobile_input.val(),
                                    password_confirm = password_confirmation_input.val(),
                                    customer_image = prepare_image_base64(uploaded_image.css('background-image'));
                                if (customer_image == "none") {
                                    customer_image = "";
                                }
                                console.log("validated!"), "Valid" == t ?
                                    $.ajax({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        type: "POST",
                                        url: app_url + "/" + language + "/admin/store",
                                        data: {
                                            name: name,
                                            email: email,
                                            password: password,
                                            password_confirmation: password_confirm,
                                            customer_image: customer_image,
                                            image_updated: image_updated,
                                            roles_id: role_id,
                                            roles_name: role_name,
                                            mobile: mobile,
                                        },
                                        success: function (response) {
                                            if ($.isEmptyObject(response.error)) {
                                                $(".errors").html("");
                                                (i.setAttribute("data-kt-indicator", "on"), i.disabled = !0, setTimeout((function () {
                                                    i.removeAttribute("data-kt-indicator"), i.disabled = !1, Swal.fire({
                                                        text: language === "en" ? "Form has been successfully submitted!" : "تم أضافة المستخدم بنجاح!",
                                                        icon: "success",
                                                        buttonsStyling: !1,
                                                        confirmButtonText: language === "en" ? "Ok, got it!" : "حسنًا ، فهمت!",
                                                        customClass: {confirmButton: "btn btn-primary"}
                                                    }).then((function (t) {
                                                        t.isConfirmed && n.hide()
                                                    }))
                                                }), 2e3));
                                                $("#uploaded_image").css("background-image", "");
                                                $("input").val("");
                                                $(".errors").html("");
                                                $('#kt_table_users').DataTable().ajax.reload();
                                            } else {
                                                Swal.fire({
                                                    text: $('#language').val() === "en" ? "Sorry, looks like there are some errors detected, please try again." : "معذرة ، يبدو أنه تم اكتشاف بعض الأخطاء ، يرجى المحاولة مرة أخرى.",
                                                    icon: "error",
                                                    buttonsStyling: !1,
                                                    confirmButtonText: language === "en" ? "Ok, got it!" : "حسنًا ، فهمت!",
                                                    customClass: {confirmButton: "btn btn-primary"}
                                                })
                                                $(':input[type="submit"]').prop('disabled', false);
                                                $(".errors").html("");
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
                        })), t.querySelector('[data-kt-users-modal-action="cancel"]').addEventListener("click", (t => {
                            t.preventDefault(), Swal.fire({
                                text: language === "en" ? "Are you sure you would like to cancel?" : "هل أنت متأكد أنك تريد الإلغاء؟",
                                icon: "warning",
                                showCancelButton: !0,
                                buttonsStyling: !1,
                                confirmButtonText: language === "en" ? "Yes, cancel it!" : "نعم ، قم بالإلغاء!",
                                cancelButtonText: language === "en" ? "No, return" : "لا تراجع",
                                customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
                            }).then((function (t) {
                                t.value ? (e.reset(),$(".errors").html("") ,$("#uploaded_image").css("background-image", ""), n.hide()) : "cancel" === t.dismiss && Swal.fire({
                                    text: language === "en" ? "Your form has not been cancelled!." : "لم يتم إلغاء النموذج الخاص بك !.",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: language === "en" ? "Ok, got it!" : "حسنًا ، فهمت!",
                                    customClass: {confirmButton: "btn btn-primary"}
                                })
                            }))
                        })), t.querySelector('[data-kt-users-modal-action="close"]').addEventListener("click", (t => {
                            t.preventDefault(), Swal.fire({
                                text: language === "en" ? "Are you sure you would like to cancel?" : "هل أنت متأكد أنك تريد الإلغاء؟",
                                icon: "warning",
                                showCancelButton: !0,
                                buttonsStyling: !1,
                                confirmButtonText: language === "en" ? "Yes, cancel it!" : "نعم ، قم بالإلغاء!",
                                cancelButtonText: language === "en" ? "No, return" : "لا تراجع",
                                customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
                            }).then((function (t) {
                                t.value ? (e.reset(),$(".errors").html("") ,$("#uploaded_image").css("background-image", ""), n.hide()) : "cancel" === t.dismiss && Swal.fire({
                                    text: language === "en" ? "Your form has not been cancelled!." : "لم يتم إلغاء النموذج الخاص بك !.",
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
            KTUsersAddUser.init()
        }));
    }

    function prepare_image_base64(image) {
        image = image.replace('url("data:image/jpeg;base64,', '');
        image = image.replace('url("data:image/jpeg;base64,', '');
        image = image.replace('url("data:image/png;base64,', '');
        image = image.replace('url("data:image/jpg;base64,', '');
        image = image.replace('")', '');
        if (image == "none") {
            return "";
        } else
            return image;
    }

    function image_update() {
        image_file_input.on('change', function (ev) {
            image_updated = 1;
        });
    }

    function print_error(errors) {
        $.each(errors, function (index, val) {
            $("#" + index + "_error").html(val);
            $("#" + index).focus();
        });
    }
});

