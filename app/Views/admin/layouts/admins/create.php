<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $page_name ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><?= $breadcrumbs[0] ?></a></li>
                        <li class="breadcrumb-item active"><?= $breadcrumbs[1] ?></a></li>

                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-xs-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Admin létrehozás</h3>
                        </div>

                        <form id="new_admin">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="user_name">Név</label>
                                    <input type="text" class="form-control" name="user_name" id="user_name" placeholder="Név">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email cím</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email cím">
                                </div>
                                <div class="form-group">
                                    <label for="password">Jelszó</label>
                                    <div class="input-group mb-3">
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Jelszó">
                                        <div class="input-group-append">
                                            <span style="cursor: pointer" onclick="generatePassword()" class="input-group-text"><i class="fas fa-solid fa-lock"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-primary">Mentés</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
    <script>

        $('.btn-primary').on('click', function(){
            resetError('#email');
            resetError('#password');
            btnLoading($(this),1,'Töltés');

            $.ajax({
                type: 'POST',
                url: '/admin/admins/add',
                data: $('#new_admin').serialize(),
                dataType: 'json',
                success: function(data) {

                    btnLoading('.btn-primary',0,'Bejelentkezés');
                    if(data.error == 1){

                        if(data.user_name == 1){
                            showError('.form-group','#user_name',data.info.user_name)
                        }

                        if(data.email == 1){
                            showError('.form-group','#email',data.info.email)
                        }

                        if(data.password == 1){
                            showError('.form-group','#password',data.info.password)
                        }

                        if(data.all == 1){
                            showPopup('error',data.info.all)
                        }

                    }else{
                        showPopup('success',data.info.all)
                    }

                },
                error: function(error){
                    //console.log(error);
                }
            });
        })
    </script>
</div>
