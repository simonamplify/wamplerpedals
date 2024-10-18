<?php echo '

<div class="pluginSignUp grForm">
    <form action="https://app.getresponse.com/add_subscriber.html" accept-charset="utf-8" method="post" class="grid col2">
        <!-- Frist Name -->
        <fieldset>
            <label>First name*</label>
            <input type="text" name="first_name" placeholder="First name" required />
        </fieldset>
        <!-- Last Name -->
        <fieldset>
            <label>Second name*</label>
            <input type="text" name="last_name" placeholder="Second name" required />
        </fieldset>
        <!-- Email field (required) -->
        <fieldset>
            <label>Email*</label>
            <input type="text" name="email" placeholder="Email" required />
        </fieldset>
        <fieldset>
            <label>Phone (optional)</label>
            <input type="text" name="custom_phone" placeholder="Phone" />
            <div class="inputHint">North America only. <span>Must start with +1</span>.</div>
        </fieldset>
        <!-- List token -->
        <!-- Get the token at: https://app.getresponse.com/campaign_list.html -->
        <input type="hidden" name="campaign_token" value="Ki4MH" />
        <!-- Thank you page (optional) -->
        <input type="hidden" name="thankyou_url" value="' . get_site_url(null, '/sign-up-complete/', 'https') . '"/>
        <!-- Forward form data to your page (optional) 
        <input type="hidden" name="forward_data" value="" />-->
        <!-- Add subscriber to the follow-up sequence with a specified day (optional) -->
	    <input type="hidden" name="start_day" value="0" />
        <!-- Subscriber button -->
        <input type="submit" value="Submit" class="et_pb_button colSpanAll" />
    </form>
</div>

'; ?>