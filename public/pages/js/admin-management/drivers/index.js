$(function () {
    const
        language = $('#language').val(),
        app_url = $('#app_url').val();
    let id = 0, core_name = "",
     searchInput = $('#txt_name').val();

    $(document).ready(function () {
        "use strict";
        get_forms();
        console.log(searchInput);
    });


    function get_forms() {
        var KTAppEcommerceCategories = function () {
            var t, e, n = () => {
            };
            return {
                init: function () {
                    (t = document.querySelector("#kt_drivers_table")) && ((e = $(t).DataTable({
                        searchable: true,
                        "search": {
                            "search": searchInput
                        },
                        order: [[0, "asc"]],
                        ajax: {
                            "url": app_url + "/" + language + "/drivers",
                            "type": 'GET',
                        },
                        columns: [
                            {
                                data: 'id',
                                name: 'id'
                            },
                            {
                                data: 'full_name',
                                name: 'full_name'
                            },
                            {
                                data: 'email',
                                name: 'email'
                            },
                            {
                                data: 'mobile_number',
                                name: 'mobile_number'
                            },
                            {
                                data: 'address',
                                name: 'address'
                            },
                            {
                                data: 'status',
                                name: 'status'
                            },
                            {
                                data: 'others',
                                name: 'others'
                            }
                        ],"columnDefs": [{
                            "render": function (data, type, full, meta) {
                                return meta.row + 1; // adds id to serial no
                            },
                            "targets": 0
                        }], language: {
                            url: language === "en" ? "//cdn.datatables.net/plug-ins/1.13.1/i18n/en-GB.json" : "//cdn.datatables.net/plug-ins/1.13.1/i18n/ar.json",
                        },
                    })).on("draw", (function () {
                        n()
                    })), document.querySelector('[data-kt-ecommerce-forms-filter="search"]').addEventListener("keyup", (function (t) {
                        e.search(t.target.value).draw()
                    })),
                        n())
                }
            }
        }();
        KTUtil.onDOMContentLoaded((function () {
            KTAppEcommerceCategories.init()
        }));
    }
});
