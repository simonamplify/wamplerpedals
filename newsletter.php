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
        <input type="hidden" name="campaign_token" value="yAUf9" />
        <!-- Thank you page (optional) -->
        <input type="hidden" name="thankyou_url" value="https://www.wamplerpedals.com/sign-up-complete"/>
        <!-- Forward form data to your page (optional) -->
        <input type="hidden" name="forward_data" value="" />
        <!-- Subscriber button -->
        <input type="submit" value="I want in!" class="et_pb_button"/>
    </form>
</div>

'; ?>