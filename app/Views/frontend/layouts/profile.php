<div class="content clear-fix">

    <ul class="no-list clear-fix section-list">

        <?php
            if(isset($message)){
                echo '<li class="text-center clear-fix">
                        <h1>'.$message.'</h1>
                    </li>';
            }else{
            ?>
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

                                <h3>profile details</h3>
                                <div>

                                    <div>

                                        <ul class="no-list list-1 clear-fix">

                                            <li>
                                                <span>1</span>
                                                <h5>Your email</h5>
                                                <p><?php echo $user_email; ?></p>
                                            </li>
                                            <li>
                                                <span>2</span>
                                                <h5>Login time</h5>
                                                <p><?php echo $login_time; ?></p>
                                            </li>
                                            <li>
                                                <span>3</span>
                                                <h5>Number of image generation remaining</h5>
                                                <p><?php echo $generating_count; ?></p>
                                            </li>
                                            <li>
                                                <span>4</span>
                                                <a href="/generation" class="button-black clear-fix">Image Generation</a>
                                            </li>


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
        <?php
            }

        ?>
    </ul>

</div>