<style>
    #buy-package-form {
        width: 50%;
        margin: 0 auto;
    }

    @media(max-width: 992px) {
        #buy-package-form {
            width: inherit;
            margin: inherit;
        }
        /*#select_addresses{
            width: 648px;
        }*/
    }
    /*@media(max-width: 768px) {

        #select_addresses{
            width: 358px;
        }
    }
    @media(max-width: 478px) {

        #select_addresses{
            width: 238px
        }
    }*/
</style>
<!-- Content -->
<div class="content clear-fix">

    <ul class="no-list clear-fix section-list">

        <!-- Main -->
        <li class="text-center clear-fix">

            <h1 class="margin-bottom-0">Add payment details</h1>
            <h1>Fill the fields</h1>

            <form name="buy-package-form" id="buy-package-form" action="" method="post" class="clear-fix">

                <div class="clear-fix">

                    <ul class="no-list form-line">
                        <li class="clear-fix block">
                            <span style="float: left;color:#ffffff">Selected Package</span><br>
                            <input type="text" value="<?php echo $package['package_name'] ?> " disabled>
                            <input type="hidden" name="buy-package-id" id="buy-package-id" value="<?php echo $package['package_id'] ?>">
                        </li>
                        <li class="clear-fix block">

                            <?php
                            if($billing_addresses != false){

                                echo'<select id="select_addresses">
                                    <option value="">Select address</option>';
                                foreach($billing_addresses as $billing_address){
                                    echo '<option value="'.$billing_address['billing_data_id'].'">'.$billing_address['billing_code'].' '.$billing_address['billing_city'].' '.$billing_address['billing_address'].'</option>' ;
                                }
                                echo'</select>';
                            }
                            ?>

                        </li>
                        <li class="clear-fix block">
                            <label for="buy-package-name">Your name</label>
                            <input type="text" name="buy-package-name" id="buy-package-name" value=""/>
                        </li>
                        <li class="clear-fix block">
                            <label for="buy-package-country">Country</label>
                            <input type="text" name="buy-package-country" id="buy-package-country" value=""/>
                        </li>
                        <li class="clear-fix block">
                            <label for="buy-package-county">County</label>
                            <input type="text" name="buy-package-county" id="buy-package-county" value=""/>
                        </li>
                        <li class="clear-fix block">
                            <label for="buy-package-code">Code</label>
                            <input type="text" name="buy-package-code" id="buy-package-code" value=""/>
                        </li>
                        <li class="clear-fix block">
                            <label for="buy-package-city">City</label>
                            <input type="text" name="buy-package-city" id="buy-package-city" value=""/>
                        </li>
                        <li class="clear-fix block">
                            <label for="buy-package-address">Street etc.</label>
                            <input type="text" name="buy-package-address" id="buy-package-address" value=""/>
                        </li>
                        <li class="clear-fix block">
                            <?php

                            echo'<select id="buy-package-payment-method" name="buy-package-payment-method">
                                <option value="">Select payment method</option>';
                            foreach($payment_methods as $payment_method){
                                echo '<option value="'.$payment_method['payment_id'].'">'.$payment_method['payment_name'].'</option>' ;

                            }
                            echo'</select>';

                            ?>
                        </li>
                        <li class="clear-fix block">
                            <input type="submit" id="submit" name="submit" class="button" value="Buy"/>
                        </li>


                    </ul>

                </div>

            </form>

        </li>
        <!-- /Main -->

    </ul>

</div>

<script>
    $(document).ready(function(){
        $('#select_addresses').on('change',function () {
            $.ajax({
                type: 'POST',
                url: '/select_addresses',
                data: {
                    'id': $(this).val()
                },
                dataType: 'json',
                success: function(data) {
                    $('#buy-package-name').val(data.billing_name)
                    $('#buy-package-country').val(data.billing_country)
                    $('#buy-package-county').val(data.billing_county)
                    $('#buy-package-code').val(data.billing_code)
                    $('#buy-package-city').val(data.billing_city)
                    $('#buy-package-address').val(data.billing_address)

                    $('label').css("opacity",'0');
                },
                error: function(error){
                    //console.log(error);
                }
            });
        })
    })
</script>
<script type="text/javascript" src="/js/billing_address.js"></script>
<script type="text/javascript" src="/js/add_order.js"></script>
<!-- /Content -->