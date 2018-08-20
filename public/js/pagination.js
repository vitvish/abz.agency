$(function () {
    $(window).on('hashchange', function () {
        page = window.location.hash.replace('#', '');
        getProducts(page);
    });
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        // getProducts(page);
        location.hash = page;
    });

    function getProducts(page) {
        const input = document.querySelector('#search').value;
        let sortCache = sessionStorage.getItem('sort');
        if (!sortCache) {
            sortCache = '';
        }

        $.ajax({
            url: 'http://127.0.0.1:8000/admin/employee/search?page=' + page + '&query=' + input + '&sorted=' + sortCache
        }).done(function (data) {
            $('tbody').html(data.table_data);
            $('.total_records').text(data.total_data);
            $('.tbl-paginate').html(data.table_paginate);
        });
    }
})

