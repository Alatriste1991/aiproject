<section class="content-wrapper">
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
        <div class="row">
            <div class="col-md-12">
                <form id="bug_form">
                    <input type="hidden" name="feedback_id" value="<?php if(isset($feedback_data['feedback_id'])){echo $feedback_data['feedback_id'];} ?>">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Alapinformációk</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="bug_name">Bug megnevezése</label>
                                <input type="text" name="bug_name" id="bug_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="bug_description">Bug leírás</label>
                                <textarea name="bug_description" id="bug_description" class="form-control" rows="4"><?php if(isset($feedback_data['feedback_text'])){echo $feedback_data['feedback_text'];} ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="priority">Prioritás</label>
                                <select id="priority" name="priority" class="form-control custom-select">
                                    <option selected="" disabled="">Válassz egyet</option>
                                    <option value="default" <?php if(isset($priority) && $priority == 'default'){echo 'selected="selected"';} ?>>Nem sürgős</option>
                                    <option value="warning" <?php if(isset($priority) && $priority == 'warning'){echo 'selected="selected"';} ?>>Fontos</option>
                                    <option value="important" <?php if(isset($priority) && $priority == 'important'){echo 'selected="selected"';} ?>>Azonnal javítandó</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status">Státusz</label>
                                <select id="status" name="status" class="form-control custom-select">
                                    <option selected="" disabled="">Válassz egyet</option>
                                    <option value="create" >Létrehozva</option>
                                    <option value="inprogress" >Folyamatban</option>
                                    <option value="test" >Tesztelés</option>
                                    <option value="success" >Befejezve</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="user_id">Bejelentő felhasználó ID</label>
                                <input type="text" name="user_id" id="user_id" class="form-control"  value="<?php if(isset($feedback_data['user_id'])){echo $feedback_data['user_id'];} ?>">
                            </div>
                            <div class="form-group">
                                <label for="assigned_user_id">Felelős</label>
                                <select id="assigned_user_id" name="assigned_user_id" class="form-control custom-select">
                                    <option selected="" disabled="">Válassz egyet</option>
                                    <?php
                                    foreach ($admins as $admin){
                                        echo '<option value="'.$admin['admin_id'].'">'.$admin['admin_name'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </form>
                <!-- /.card -->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <a href="/admin/bugs" class="btn btn-secondary">Vissza</a>
                <button id="submit"class="btn btn-success float-right">Projekt létrehozása</button>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function () {

            function yesCallback() {
                resetError('#bug_name');
                resetError('#bug_description');
                resetError('#priority');
                resetError('#status');
                resetError('#assigned_user_id');
                $.ajax({
                    type: 'POST',
                    url: '/admin/bug/create',
                    data: $('#bug_form').serialize(),
                    dataType: 'json',
                    success: function(data) {

                        btnLoading( $('#submit'),0,'Projekt létrehozása');
                        if(data.error == 1){

                            $.each(data.errors,function (key,value) {
                                showError(value.index_class,'#' + key ,value.text)
                                showPopup('error','Sikertelen mentés! Javítsd a fennálló hibákat!')
                            })

                        }else{
                            showPopup('success','Sikeres mentés - átirányítás folyamatban')
                            setTimeout(function() {
                                window.location.href = "/admin/bug/" + data.id;
                            }, 4000);

                        }

                    },
                    error: function(error){
                        //console.log(error);
                    }
                });
            }
            $('#submit').on('click',function () {
                btnLoading($(this),1,'Töltés..');
                answerPopUp(
                    "Biztosan szeretnéd menteni ezt a bug projektet?",'Igen','Nem',
                    function() {
                        yesCallback();
                        btnLoading($('#submit'),0,'Projekt létrehozása');
                    },
                    function() {
                        btnLoading($(this),0,'Projekt létrehozása');
                    }
                );
            })
        })
    </script>
</section>