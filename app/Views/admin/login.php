<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AI Projekt | Admin login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/admin_source/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="/admin_source/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/admin_source/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="/admins/login"><b>AI </b>Projekt</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">Bejelentkezéshez töltse ki az alábbi mezőket</p>

        <form id="adminlogin">
            <div class="input-group mb-3">
                <input type="email" id="email" name="email" class="form-control" placeholder="Email">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="password" id="password" name="password" class="form-control" placeholder="Jelszó">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6"></div>
                <!-- /.col -->
                <div class="col-6">
                    <button type="button" class="btn btn-primary btn-block">Bejelentkezés</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="/admin_source/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/admin_source/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/admin_source/dist/js/adminlte.min.js"></script>
<!-- jquery-validation -->
<script src="/admin_source/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="/admin_source/plugins/jquery-validation/additional-methods.min.js"></script>
<script>
    function showError(field,text){
        $(field).closest('.input-group').append('<span class="invalid-feedback">'+ text + '</span>');
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
    $('.btn-primary').on('click', function(){
        resetError('#email');
        resetError('#password')
        btnLoading($(this),1,'Töltés');

        $.ajax({
            type: 'POST',
            url: '/admin/login',
            data: $('#adminlogin').serialize(),
            dataType: 'json',
            success: function(data) {

                btnLoading('.btn-primary',0,'Bejelentkezés');
                if(data.error == 1){
                    if(data.email == 1){
                        showError('#email',data.info)
                    }
                    if(data.password == 1){
                        showError('#password',data.info)
                    }

                }else{
                    window.location.href = '/admin/dashboard';
                }

            },
            error: function(error){
                //console.log(error);
            }
        });
    })

</script>
</body>
</html>
