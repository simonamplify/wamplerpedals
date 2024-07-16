<?php echo '

<div class="et_pb_newsletter_form newsletterSignUp">
    <form action="https://app.getresponse.com/add_subscriber.html" accept-charset="utf-8" method="post">
        <!-- Name -->
        <p class="et_pb_newsletter_field">
            <input type="text" name="name" placeholder="Name" />
        </p>
        <!-- Email field (required) -->
        <p class="et_pb_newsletter_field">
            <input type="text" name="email" placeholder="Email" required/>
        </p>
        <!-- List token -->
        <!-- Get the token at: https://app.getresponse.com/campaign_list.html -->
        <input type="hidden" name="campaign_token" value="5NwKw" />
        <!-- Thank you page (optional) -->
        <input type="hidden" name="thankyou_url" value="https://www.wamplerpedals.com/sign-up-complete"/>
        <!-- Add subscriber to the follow-up sequence with a specified day (optional) -->
	    <input type="hidden" name="start_day" value="0" />
        <!-- Subscriber button -->
        <input type="submit" value="I want in!" class="et_pb_button"/>
    </form>
</div>

'; ?>