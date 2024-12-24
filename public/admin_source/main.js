function showError(closest,field,text){
    $(field).closest(closest).append('<span class="invalid-feedback">'+ text + '</span>');
    $(field).addClass('is-invalid');
}

function resetError(field){
    $('.invalid-feedback').remove()
    $(field).removeClass('is-invalid');
}

function btnLoading(btn,LoaderReset,text){

    if(LoaderReset == 1){
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

function answerPopUp(text,confirmButtonText,cancelButtonText,yesCallback,noCallback) {
    let Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: true,
        confirmButtonText: confirmButtonText,
        cancelButtonText: cancelButtonText,
        reverseButtons: true,
        showCancelButton: true,
        showCloseButton: true,
        timer: 5000
    });

    Toast.fire({
        icon: 'question',
        title: text
    }).then((result) => {
        if (result.isConfirmed && typeof yesCallback === 'function') {
            // Igen gombra kattintás esetén
            yesCallback();
        } else if (result.dismiss === Swal.DismissReason.cancel && typeof noCallback === 'function') {
            // Nem gombra kattintás esetén
            noCallback();
        }
    })
}

function generatePassword() {

    let charset = "!@#$%^&*()0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    let newPassword = '';
    let passwordLength = 15

    for (let i = 0; i < passwordLength; i++) {
        newPassword += charset.charAt(
            Math.floor(Math.random() * charset.length));
    }

    //return newPassword;

    let Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 5000
    });

    Toast.fire({
        icon: 'info',
        title: 'Generált jelszó',
        text: newPassword,
    })

}
