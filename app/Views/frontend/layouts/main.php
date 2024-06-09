<!-- Content -->
<div class="content clear-fix">

    <ul class="no-list clear-fix section-list">


        <!-- Main -->
        <li class="text-center clear-fix">

            <h1 class="margin-bottom-0">Make Your Workout</h1>
            <h1>Simple With Nostalgia</h1>

            <p class="subtitle-paragraph margin-top-20 margin-bottom-50 clear-fix">
                Morbi non massa arcu, sed molestie arcu tellus vitae vestibulum.
                <span class="bold">Libero lacus semper massa at sollicitudin dolor magna nulla velit.</span>
            </p>


                <?php if(isset($user_name)){
                   echo ' <a href="/profile/'.$user_id.'" class="button-black clear-fix">
                            <span class="click-here"></span>Profile</a>
                             <a href="/logout" class="button-black">Logout</a>
                             <a href="/packages" class="button-black">Buy</a>';

                }else{
                    echo ' <a href="/login" class="button-black clear-fix">
                            <span class="click-here"></span>Log in</a>
                             <a href="/registration" class="button-black">Sign up</a>';

                }
                
                ?>



        </li>
        <!-- /Main -->


    </ul>

</div>
<!-- /Content -->