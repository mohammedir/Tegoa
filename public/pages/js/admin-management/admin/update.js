$(function () {
    const language = $('#language').val(),
        add_user_form = document.getElementById("kt_modal_edit_user_form"),
        submit_button = document.getElementById('kt_modal_update_user_submit'),
        discard_button = document.getElementById('kt_modal_update_user_submit'),
        id = $('#user_id').val(),
        app_url = $('#app_url').val(),
        name_input = $(" #name"),
        email_input = $(" #email"),
        mobile_input = $(" #mobile"),
        password_input = $(" #password"),
        password_confirmation_input = $(" #password_confirmation"),
        uploaded_image = $(" #uploaded_image"),
        uploaded_image_view = $(" #uploaded_image_view"),
        image_file_input = $(" #image_file_input"),
        radio_roles = $(" .radio_roles");

    let role_name = $(" #first_role").data("name"),
        role_id = $(" #first_role").data("id"),
        image_updated = 0;

    $(document).ready(function () {
        "use strict"
        image_update();
        role_radio();
        update_user();
        //discard_update();
    });

    function role_radio() {
        radio_roles.click(function () {
            role_id = $(this).data("id");
            role_name = $(this).data("name");
        });
    }

    function update_user() {
        submit_button.addEventListener('click', function () {
            console.log("sss")
            $(".errors").html("");
            let name = name_input.val(),
                email = email_input.val(),
                mobile = mobile_input.val(),
                password = password_input.val(),
                password_confirm = password_confirmation_input.val(),
                user_image = prepare_image_base64(uploaded_image.css('background-image'));
            /*let user_image = uploaded_image.css('background-image');
            if (uploaded_image.css('background-image').length > 30)
                user_image = prepare_image_base64(uploaded_image.css('background-image'));*/
            if (user_image == "none") {
                user_image = "";
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: app_url + "/" + language + "/admin/update/" + id,
                data: {
                    name: name,
                    email: email,
                    mobile: mobile,
                    password: password,
                    password_confirmation: password_confirm,
                    user_image: user_image,
                    image_updated: image_updated,
                    roles_id: role_id,
                    roles_name: role_name,
                },
                success: function (response) {
                    if ($.isEmptyObject(response.error)) {
                        success_submit();
                        $(".errors").html("");
                    } else {
                        console.log(response)
                        failed_submit(response);
                    }
                }
            })
        })
    }

    /*function discard_update() {
        discard_button.addEventListener("click", function () {
            Swal.fire({
                text: language === "en" ? "Are you sure you would like to cancel?" : "هل أنت متأكد أنك تريد الإلغاء؟",
                icon: "warning",
                showCancelButton: !0,
                buttonsStyling: !1,
                confirmButtonText: language === "en" ? "Yes, cancel it!" : "نعم ، قم بالإلغاء!",
                cancelButtonText: language === "en" ? "No, return" : "لا تراجع",
                customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
            }).then((function (t) {
                t.value ? (e.reset(), n.hide()) : "cancel" === (window.location.href = app_url + "/admin/users") && Swal.fire({
                    text: language === "en" ? "Your form has not been cancelled!." : "لم يتم إلغاء النموذج الخاص بك !.",
                    icon: "error",
                    buttonsStyling: !1,
                    confirmButtonText: language === "en" ? "Ok, got it!" : "حسنًا ، فهمت!",
                    customClass: {confirmButton: "btn btn-primary"}
                })
            }))
        })
    }*/

    function success_submit() {
        //Success Submit
        $(".errors").html("");
        (submit_button.setAttribute("data-kt-indicator", "on"), submit_button.disabled = !0, setTimeout((function () {
            submit_button.removeAttribute("data-kt-indicator"), Swal.fire({
                text: language === "en" ? "Form has been successfully submitted!" : "تم تقديم النموذج بنجاح!",
                icon: "success",
                buttonsStyling: !1,
                confirmButtonText: language === "en" ? "Ok, got it!" : "حسنًا ، فهمت!",
                customClass: {confirmButton: "btn btn-primary"}
            }).then((function (e) {
                e.isConfirmed
                window.location.reload(true);
            }))
            submit_button.disabled = !1
        }), 1000));//2e3 == 1000
    }

    function failed_submit(errors) {
        //Failed Submit
        $(".errors").html("");
        (submit_button.setAttribute("data-kt-indicator", "on"), submit_button.disabled = !0, setTimeout((function () {
            submit_button.removeAttribute("data-kt-indicator"), Swal.fire({
                text: language === "en" ? "Sorry, looks like there are some errors detected, please try again." : "معذرة ، يبدو أنه تم اكتشاف بعض الأخطاء ، يرجى المحاولة مرة أخرى.",
                icon: "error",
                buttonsStyling: !1,
                confirmButtonText: language === "en" ? "Ok, got it!" : "حسنًا ، فهمت!",
                customClass: {confirmButton: "btn btn-primary"}
            })
            submit_button.disabled = !1
            print_error(errors.error);
        }), 1000));
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

