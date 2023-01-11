$(function () {
    const language = $('#language').val(),
        add_user_form = document.getElementById("kt_modal_edit_user_form"),
        submit_button = document.getElementById('kt_modal_update_user_submit'),
        discard_button = document.getElementById('kt_modal_update_user_submit'),
        id = $('#user_id').val(),
        app_url = $('#app_url').val(),
        public_input = $("#public_price"),
        private_input = $("#private_price"),
        key_input = $("#key");


    $(document).ready(function () {
        "use strict"
        update_user();
    });

    function update_user() {
        submit_button.addEventListener('click', function () {
            console.log("sss")
            $(".errors").html("");
            let publics = public_input.val(),
                privates = private_input.val(),
                keys = key_input.val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                url: app_url + "/" + language + "/settings/update/one/",
                data: {
                    public_price: publics,
                    private_price: privates,
                    key: keys,
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

