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

            <h1 class="margin-bottom-0">Your order history</h1>
            <h1>You can check you orders below</h1>
            <?php if(!empty($orders)){ ?>
                <table>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Package name</th>
                        <th>Price</th>
                        <th>Picture Qty</th>
                        <th>Order date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $count = 1;
                    foreach ($orders as $order){

                        echo '<tr><td>'.$count.'</td>
                                  <td>'.$order['order_package_name'].'</td>
                                  <td>'.$order['order_package_price'].' €</td>
                                  <td>'.$order['order_picture_qty'].'</td>
                                  <td>'.$order['created_time'].'</td>
                                  </tr>';

                        $count++;
                    } ?>
                    </tbody>
                </table>

            <?php }else{ ?>
                <h3>You haven't bought any package yet. <br><br> <a href="/packages" class="button-black clear-fix">Do it</a> </h3>
            <?php } ?>

        </li>
        <!-- /Main -->

    </ul>

</div>