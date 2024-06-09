<style>
    #feedback {
        width: 50%;
        margin: 0 auto;
    }
    @media(max-width: 992px) {
        #feedback {
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

                <h1 class="margin-bottom-0">Feedback</h1>
                <h1>Fill the fields</h1>
                <h3>You can send us feedback that can help us improve and expand our features</h3>

                <form name="feedback" id="feedback" action="" method="post" class="clear-fix">

                    <div class="clear-fix">

                        <ul class="no-list form-line">
                            <li class="clear-fix block">
                                <select id="feedback-type" name="feedback_type">
                                    <option value="1">Bug report</option>
                                    <option value="2">Feedback about the site/features</option>
                                    <option value="3">New feature/improvement ideas</option>
                                </select>
                            </li>
                            <li class="clear-fix block">
                                <label for="feedback-text">Add text here</label>
                                <textarea id="feedback-text" name="feedback_text"  rows="1" cols="1" style="overflow: hidden; height: 119px;"></textarea>
                            </li>

                            <li class="clear-fix block">
                                <input type="submit" id="submit" name="submit" class="button" value="Send"/>
                            </li>

                        </ul>

                    </div>

                </form>

        </li>
        <!-- /Main -->

    </ul>

</div>

<script type="text/javascript" src="/js/feedback.js"></script>