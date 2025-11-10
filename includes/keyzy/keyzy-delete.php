<?php
// Include Keyzy API functions
require_once get_stylesheet_directory() . '/includes/keyzy/keyzy-api.php';

// Add AJAX action for license deactivation
add_action('wp_ajax_keyzy_delete_license', 'keyzy_delete_license_callback');

// Function to handle license deactivation
function keyzy_delete_license_callback() {
    // Get activation ID from POST data
    $activation_id = intval($_POST['activation_id']);
    // Get API credentials
    $api_key = defined('KEYZY_API_KEY') ? KEYZY_API_KEY : '';
    $app_id  = defined('KEYZY_APP_ID') ? KEYZY_APP_ID : '';

    // Make API request to deactivate license
    $response = keyzy_delete_license_api($activation_id, $app_id, $api_key);

    // Handle response
    if (is_wp_error($response)) {
        wp_send_json_error(['message' => 'API error']);
    } else {
        wp_send_json_success(['message' => 'License deactivated']);
    }
}