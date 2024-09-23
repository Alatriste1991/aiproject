<style>
    table{
        width: 100%;
        margin: 0 auto;
        text-align: center;
        border-collapse: collapse;
    }
    table thead th{
        padding-top: 12px;
        padding-bottom: 12px;
        background-color: #000000;
        color: white;
    }
    table tbody td{
        border: 1px solid #000000;
        padding: 8px;

    }
    table tr:nth-child(even){background-color: #f2f2f2;}

    table tr:hover {background-color: #ddd;}
    @media(max-width: 992px) {
        #add-billing-data-form {
            width: inherit;
            margin: inherit;
        }

    }
</style>
<!-- Content -->
<div class="content clear-fix">

    <ul class="no-list clear-fix section-list">

        <!-- Main -->
        <li class="text-center clear-fix">

            <h1 class="margin-bottom-0">Your generated images</h1>
            <h1>You can download image if you click url below</h1>
            <?php if(!empty($data)){ ?>
            <table>
                <thead>
                <tr>
                    <th>#</th>
                    <th>Prompt</th>
                    <th>Download</th>
                    <th>Created Time</th>
                    <th>Preview</th>
                </tr>
                </thead>
                <tbody>
                <?php $count = 1;
                foreach ($data as $adat){

                    echo '<tr><td>'.$count.'</td>
                                  <td>'.$adat['prompt'].'</td>
                                  <td><a href="/downloadImage/'.$adat['image_url_id'].'" class="button-black clear-fix" target="_blank">DOWNLOAD</a> </td>
                                  <td>'.$adat['created_time'].'</td>
                                  <td><img style="width: 50%" src="data:image/png;base64,'.$adat['image'].'"></td>
                                  </tr>';
                    $count++;
                } ?>
                </tbody>
            </table>
                <?= $links ?>
            <?php }else{ ?>
                <h3>You haven't generated any pictures yet. <br><br> <a href="/generation" class="button-black clear-fix">Do it</a> </h3>
            <?php } ?>

        </li>
        <!-- /Main -->

    </ul>

</div>