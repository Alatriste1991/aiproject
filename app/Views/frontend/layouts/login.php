<!-- Content -->
<style>
    #login-form {
        width: 50%;
        margin: 0 auto;
    }
    @media(max-width: 992px) {
        #login-form {
            width: inherit;
            margin: inherit;
        }

    }
</style>
<div class="content clear-fix">

    <ul class="no-list clear-fix section-list">

        <!-- Main -->
        <li class="text-center clear-fix">

            <h1 class="margin-bottom-0">Login</h1>
            <h1>Fill the fields</h1>

            <form name="login-form" id="login-form" action="" method="post" class="clear-fix">

                <div class="clear-fix">

                    <ul class="no-list form-line">

                        <li class="clear-fix block">
                            <label for="login-mail">Your email</label>
                            <input type="text" name="login-mail" id="login-mail" value=""/>
                        </li>
                        <li class="clear-fix block">
                            <label for="login-password">Your password</label>
                            <input type="password" name="login-password" id="login-password" value=""/>
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

<!-- /Content -->