<?php
// Add AJAX action for license deactivation
add_action('wp_ajax_keyzy_deactivate_license', 'keyzy_deactivate_license_callback');

// Function to handle license deactivation
function keyzy_deactivate_license_callback() {

    // Get activation ID from POST data
    $activation_id = intval($_POST['activation_id']);
    // Get API credentials
    $api_key = defined('KEYZY_API_KEY') ? KEYZY_API_KEY : '';
    $app_id  = defined('KEYZY_APP_ID') ? KEYZY_APP_ID : '';

    // Make API request to deactivate license
    $url = "https://api.keyzy.io/v2/activations/$activation_id";
    $args = [
        'method'    => 'PUT',
        'headers'   => ['Content-Type' => 'application/json'],
        'body'      => json_encode([
            'app_id'    => $app_id,
            'api_key'   => $api_key,
            'activated' => false
        ]),
        'timeout'   => 15,
    ];
    $response = wp_remote_request($url, $args);

    // Handle response
    if (is_wp_error($response)) :
        wp_send_json_error(['message' => 'API error']);
    else :
        wp_send_json_success(['message' => 'License deactivated']);
    endif;

}