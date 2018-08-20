function deleteEmployee(t) {
    /* Get the form for delete this empoyee */
    const $form = t.parentNode;

    const token = $('meta[name="csrf-token"]').attr('content');

    /* Request to delete the selected user */
        $.ajax({
            url: $form.action,
            type: "POST",
            data: {_method: 'delete', _token :token},
        }).done(function(data) {
            if (data.success) {
                $('.success-delete').css('display', 'block');
            } else {
                $('.success-delete').css('display', 'block');
            }

            setTimeout(function() {
                data.success ? $('.success-delete').css('display', '') :
                    $('.success-delete').css('display', '');
                location.reload();
            }, 1700);

        })
}