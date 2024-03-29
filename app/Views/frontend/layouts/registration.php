<style>
    #reg-form {
        width: 50%;
        margin: 0 auto;
    }
    @media(max-width: 992px) {
        #reg-form {
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

            <h1 class="margin-bottom-0">Registration</h1>
            <h1>Fill the fields</h1>

            <form name="reg-form" id="reg-form" action="" method="post" class="clear-fix">

                <div class="clear-fix">

                    <ul class="no-list form-line">

                        <li class="clear-fix block">
                            <label for="reg-username">Your username</label>
                            <input type="text" name="reg-username" id="reg-username" value=""/>
                        </li>
                        <li class="clear-fix block">
                            <label for="reg-mail">Your email</label>
                            <input type="text" name="reg-mail" id="reg-mail" value=""/>
                        </li>
                        <li class="clear-fix block">
                            <label for="reg-password1">Your password</label>
                            <input type="password" name="reg-password1" id="reg-password1" value=""/>
                        </li>
                        <li class="clear-fix block">
                            <label for="reg-password2">Your password again</label>
                            <input type="password" name="reg-password2" id="reg-password2" value=""/>
                        </li>
                        <li class="clear-fix block">
                            <input type="submit" id="submit" name="submit" class="button" value="Login"/>
                        </li>

                    </ul>

                </div>

            </form>

        </li>
        <!-- /Main -->

    </ul>

</div>

</script>
<!-- /Content -->