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
                        <form id="filter" method="GET" action="/admin/feedback">
                            <div class="form-check">
                                <input type="checkbox" name="opinion" class="form-check-input" id="opinion" <?php if(isset($opinion)){echo 'checked'; } ?>>
                                <label class="form-check-label" for="opinion"><small class="badge badge-primary">Vélemény</small></label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" name="dev" class="form-check-input" id="dev" <?php if(isset($dev)){echo 'checked'; }?>>
                                <label class="form-check-label"  for="dev"><small class="badge badge-success">Fejlesztési javaslat</small></label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" name="bug" class="form-check-input" id="bug" <?php if(isset($bug)){echo 'checked'; }?>>
                                <label class="form-check-label" for="bug"><small class="badge badge-danger">Bug report</small></label>
                            </div>
                            <div class="form-group">
                                <label for="user_id">Felhasználó id</label>
                                <input class="form-control" type="text" name="user_id" id="user_id" value="<?php if(isset($user_id)){echo $user_id; }?>">
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
                        <h3 class="card-title">Feedback lista</h3>
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
                                                Felhasználó ID
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >
                                                Feedback típus
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >
                                                Tartalom
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">
                                                Létrehozás ideje
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">
                                                Megtekint
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if(!empty($feedbacks)){
                                            foreach ($feedbacks as $feedback){
                                                echo'<tr>
                                                            <td>'.$feedback['feedback_id'].'</td>
                                                <td>'.$feedback['user_id'].'</td>';

                                                switch ($feedback['feedback_type']){
                                                    case '1':
                                                        echo '<td><small class="badge badge-danger">Bug</small></td>';
                                                        break;
                                                    case '2':
                                                        echo '<td><small class="badge badge-primary">Vélemény</small></td>';
                                                        break;
                                                    default:
                                                        echo '<td><small class="badge badge-success">Fejlesztési javaslat</small></td>';
                                                        break;
                                                }


                                                echo '<td>'.substr($feedback['feedback_text'], 0,30).' ...</td>
                                                    <td>'.$feedback['created_time'].'</td>
                                                    <td><a href="/admin/feedback/'.$feedback['feedback_id'].'" class="btn btn-primary"><i class="fas fa-eye"></i></a></td>
                                            </tr>';
                                            }
                                        }else{
                                            echo '<td colspan="5">Nincs mentett Feedback</td>';
                                        }
                                        ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th rowspan="1" colspan="1"" >
                                            ID
                                            </th>
                                            <th rowspan="1" colspan="1" >
                                                Felhasználó ID
                                            </th>
                                            <th rowspan="1" colspan="1" >
                                                Feedback típus
                                            </th>
                                            <th rowspan="1" colspan="1">
                                                Tartalom
                                            </th>
                                            <th rowspan="1" colspan="1">
                                                Létrehozás ideje
                                            </th>
                                            <th rowspan="1" colspan="1">
                                               Megtekint
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
                window.location.href = '/admin/feedback';
            })
        })

    </script>
</div>