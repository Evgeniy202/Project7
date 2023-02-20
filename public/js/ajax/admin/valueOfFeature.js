$(document).ready(function () {
    $('#char').on('change', function () {
        var charID = $(this).val();
        if (charID) {
            $.ajax({
                url: '/get-values-for-char/' + charID,
                type: 'GET',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                dataType: "json",
                success: function (data) {
                    if (data) {
                        $('#value').empty();
                        $('#value').focus;
                        $('#value').append('<option value="">-Select value of characteristic-</option>');
                        $.each(data, function (key, value) {
                            $('select[name="value"]').append('<option value="' + value.id + '">' + value.value + '</option>');
                        });
                    } else {
                        $('#value').empty();
                    }
                }
            });
        } else {
            $('#value').empty();
        }
    });
});
