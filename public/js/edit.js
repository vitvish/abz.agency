function fileUpload() {
    const data = new FormData(document.getElementById('edit-form-submit'));
    const imagefile = document.querySelector('#image');
    data.append('image', imagefile.files[0]);

    axios.post(imagefile.form.action, data, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    })
        .then(response => {
            if (response.data.success) {
                $('.file-update').css('display', 'block');

            } else {
                $('.error-update').css('display', 'block');

            }
            setTimeout(function() {
                response.data.success ? $('.file-update').css('display', '') :
                    $('.error-update').css('display', '');
                location.href = location;
            }, 1700);
        })
        .catch(error => {
            console.log(error.response)
        });
}
$('#image').on('change', function() {
    fileUpload();
});

$(function() {
    $('#edit-form-submit').on('submit', function(e) {
        e.preventDefault();
        $form = $(this);

        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            cache: false,
            data: $form.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function(data) {

            if (data.success) {
                $('.success-update').css('display', 'block');

            } else {
                $('.error-update').css('display', 'block');

            }
            setTimeout(function() {
                data.success ? $('.success-update').css('display', '') :
                    $('.error-update').css('display', '');
            }, 1700);

        })

    })
})
