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
            <div class="col-2 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Szűrés</h3>
                    </div>
                    <div class="card-body">
                        <form id="filter" method="GET" action="/admin/log">
                            <div class="form-check">
                                <input type="checkbox" name="info" class="form-check-input" id="info" value="<?php if(isset($info)){echo 'checked'; } ?>">
                                <label class="form-check-label" for="info"><small class="badge badge-primary">Info</small></label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" name="warning" class="form-check-input" id="warning" value="<?php if(isset($warning)){echo 'checked'; }?>">
                                <label class="form-check-label"  for="warning"><small class="badge badge-warning">Warning</small></label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" name="error" class="form-check-input" id="error" <?php if(isset($error)){echo 'checked'; }?>>
                                <label class="form-check-label" for="error"><small class="badge badge-danger">Error</small></label>
                            </div>
                            <div class="form-group">
                                <label for="user_id">Felhasználó id</label>
                                <input class="form-control" type="text" name="user_id" id="user_id" value="<?php if(isset($user_id)){echo $user_id; }?>">
                            </div>
                            <div class="form-group">
                                <label for="process">Folyamat</label>
                                <input class="form-control" type="text" name="process" id="process" value="<?php if(isset($process)){echo $process; }?>">
                            </div>
                            <div class="form-group">
                                <label for="ip">IP</label>
                                <input class="form-control" type="text" name="ip" id="ip" value="<?php if(isset($ip)){echo $ip; }?>">
                            </div>
                            <div class="form-group">
                                <label for="browser">Böngésző</label>
                                <input class="form-control" type="text" name="browser" id="browser" value="<?php if(isset($browser)){echo $browser; }?>">
                            </div>
                            <div class="form-group">
                                <label for="platform">Platform</label>
                                <input class="form-control" type="text" name="platform" id="platform" value="<?php if(isset($platform)){echo $platform; }?>">
                            </div>
                            <div class="form-group">
                                <label for="admin">Admin</label>
                                <select name="admin" id="admin" class="form-control">
                                    <option value="0" <?php if(isset($admin) && $admin == 0){echo 'selected="selected"'; }?>>Nem</option>
                                    <option value="1" <?php if(isset($admin) && $admin == 1){echo 'selected="selected"'; }?>">Igen</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Kezdő dátum</label>
                                <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                    <input name="start_date" type="text" class="form-control datetimepicker-input" data-target="#reservationdatetime" value="<?php if(isset($start_date)){echo $start_date; }?>">
                                    <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Végdátum</label>
                                <div class="input-group date" id="reservationdatetime2" data-target-input="nearest">
                                    <input name="due_date" type="text" class="form-control datetimepicker-input" data-target="#reservationdatetime2" value="<?php if(isset($due_date)){echo $due_date; }?>">
                                    <div class="input-group-append" data-target="#reservationdatetime2" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Keresés</button>
                            <button type="button" id="reset" class="btn btn-danger">Alaphelyzet</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-10  col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Logok listája</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row"><div class="col-sm-12 col-md-6">
                                </div><div class="col-sm-12 col-md-6">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="example2" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example2_info">
                                        <thead>
                                            <tr>
                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" >
                                                    ID
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >
                                                    Típus
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >
                                                    Folyamat
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >
                                                    Felhasználó id
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">
                                                    IP
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">
                                                    Böngésző
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">
                                                    Platform
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">
                                                    Információ
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">
                                                    Admin?
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">
                                                    Dátum
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if(!empty($logs)){
                                                foreach ($logs as $log){
                                                    echo'<tr>
                                                            <td>'.$log['log_id'].'</td>';

                                                   switch ($log['type']){
                                                       case 'warning':
                                                           echo '<td><small class="badge badge-warning"> '.$log['type'].'</small></td>';
                                                           break;
                                                       case 'error':
                                                           echo '<td><small class="badge badge-danger"> '.$log['type'].'</small></td>';
                                                           break;
                                                       default:
                                                           echo '<td><small class="badge badge-primary"> '.$log['type'].'</small></td>';
                                                           break;
                                                   }


                                                    echo '<td>'.$log['process'].'</td>
                                                            <td>'.$log['user'].'</td>
                                                            <td>'.$log['ip'].'</td>
                                                            <td>'.$log['browser'].'</td>
                                                            <td>'.$log['platform'].'</td>
                                                            <td>'.$log['info'].'</td>';
                                                    if($log['admin'] == 1){
                                                        echo '<td>Igen</td>';
                                                    }else{
                                                        echo '<td>Nem</td>';
                                                    }
                                                echo    '<td>'.$log['date'].'</td>
                                            </tr>';
                                                }
                                            }else{
                                                echo 'Nincs mentett log';
                                            }
                                        ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th rowspan="1" colspan="1"" >
                                                    ID
                                                </th>
                                                <th rowspan="1" colspan="1" >
                                                    Típus
                                                </th>
                                                <th rowspan="1" colspan="1" >
                                                    Folyamat
                                                </th>
                                                <th rowspan="1" colspan="1">
                                                    Felhasználó ID
                                                </th>
                                                <th rowspan="1" colspan="1">
                                                    IP
                                                </th>
                                                <th rowspan="1" colspan="1">
                                                    Böngésző
                                                </th>
                                                <th rowspan="1" colspan="1">
                                                    Platform
                                                </th>
                                                <th rowspan="1" colspan="1"">
                                                    Információ
                                                </th>
                                                <th rowspan="1" colspan="1">
                                                    Admin?
                                                </th>
                                                <th rowspan="1" colspan="1">
                                                    Dátum
                                                </th>
                                            </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-5">
                                    <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Összes találat: <?= $total ?> db</div>
                                </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                    <?= $links ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>

        </div>
    </div>

    </section>
    <script src="/admin_source/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script>

        $('#reservationdatetime').datetimepicker({
            format: 'yyyy-MM-DD'
        })
        $('#reservationdatetime2').datetimepicker({
            format: 'yyyy-MM-DD'
        })

        $(document).ready(function () {
            $('#reset').on('click',function () {
                window.location.href = '/admin/log';
            })
        })

    </script>
</div>