<div class="content clear-fix">

    <ul class="no-list clear-fix section-list">

            <!-- Features -->
            <li>

                <h2>HI <?php echo $user_name; ?></h2>

                <p class="subtitle-paragraph">
                    Phasellus sagittis consectetur purus quis accumsan.
                    <span class="bold">Nullam et luctus purus praesent sollicitudin massa sed adipiscing bibendum.</span>
                </p>

                <div class="layout-50 clear-fix">

                    <!-- Left column -->
                    <div class="layout-50-left clear-fix">

                        <!-- Features list -->
                        <ul class="no-list list-2 clear-fix">

                            <!-- Item -->
                            <li>
                                <a href="<?php echo $menus['packages']; ?>"><h3>Get package</h3></a>
                                <p class="icon-1 icon-1-3">
                                    Vestibulum varius lectus massa, eget sodales era augu. Nullam in  magnat, at ultricies lectus. Pellentesque mado consequat lobortis. Maecenas dictu.
                                </p>
                            </li>
                            <!-- /Item -->

                            <!-- Item -->
                            <li>
                                <a href="<?php echo $menus['billing_address']; ?>"><h3>Billing addresses</h3></a>
                                <p class="icon-1 icon-1-1">
                                    Donec eget ultricies sapi. Sed porttitor, mauris ater lob facilisis, elit sapie eleifend ligula, et facilisis dolor odom vitae nunc. Phasellus ultricies eliteg.
                                </p>
                            </li>
                            <!-- /Item -->

                            <!-- Item -->
                            <li>
                                <a href="<?php echo $menus['payment_history']; ?>"><h3>Payment history</h3></a>
                                <p class="icon-1 icon-1-2">
                                    Praesent cursus lectus nec turpis luctus molest hendre. Suspendisse ligula orci, hendrerit vitae mattis non nibh dignissim at. Curabitur feugiat, leo quiset.
                                </p>
                            </li>
                            <!-- /Item -->

                            <!-- Item -->
                            <li>
                                <a href="<?php echo $menus['generating_history']; ?>"><h3>Generating history</h3></a>
                                <p class="icon-1 icon-1-3">
                                    Vestibulum varius lectus massa, eget sodales era augu. Nullam in  magnat, at ultricies lectus. Pellentesque mado consequat lobortis. Maecenas dictu.
                                </p>
                            </li>
                            <!-- /Item -->

                        </ul>
                        <!-- /Features list -->

                    </div>
                    <!-- /Left column -->

                    <!-- Right column -->
                    <div class="layout-50-right">

                        <!-- Accordion -->
                        <div class="nostalgia-accordion clear-fix">

                            <h3>Payment addresses</h3>
                            <div>

                                <div>

                                    <ul class="no-list list-1 clear-fix">


                                        <?php
                                        if($billing_addresses == false){
                                            echo '<li>
                                                        <span>0</span>
                                                        <h5>You have not registered billing addresses yet!</h5>
                                                        <p>Click <a href="/add_billing_address">here</a> to add</p>
                                                    </li>';
                                        }else{
                                            $count = 1;
                                            foreach ($billing_addresses as $billing_address){

                                                echo'<li>
                                                    <span>'.$count.'</span>
                                                    <h5>'.$billing_address['billing_code'].' '.$billing_address['billing_city'].' '.$billing_address['billing_address'].'</h5>
                                                    <p>';
                                                        if($billing_address['default'] == 1){
                                                            echo 'DEFAULT ADDRESS - <a href="/edit_billing_address/'.$billing_address['billing_data_id'].'">EDIT</a> - <a style="color:red" href="/delete_billing_address/'.$billing_address['billing_data_id'].'">DELETE</a></p>
                                                </li>';
                                                        }else{
                                                            echo '<a href="/edit_billing_address/'.$billing_address['billing_data_id'].'">EDIT</a></p>
                                                </li>';
                                                        }


                                                $count++;
                                            }
                                        }
                                        ?>

                                    </ul>

                                </div>

                            </div>


                        </div>
                        <!-- /Accordion -->

                    </div>
                    <!-- /Right column -->

                </div>

            </li>
            <!-- /Features -->

    </ul>

</div>