$(function () {
    const app_url = $('#app_url').val(),
        language = $('#language').val();

    $(document).ready(function() {
        $('#save').click(function() {
            $.ajax({
                url: "getUnRegisterUsersCard",
                type: 'GET',
                success: function(response) {
                    var allUsers = response;
                    var options = '';
                    allUsers.forEach(function(user) {
                        options += '<option value="' + user.id + '">' + user.full_name +' -- '+ user.email + '</option>';
                    });
                    $('#driver').html(options);
                }
            });
        });
    });

    $(document).ready(function () {
        create_permissions();
    });

    function create_permissions() {
        "use strict";
        var KTUsersAddPermission = function () {
            const t = document.getElementById("kt_modal_add_car"),
                e = t.querySelector("#kt_modal_add_car_form"),
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
                        t.querySelector('[data-kt-permissionss-modal-action="close"]').addEventListener("click", (t => {
                            t.preventDefault(), Swal.fire({
                                text: language === "en" ? "Are you sure you would like to close?" : "هل أنت متأكد أنك تريد الإغلاق؟",
                                icon: "warning",
                                showCancelButton: !0,
                                buttonsStyling: !1,
                                confirmButtonText: language === "en" ? "Yes, close it!" : "نعم ، أغلقه!",
                                cancelButtonText: language === "en" ? "No, return" : "لا رجوع",
                                customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
                            }).then((function (t) {
                                t.value && $(".errors").html("")  && $("#file-chosens").html(language === "en" ? "No file chosen" : " لم يتم اختيار ملف") && $("#file-chosens_photos_carlicense").html(language === "en" ? "No file chosen" : " لم يتم اختيار ملف") && $("#file-chosens_photos_carinsurance").html(language === "en" ? "No file chosen" : " لم يتم اختيار ملف") && $("#file-chosens_photos_passengersinsurance").html(language === "en" ? "No file chosen" : " لم يتم اختيار ملف") && n.hide()
                            }))
                        })), t.querySelector('[data-kt-permissionss-modal-action="cancel"]').addEventListener("click", (t => {
                            t.preventDefault(), Swal.fire({
                                text: language === "en" ? "Are you sure you would like to cancel?" : "هل أنت متأكد أنك تريد الإلغاء؟",
                                icon: "warning",
                                showCancelButton: !0,
                                buttonsStyling: !1,
                                confirmButtonText: language === "en" ? "Yes, cancel it!" : "نعم ، قم بإلغائها!",
                                cancelButtonText: language === "en" ? "No, return" : "لا رجوع",
                                customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
                            }).then((function (t) {
                                t.value ? (e.reset(), $(".errors").html(""), n.hide() , $("#file-chosens").html(language === "en" ? "No file chosen" : " لم يتم اختيار ملف") , $("#file-chosens_photos_carlicense").html(language === "en" ? "No file chosen" : " لم يتم اختيار ملف"), $("#file-chosens_photos_passengersinsurance").html(language === "en" ? "No file chosen" : " لم يتم اختيار ملف") , $("#file-chosens_photos_carinsurance").html(language === "en" ? "No file chosen" : " لم يتم اختيار ملف")) : "cancel" === t.dismiss && Swal.fire({
                                    text: language === "en" ? "Your form has not been cancelled!." : "لم يتم إلغاء النموذج الخاص بك !.",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: language === "en" ? "Ok, got it!" : "حسنًا ، فهمت!",
                                    customClass: {confirmButton: "btn btn-primary"}
                                })
                            }))
                        }));
                        const i = t.querySelector('[data-kt-permissionss-modal-action="submit"]');
                        i.addEventListener("click", (function (t) {
                            $(':input[type="submit"]').prop('disabled', true);
                            var formData = new FormData(document.getElementById("kt_modal_add_car_form"));

                            // var featured_image = $('#photos')[0].files[0];
                            // formData.append("image", featured_image);
                            //
                            const totalImages = $("#photos")[0].files.length;
                            let images = $("#photos")[0];
                            for (let i = 0; i < totalImages; i++) {
                                formData.append('photoss' + i, images.files[i]);
                            }
                            // formData.append("type", $('#type').val());
                            // formData.append("number", $('#number').val());
                            // formData.append("brand", $('#brand').val());
                            // formData.append("license", $('#license').val());
                            // formData.append("insurance_number", $('#insurance_number').val());
                            // formData.append("insurance_expiry_date", $('#insurance_expiry_date').val());
                            // formData.append("passengers_insurance", $('#passengers_insurance').val());

                            t.preventDefault(), o && o.validate().then((function (t) {
                                "Valid" == t ? $.ajax({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        type: "POST",
                                        url: app_url + "/" + language + "/cars",
                                        data: formData,
                                        processData: false,  // tell jQuery not to process the data
                                        contentType: false,
                                        success: function (response) {
                                            if ($.isEmptyObject(response.error)) {
                                                $(':input[type="submit"]').prop('disabled', false);
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
                                                $("#file-chosens_photos_carlicense").html(language === "en" ? "No file chosen" : " لم يتم اختيار ملف");
                                                $("#file-chosens_photos_carinsurance").html(language === "en" ? "No file chosen" : " لم يتم اختيار ملف");
                                                $("#file-chosens_photos_passengersinsurance").html(language === "en" ? "No file chosen" : " لم يتم اختيار ملف");

                                                $("input").val("");
                                                $("textarea").val("");
                                                $(".errors").html("");
                                                /*table.DataTable().ajax.reload();*/
                                                $('#kt_cars_table').DataTable().ajax.reload();

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

    function print_error(errors) {
        $.each(errors, function (index, val) {
            $("#" + index + "_error").html(val);
            $("#" + index).focus();
        });
    }

});
