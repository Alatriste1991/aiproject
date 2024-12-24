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
        <div class="row">
            <div class="col-md-3">
                <a href="/admin/feedback" class="btn btn-primary btn-block mb-3">Vissza a Feedback listára</a>
                <input type="hidden" id="feedback_id" value="<?= $feedback_id ?>">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Folders</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item active">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-inbox"></i> Inbox
                                    <span class="badge bg-primary float-right">12</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-envelope"></i> Sent
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-file-alt"></i> Drafts
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-filter"></i> Junk
                                    <span class="badge bg-warning float-right">65</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-trash-alt"></i> Trash
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.card-body -->
                </div>
                <?php
                if($feedback_type == 1){
                    ?>
                <!-- /.card -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Labels</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body p-0">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/feedback/<?= $feedback_id ?>?priority=important"><i class="far fa-circle text-danger"></i> Azonnal javítandó</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/feedback/<?= $feedback_id ?>?priority=warning"><i class="far fa-circle text-warning"></i> Fontos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/feedback/<?= $feedback_id ?>?priority=default"><i class="far fa-circle text-primary"></i> Nem sürgős</a>
                            </li>
                        </ul>
                    </div>

                    <!-- /.card-body -->
                </div>
                <?php } ?>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Tartalom</h3>

                       <!-- <div class="card-tools">
                            <a href="#" class="btn btn-tool" title="Previous"><i class="fas fa-chevron-left"></i></a>
                            <a href="#" class="btn btn-tool" title="Next"><i class="fas fa-chevron-right"></i></a>
                        </div> -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="mailbox-read-info">
                            <?php

                            switch ($feedback_type){
                                case '1':
                                    echo '<h5>Típus: Bug</h5>';
                                    break;
                                case '2':
                                    echo '<h5>Típus: Vélemény</h5>';
                                    break;
                                default:
                                    echo '<h5>Típus: Fejlesztési javaslat</h5>';
                                    break;
                            }

                            ?>
                            <h6>Tőle: <?= $user_name ?> -  <?= $user_email ?>
                                <span class="mailbox-read-time float-right"><?= $created_time ?></span></h6>
                        </div>
                        <!-- /.mailbox-read-info -->
                        <div class="mailbox-controls with-border text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm" data-container="body" title="Törlés">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                                <?php
                                    if($feedback_type == 1){
                                        echo'<button type="button" class="btn btn-default btn-sm check" data-container="body" title="Foglalkozás">
                                                <i class="fas fa-check"></i>
                                            </button>';
                                    }
                                ?>
                            </div>
                        </div>
                        <!-- /.mailbox-controls -->
                        <div class="mailbox-read-message">
                            <?= $feedback_text ?>
                        </div>
                        <!-- /.mailbox-read-message -->
                    </div>

                    <!-- /.card-footer -->
                    <div class="card-footer">
                        <div class="float-right">
                            <button type="button" class="btn btn-default"><i class="fas fa-trash-alt"></i> Törlés</button>
                            <?php
                                if($feedback_type == 1){
                            ?>
                                <button type="button" class="btn btn-default check"><i class="fas fa-check"></i> Foglalkozás</button>
                            <?php } ?>
                        </div>
                    </div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
    </section>

    <script>

        $(document).ready(function () {

           function yesCallback(){
               const urlParams = new URLSearchParams(window.location.search);

               let priority = urlParams.get('priority');

               console.log(priority)
               if(priority == undefined || priority == ''){
                   showPopup('error','Hiba! Nincs megadva prioritás!');
                   return false;
               }

               window.location.href = '/admin/bug/create?feedback_id=' + $('#feedback_id').val() + '&?priority=' + priority

            }
            $('.check').on('click',function () {
                btnLoading($(this),1,'Töltés..');
                answerPopUp(
                    "Biztosan törölni szeretnéd ezt az elemet?",'Igen','Nem',
                    function() {
                        yesCallback();
                        btnLoading($('.check'),0,'Feldolgozás');
                    },
                    function() {
                        btnLoading($(this),0,'Feldolgozás');
                    }
                );
            })
        })
    </script>
</div>
