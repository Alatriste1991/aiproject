<style>
    #image-generation {
        width: 50%;
        margin: 0 auto;
    }
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

            <?php if($accept == true){ ?>

            <h1 class="margin-bottom-0">Add image details</h1>
            <h1>Fill the fields</h1>
            <h3>By clicking the generate button, you accept our generation guidelines</h3>

            <form name="image_generation" id="image-generation" action="" method="post" class="clear-fix">

                <div class="clear-fix">

                    <ul class="no-list form-line">

                        <li class="clear-fix block">
                            <label for="generation-text">Add text here</label>
                            <textarea id="generation-text" name="generation_text"  rows="1" cols="1" style="overflow: hidden; height: 119px;"></textarea>
                        </li>

                        <li class="clear-fix block">
                            <input type="submit" id="submit" name="submit" class="button" value="Generate"/>
                        </li>

                    </ul>

                </div>

            </form>

            <?php }else{ ?>
                <h1 class="margin-bottom-0">Add image details</h1>
                <h1>You can't generate image!</h1>
                <h3>You have used up all available tokens</h3>
            <?php } ?>

        </li>
        <!-- /Main -->

    </ul>

</div>

<script type="text/javascript" src="/js/generation.js"></script>