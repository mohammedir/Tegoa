$(function () {
    const
        language = $('#language').val(),
        app_url = $('#app_url').val();
    let id = 0, core_name = "";
    $(document).ready(function () {
        "use strict";
        get_forms();
    });


    function get_forms() {
        var KTAppEcommerceCategories = function () {
            var t, e, n = () => {
            };
            return {
                init: function () {
                    (t = document.querySelector("#kt_emergencies_table")) && ((e = $(t).DataTable({
                        searchable: true,
                        order: [[0, "asc"]],
                        ajax: {
                            "url": app_url + "/" + language + "/emergencies",
                            "type": 'GET',
                        },
                        columns: [
                            {
                                data: 'id',
                                name: 'id'
                            },
                            {
                                data: 'title',
                                name: 'title'
                            },
                            {
                                data: 'scooter_number',
                                name: 'scooter_number'
                            },
                            {
                                data: 'type',
                                name: 'type'
                            },
                            {
                                data: 'phone_number',
                                name: 'phone_number'
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
