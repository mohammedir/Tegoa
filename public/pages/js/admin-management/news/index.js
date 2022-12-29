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
                    (t = document.querySelector("#kt_news_table")) && ((e = $(t).DataTable({
                        searchable: true,
                        ajax: {
                            "url": app_url + "/" + language + "/news",
                            "type": 'GET',
                        },
                        columns: [
                            {
                                data: 'title',
                                name: 'title'
                            },
                            {
                                data: 'article',
                                name: 'article'
                            },
                            {
                                data: 'description',
                                name: 'description'
                            },
                            {
                                data: 'type',
                                name: 'type'
                            },
                            {
                                data: 'status',
                                name: 'status'
                            },
                            {
                                data: 'actions',
                                name: 'actions'
                            }
                        ], language: {
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
