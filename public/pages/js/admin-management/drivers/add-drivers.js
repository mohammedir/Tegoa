$(function () {
    const app_url = $('#app_url').val(),
        language = $('#language').val(),
        name_input = $("#name"),
        address_input = $("#address"),
        password_input = $("#password"),
        password_confirmation_input = $("#password_confirmation"),
        vehicle_type_input = $("#vehicle_type"),
        email_input = $("#email"),
        gender_input = $("#gender"),
        mobile_input = $("#mobile"),
        uploaded_image1 = $("#uploaded_image"),
        uploaded_image2 = $("#uploaded_image2");

    $(document).ready(function () {
        create_news();
    });

    function create_news() {
        "use strict";
        var KTUsersAddPermission = function () {
            const t = document.getElementById("kt_modal_add_driver"),
                e = t.querySelector("#kt_modal_add_drivers_form"),
                n = new bootstrap.Modal(t);
            return {
                init: function () {
                    (() => {
                        var o = FormValidation.formValidation(e, {
                            fields: {
                                permission_name_create: {
                                    validators:
                                        {

                                        }
                                }
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
                        t.querySelector('[data-kt-permissions-modal-action="close"]').addEventListener("click", (t => {
                            t.preventDefault(), Swal.fire({
                                text: language === "en" ? "Are you sure you would like to close?" : "هل أنت متأكد أنك تريد الإغلاق؟",
                                icon: "warning",
                                showCancelButton: !0,
                                buttonsStyling: !1,
                                confirmButtonText: language === "en" ? "Yes, close it!" : "نعم ، أغلقه!",
                                cancelButtonText: language === "en" ? "No, return" : "لا رجوع",
                                customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
                            }).then((function (t) {
                                t.value && $("#spoken_languages").val(null).trigger("change") && $(".errors").html("") && $("#file-chosen-input").html(language === "en" ? "No file chosen" : " لم يتم اختيار ملف") && $("#file-chosensss").html(language === "en" ? "No file chosen" : " لم يتم اختيار ملف"),$('#uploaded_image').css('background-image','none'),$('#uploaded_image2').css('background-image','none') && n.hide()
                            }))
                        })), t.querySelector('[data-kt-permissions-modal-action="cancel"]').addEventListener("click", (t => {
                            t.preventDefault(), Swal.fire({
                                text: language === "en" ? "Are you sure you would like to cancel?" : "هل أنت متأكد أنك تريد الإلغاء؟",
                                icon: "warning",
                                showCancelButton: !0,
                                buttonsStyling: !1,
                                confirmButtonText: language === "en" ? "Yes, cancel it!" : "نعم ، قم بإلغائها!",
                                cancelButtonText: language === "en" ? "No, return" : "لا رجوع",
                                customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
                            }).then((function (t) {
                                t.value ? (e.reset(),$("#spoken_languages").val(null).trigger("change"),$('#uploaded_image').css('background-image','none'),$('#uploaded_image2').css('background-image','none'), $(".errors").html("") ,$("#file-chosen-input").html(language === "en" ? "No file chosen" : " لم يتم اختيار ملف"),$("#file-chosensss").html(language === "en" ? "No file chosen" : " لم يتم اختيار ملف"), n.hide()) : "cancel" === t.dismiss && Swal.fire({
                                    text: language === "en" ? "Your form has not been cancelled!." : "لم يتم إلغاء النموذج الخاص بك !.",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: language === "en" ? "Ok, got it!" : "حسنًا ، فهمت!",
                                    customClass: {confirmButton: "btn btn-primary"}
                                })
                            }))
                        }));
                        const i = t.querySelector('[data-kt-permissions-modal-action="submit"]');
                        i.addEventListener("click", (function (t) {
                            $(".errors").html("");
                            let name = name_input.val(),
                                address = address_input.val(),
                                password = password_input.val(),
                                password_confirmation = password_confirmation_input.val(),
                                vehicle_type = vehicle_type_input.val(),
                                email = email_input.val(),
                                gender = gender_input.val(),
                                mobile = mobile_input.val(),
                                customer_image1 = prepare_image_base64(uploaded_image1.css('background-image'));
                            if (customer_image1 == "none") {
                                customer_image1 = "";
                            }
                            let customer_image2 = prepare_image_base64(uploaded_image2.css('background-image'));
                            if (customer_image2 == "none") {
                                customer_image2 = "";
                            }
                            $(':input[type="submit"]').prop('disabled', true);
                            t.preventDefault(), o && o.validate().then((function (t) {
                                "Valid" == t ? $.ajax({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        type: "POST",
                                        url: app_url + "/" + language +"/drivers",
                                        async: true,
                                        cache: false,

                                        data: {
                                            name: name,
                                            address: address,
                                            password: password,
                                            password_confirmation: password_confirmation,
                                            vehicle_type: vehicle_type,
                                            email: email,
                                            gender: gender,
                                            mobile: mobile,
                                            fileupload: customer_image1,
                                            fileuploadsss: customer_image2,
                                        },
                                        success: function (response) {
                                            if ($.isEmptyObject(response.error)) {
                                                $(':input[type="submit"]').prop('disabled', false);
                                                $('#uploaded_image').css('background-image','none');
                                                $('#uploaded_image2').css('background-image','none');
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
                                                $("#file-chosen-input").html(language === "en" ? "No file chosen" : " لم يتم اختيار ملف");
                                                $("#file-chosensss").html(language === "en" ? "No file chosen" : " لم يتم اختيار ملف");
                                                $("input").val("");
                                                $("textarea").val("");
                                                $(".errors").html("");
                                                /*table.DataTable().ajax.reload();*/
                                                $('#kt_drivers_table').DataTable().ajax.reload();

                                            } else {
                                                Swal.fire({
                                                    text: language === "en" ? "Sorry, looks like there are some errors detected, please try again." : "معذرة ، يبدو أنه تم اكتشاف بعض الأخطاء ، يرجى المحاولة مرة أخرى.",
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
                        }))
                    })()
                }
            }
        }();
        KTUtil.onDOMContentLoaded((function () {
            KTUsersAddPermission.init()
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

    function print_error(errors) {
        $.each(errors, function (index, val) {
            $("#" + index + "_error").html(val);
            $("#" + index).focus();
        });
    }

});
