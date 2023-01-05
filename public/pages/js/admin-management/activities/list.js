var table = $('#kt_activities_table');
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
            url: "/activities/" + id + "/edit",
            dataType: 'json',
            success: function (response) {
                $("#activities_edit_id").html(response.id);
                $("#name_en_edit").val(response.name['en']);
                $("#name_ar_edit").val(response.name['ar']);
                $("#description_en_edit").val(response.description['en']);
                $("#description_ar_edit").val(response.description['ar']);
                $("#required_tools_en_edit").val(response.required_tools['en']);
                $("#required_tools_ar_edit").val(response.required_tools['ar']);
                $("#start_date_edit").val(response.start_date);
                $("#end_date_edit").val(response.end_date);
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
            type: 'DELETE',
            url: "activities/" + id ,
            success: function (response) {
                if (response['success']) {
                    Swal.fire({
                        text: language === "en" ? "You have deleted the item!." : "لقد قمت بحذف العنصر !.",
                        icon: "success",
                        buttonsStyling: !1,
                        confirmButtonText: language === "en" ? "Ok, got it!" : "حسنًا ، فهمت!",
                        customClass: {confirmButton: "btn fw-bold btn-primary"}
                    });
                    $('#kt_activities_table').DataTable().ajax.reload();
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

    function get_forms() {
        var KTAppEcommerceCategories = function () {
            var t, e, n = () => {
                t.querySelectorAll('[data-kt-ecommerce-forms-filter="delete_row"]').forEach((t => {
                    t.addEventListener("click", (function (t) {
                        t.preventDefault();
                        const n = t.target.closest("tr"),
                            o = n.querySelector('[data-kt-ecommerce-forms-filter="forms_name"]').innerText;
                        Swal.fire({
                            text: "Are you sure you want to delete " + o + "?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Yes, delete!",
                            cancelButtonText: "No, cancel",
                            customClass: {
                                confirmButton: "btn fw-bold btn-danger",
                                cancelButton: "btn fw-bold btn-active-light-primary"
                            }
                        }).then((function (t) {
                            t.value ? Swal.fire({
                                text: "You have deleted " + o + "!.",
                                icon: "success",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: { confirmButton: "btn fw-bold btn-primary" }
                            }).then((function () {
                                e.row($(n)).remove().draw()
                            })) : "cancel" === t.dismiss && Swal.fire({
                                text: o + " was not deleted.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: { confirmButton: "btn fw-bold btn-primary" }
                            })
                        }))
                    }))
                }))
            };
            return {
                init: function () {
                    (t = document.querySelector("#kt_activities_table")) && ((e = $(t).DataTable({
                        searchable: true,
                        ajax: {
                            "url": base_path + language + "/activities",
                            "type": 'GET',
                            /*"data":{core_name:core_name},*/
                        },
                        columns: [
                            {
                                data: 'name',
                                name: 'name'
                            },
                            {
                                data: 'description',
                                name: 'description'
                            },
                            {
                                data: 'start_date',
                                name: 'start_date'
                            },
                            {
                                data: 'end_date',
                                name: 'end_date'
                            },
                            {
                                data: 'status',
                                name: 'status'
                            },
                            {
                                data: 'others',
                                name: 'others',

                            },
                        ],language: {
                            url: language === "en" ? "//cdn.datatables.net/plug-ins/1.13.1/i18n/en-GB.json" : "//cdn.datatables.net/plug-ins/1.13.1/i18n/ar.json",
                        },
                    })).on("draw", (function () {
                        n()
                    })), document.querySelector('[data-kt-ecommerce-forms-filter="search"]').addEventListener("keyup", (function (t) {
                        e.search(t.target.value).draw()
                    })),/* filter_class.click(function () {
                        $("<option></option>").insertBefore($('.filter_data option:first-child'));
                        filter_class.val("")
                        e.search("").draw()
                        $("option:selected").prop("selected", false)
                    }),*/ $("#reset").click(function () {
                        $("#search").val("");
                        $("<option></option>").insertBefore($('.filter_data option:first-child'));
                        filter_class.val("")
                        e.search("").draw()
                        $("option:selected").prop("selected", false)
                    }), filter_class.on("change", function () {
                        core_name = $(this).val();
                        e.search(core_name.trim()).draw()
                    }), n())
                }
            }
        }();
        KTUtil.onDOMContentLoaded((function () {
            KTAppEcommerceCategories.init()
        }));
    }

});
