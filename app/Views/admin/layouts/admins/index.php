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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Adminok listája</h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 180px;">
                                <div class="input-group-append">
                                    <a class="btn btn-success" href="/admin/admins/add">Új felhasználó hozzáadása</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Név</th>
                                <th>Email</th>
                                <th>Státusz</th>
                                <th>Műveletek</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                                foreach($admins as $admin){
                                    $status = ($admin['admin_status'] == 1)? "Aktív" : "Inaktív";
                                    echo '<tr>
                                            <td>'.$admin['admin_id'].'</td>
                                            <td>'.$admin['admin_name'].'</td>
                                            <td>'.$admin['admin_email'].'</td>
                                            <td>'.$status.'</td>
                                            <td><a class="btn btn-warning" href="/admin/admins/edit/'.$admin['admin_id'].'">Szerkesztés</a>&nbsp<a class="btn btn-danger" href="/admin/admins/delete/'.$admin['admin_id'].'">Törlés</a></td>
                                        </tr>';
                                }

                            ?>

                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>

    </section>
    <!-- /.content -->
</div>