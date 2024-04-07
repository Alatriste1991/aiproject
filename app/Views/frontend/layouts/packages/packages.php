<style>
    .package_box{
        padding: 30px;
        border: 2px solid #1b1b1b;
        margin: 20px auto;
        max-width: 50%;
    }

    .package_box p {
        color: #1b1b1b;
        font-family: 'Dosis';
        text-transform: uppercase;
        margin: 5px 0;
        font-weight: 800;
    }

    .package_box a {
        padding: 5px 10px;
        border: 1px solid #1b1b1b;
        background: #1b1b1b;
    }

    .package_box a:hover {
        padding: 5px 10px;
        background: #ffffff;
        color: #1b1b1b
    }

    @media(max-width: 992px) {
        .packages {
            display: block;
        }
        .package_box{
            margin: 20px  auto
        }
    }
</style>

<div class="content clear-fix">

    <ul class="no-list clear-fix section-list">

        <!-- Main -->
        <li class="text-center clear-fix">

            <h1 class="margin-bottom-0">Make Your Workout</h1>
            <h1>Simple With Nostalgia</h1>
            <div class="packages">
<?php
           foreach($packages as $package){
               echo' <div class="package_box">
                        <h4>'.$package['package_name'].'</h4>
                        <p>price: '.$package['package_price'].' $</p>
                        <p>generated picture quantity: '.$package['picture_qty'].'</p>
                        <a href="/get_package/'.$package['package_id'].'">BUY</a>
                    </div>';
           }
?>
            </div>
        </li>

    </ul>

</div>