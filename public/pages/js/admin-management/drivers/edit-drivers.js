$(function () {
    const app_url = $('#app_url').val(),
        language = $('#language').val(),
        name_input = $("#name_edit"),
        address_input = $("#address_edit"),
        vehicle_type_input = $("#vehicle_type_edit"),
        email_input = $("#email_edit"),
        gender_input = $("#gender_edit"),
        mobile_input = $("#mobile_edit"),
        uploaded_image3 = $("#uploaded_image3"),
        uploaded_image4 = $("#uploaded_image4");

    $(document).ready(function () {
        update_news();
    });

    function update_news() {
        "use strict";
        var KTUsersUpdatePermission = function () {
            const t = document.getElementById("kt_modal_update_drivers"),
                e = t.querySelector("#kt_modal_update_drivers_form"), n = new bootstrap.Modal(t);
            return {
                init: function () {
                    (() => {
                        var o = FormValidation.formValidation(e, {
                            fields: {permission_name_edit: {}},
                            plugins: {
                                trigger: new FormValidation.plugins.Trigger,
                                bootstrap: new FormValidation.plugins.Bootstrap5({
                                    rowSelector: ".fv-row",
                                    eleInvalidClass: "",
                                    eleValidClass: ""
                                })
                            }
                        });
                        t.querySelector('[data-kt-permissions-modal-actions="close"]').addEventListener("click", (t => {
                            t.preventDefault(), Swal.fire({
                                text: language === "en" ? "Are you sure you would like to close?" : "هل أنت متأكد أنك تريد الإغلاق؟",
                                icon: "warning",
                                showCancelButton: !0,
                                buttonsStyling: !1,
                                confirmButtonText: language === "en" ? "Yes, close it!" : "نعم ، أغلقه!",
                                cancelButtonText: language === "en" ? "No, return" : "لا رجوع",
                                customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
                            }).then((function (t) {
                                t.value  && $(".errors").html("") && $("#file-chosens").html(language === "en" ? "No file chosen" : " لم يتم اختيار ملف"),$('#uploaded_image3').css('background-image','none'),$('#uploaded_image4').css('background-image','none') && $("#file-chosenss").html(language === "en" ? "No file chosen" : " لم يتم اختيار ملف") && n.hide()
                            }))
                        })), t.querySelector('[data-kt-permissions-modal-actions="cancel"]').addEventListener("click", (t => {
                            t.preventDefault(), Swal.fire({
                                text: language === "en" ? "Are you sure you would like to cancel?" : "هل أنت متأكد أنك تريد الإلغاء؟",
                                icon: "warning",
                                showCancelButton: !0,
                                buttonsStyling: !1,
                                confirmButtonText: language === "en" ? "Yes, cancel it!" : "نعم ، قم بإلغائها!",
                                cancelButtonText: language === "en" ? "No, return" : "لا رجوع",
                                customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
                            }).then((function (t) {
                                t.value ? (e.reset(),$(".errors").html(""),$('#uploaded_image3').css('background-image','none'),$('#uploaded_image4').css('background-image','none'),$("#file-chosens").html(language === "en" ? "No file chosen" : " لم يتم اختيار ملف"),$("#file-chosenss").html(language === "en" ? "No file chosen" : " لم يتم اختيار ملف"), n.hide()) : "cancel" === t.dismiss && Swal.fire({
                                    text: language === "en" ? "Your form has not been cancelled!." : "لم يتم إلغاء النموذج الخاص بك !.",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: language === "en" ? "Ok, got it!" : "حسنًا ، فهمت!",
                                    customClass: {confirmButton: "btn btn-primary"}
                                })
                            }))
                        }));
                        const i = t.querySelector('[data-kt-permissions-modal-actions="submit"]');
                        i.addEventListener("click", (function (t) {
                            $(".errors").html("");
                            let name = name_input.val(),
                                address = address_input.val(),
                                vehicle_type = vehicle_type_input.val(),
                                email = email_input.val(),
                                gender = gender_input.val(),
                                mobile = mobile_input.val(),
                                customer_image3 = prepare_image_base64(uploaded_image3.css('background-image'));
                            if (customer_image3 == "none") {
                                customer_image3 = "";
                            }
                            let customer_image4 = prepare_image_base64(uploaded_image4.css('background-image'));
                            if (customer_image4 == "none") {
                                customer_image4 = "";
                            }
                            t.preventDefault(), o && o.validate().then((function (t) {
                                "Valid" == t ? $.ajax({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        type: "PUT",
                                        url: app_url + "/" + language + "/drivers/" + $('#driver_edit_id').text(),
                                        async: true,
                                        cache: false,

                                        data: {
                                            name_edit: name,
                                            address_edit: address,
                                            vehicle_type_edit: vehicle_type,
                                            email_edit: email,
                                            gender_edit: gender,
                                            mobile_edit: mobile,
                                            fileuploads: customer_image3,
                                            fileuploadss: customer_image4,
                                        },
                                        success: function (response) {
                                            if ($.isEmptyObject(response.error)) {
                                                $('#uploaded_image3').css('background-image','none');
                                                $('#uploaded_image4').css('background-image','none');
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
                                                $("#file-chosens").html(language === "en" ? "No file chosen" : " لم يتم اختيار ملف");
                                                $("#file-chosenss").html(language === "en" ? "No file chosen" : " لم يتم اختيار ملف");
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
            KTUsersUpdatePermission.init()
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
