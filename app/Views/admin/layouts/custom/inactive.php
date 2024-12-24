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
        <div class="error-page">

            <div class="error-content">
                <input type="hidden" id="text" value="<?= $errormsg ?>">
                <input type="hidden" id="url" value="<?= $url ?>">
            </div>
            <!-- /.error-content -->
        </div>
    </section>

    <script>
        $(document).ready(function () {
            showPopup('error',$('#text').val() + ' - átirányítás folyamatban..');
            setTimeout(function() {
                window.location.href = $('#url').val();
            }, 4000);
        })
    </script>
</section>