$(function(){

    const select2Search = `http://${location.host}/admin/employee/select`;

    $('.selectpicker-parent').select2({
        width: '100%',
        ajax: {
            url: select2Search,
            data: function (params) {
                let query = {
                    search: params.term,
                    page: params.page || 1
                }
                // Query parameters will be ?search=[term]&page=[page]
                return query;
            }
        }
    });
})
