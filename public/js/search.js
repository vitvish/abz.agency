/**
 * Remove active class on all td in table
 * @param  NodeList all TableTr node list collection tr
 * @param  Number len
 * @return void
 */
function removeActiveClass(allTableTr, len) {
    for (let i = 0; i < len; i++) {
        el = allTableTr[i];
        let currElement = el.children;
        let currElementLength = el.children.length;
        for (let i = 0; i < currElementLength; i++) {
            currElement[i].classList.remove('table-active-td');
        }
    }
}

$(function () {

    /* Searching on field input:search */

    fetch_employee_data();

    function fetch_employee_data(query = '', sorted = '') {

        const requestURL = `http://${location.host}/admin/employee/search`;

        $.ajax({
            url: requestURL,
            method: "GET",
            dataType: "json",
            cache: false,
            data: {query: query, sorted: sorted},

        }).done(function (data) {
            $('tbody').html(data.table_data);
            $('.total_records').text(data.total_data);
            $('.tbl-paginate').html(data.table_paginate);
            $('.loader').animate({
                opacity: 0,
            }, 1500);
        })
    }

    // Event user input
    $(document).on('keyup', '#search', function () {
        let query = $(this).val();
        fetch_employee_data(query);
    })

    /* Searching on columns */

    /* Flag for sorted */
    $flagSorted = false;

    $('table.sortable thead tr th').on('click', function (e) {
        if ($flagSorted) {
            $sort = this.cellIndex + '|' + 'asc';
            $flagSorted = false;
        }
        else {
            $sort = this.cellIndex + '|' + 'desc';
            $flagSorted = true;
        }
        sessionStorage.setItem('sort', $sort);
        // GET request on sorted
        fetch_employee_data('', $sort);

        /* Get all tr NodeList */
        const allTR = document.querySelectorAll('tr');

        /* Length NodeList tr */
        const AllTrLength = allTR.length;

        /* Run function remove active class on all td */
        removeActiveClass(allTR, AllTrLength);

        /* Add active class on td */
        for (let j = 0; j < AllTrLength; j++) {
            allTR[j].children[this.cellIndex].classList.add('table-active-td');
        }

    })
});