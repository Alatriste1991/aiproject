<style>
    #edit-billing-data-form {
        width: 50%;
        margin: 0 auto;
    }
    @media(max-width: 992px) {
        #edit-billing-data-form {
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

            <h1 class="margin-bottom-0">Add payment details</h1>
            <h1>Fill the fields</h1>
<input type="hidden" id="billing_data_id" value="<?php echo $billing_address['billing_data_id'] ?>">
            <form name="edit-billing-data-form" id="edit-billing-data-form" action="" method="post" class="clear-fix">

                <div class="clear-fix">

                    <ul class="no-list form-line">

                        <li class="clear-fix block">
                            <label for="add-billing-data-name">Your name</label>
                            <input type="text" name="add-billing-data-name" id="add-billing-data-name" value="<?php echo $billing_address['billing_name'] ?>"/>
                        </li>
                        <li class="clear-fix block">
                            <label for="add-billing-data-country">Country</label>
                            <input type="text" name="add-billing-data-country" id="add-billing-data-country" value="<?php echo $billing_address['billing_country']; ?>"/>
                        </li>
                        <li class="clear-fix block">
                            <label for="add-billing-data-county">County</label>
                            <input type="text" name="add-billing-data-county" id="add-billing-data-county" value="<?php echo $billing_address['billing_county']; ?>"/>
                        </li>
                        <li class="clear-fix block">
                            <label for="add-billing-data-code">Code</label>
                            <input type="text" name="add-billing-data-code" id="add-billing-data-code" value="<?php echo $billing_address['billing_code']; ?>"/>
                        </li>
                        <li class="clear-fix block">
                            <label for="add-billing-data-city">City</label>
                            <input type="text" name="add-billing-data-city" id="add-billing-data-city" value="<?php echo $billing_address['billing_city']; ?>"/>
                        </li>
                        <li class="clear-fix block">
                            <label for="add-billing-data-address">Street etc.</label>
                            <input type="text" name="add-billing-data-address" id="add-billing-data-address" value="<?php echo $billing_address['billing_address']; ?>"/>
                        </li>
                        <li class="clear-fix block">
                            <select name="add-billing-data-default" id="add-billing-data-default">
                                <?php
                                    if($billing_address['default'] == 1){
                                        echo'
                                        <option value="0">Default address?</option>
                                        <option value="0">No</option>
                                        <option value="1" selected>Yes</option>
                                        ';
                                    }else{
                                        echo'
                                        <option value="0">Default address?</option>
                                        <option value="0" selected>No</option>
                                        <option value="1" >Yes</option>
                                        ';
                                    }
                                ?>

                            </select>
                        </li>
                        <li class="clear-fix block">
                            <input type="submit" id="submit" name="submit" class="button" value="Edit"/>
                        </li>

                    </ul>

                </div>

            </form>

        </li>
        <!-- /Main -->

    </ul>

</div>

<script type="text/javascript" src="/js/billing_address.js"></script>
<!-- /Content -->