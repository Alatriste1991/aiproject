function showError(closest,field,text){
    $(field).closest(closest).append('<span class="invalid-feedback">'+ text + '</span>');
    $(field).addClass('is-invalid');
}

function resetError(field){
    $('.invalid-feedback').remove()
    $(field).removeClass('is-invalid');
}

function btnLoading(btn,LoadorReset,text){

    if(LoadorReset == 1){
        $(btn).prop("disabled", true);
        // add spinner to button
        $(btn).html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ' + text + '...'
        );
    }else{
        $(btn).prop("disabled", false);
        // add spinner to button
        $(btn).html(text);
    }
}

function showPopup(type,text) {

    let Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    Toast.fire({
        icon: type,
        title: text
    })



}