$(document).ready(function () {
    $('#sort').on('change', function () {
        let arr = $(this).val().split("-");
        if (arr[1]) {
            if (arr[1]) {
                window.location.replace("/Category/" + arr[0] + "/sort/" + arr[1]);
            }
        }
    });
});
