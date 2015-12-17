function swal_success(title, text) {
    swal(title, text, "success")
}

function swal_error(title, text) {
    swal(title, text, "error")
}

function swal_delete(title, text, button) {
    swal({
            title             : title,
            text : text,
            type : "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText : button,
            closeOnConfirm    : true
        },
        function () {
            //swal("Deleted!", "Your imaginary file has been deleted.", "success");
        });
}
