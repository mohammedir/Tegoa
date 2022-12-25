var table = $('#kt_table_users');
$(function () {
    const language = $('#language').val(),
        app_url = $('#app_url').val();
    $(document).ready(function () {
        "use strict";
        /*Table Actions*/
        $(document).on('click', '#delete', function () {
            let id = $(this).data('id');
            confirm_delete(id);
        });
        $(document).on('click', '#edit', function () {
            let id = $(this).data('id');
            edit_user(id);
        });
    });

    function edit_user(id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: app_url + "/permissions/edit/" + id,
            success: function (response) {
                $("#edit_id").val(id);
                $("#permission_name_edit").val(response.permission.name);

            }
        });
    }

    function confirm_delete(id) {
        const o = "sads";
        Swal.fire({
            text: language === "en" ? "Are you sure you want to delete this item?" : "هل أنت متأكد أنك تريد حذف هذا البند؟",
            icon: "warning",
            showCancelButton: !0,
            buttonsStyling: !1,
            confirmButtonText: language === "en" ? "Yes, delete!" : "نعم ، احذف!",
            cancelButtonText: language === "en" ? "No, cancel" : "لا ، إلغاء",
            customClass: {
                confirmButton: "btn fw-bold btn-danger",
                cancelButton: "btn fw-bold btn-active-light-primary"
            }
        });
        var confirm_delete = document.getElementsByClassName("swal2-confirm");
        confirm_delete[0].addEventListener('click', function () {
            delete_user(id);
        });
    }

    function delete_user(id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "DELETE",
            url: app_url + "/permissions/destroy/" + id,
            success: function (response) {
                if (response['success']) {
                    Swal.fire({
                        text: language === "en" ? "You have deleted the item!." : "لقد قمت بحذف العنصر !.",
                        icon: "success",
                        buttonsStyling: !1,
                        confirmButtonText: language === "en" ? "Ok, got it!" : "حسنًا ، فهمت!",
                        customClass: {confirmButton: "btn fw-bold btn-primary"}
                    });
                    location.reload();
                } else if (response['error']) {
                    Swal.fire({
                        text: language === "en" ? "The item was not deleted." : "لم يتم حذف العنصر.",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: language === "en" ? "Ok, got it!" : "حسنًا ، فهمت!",
                        customClass: {confirmButton: "btn fw-bold btn-primary"}
                    });
                }
            }
        });
    }

});
