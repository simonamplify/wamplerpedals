<?php
// Function to get license data from Keyzy API
function keyzy_get_license_data($serial, $app_id, $api_key) {
    $url = "https://api.keyzy.io/v2/licenses/show-license/$serial?app_id=$app_id&api_key=$api_key";
    $response = wp_remote_get($url, ['timeout' => 15]);

    // Handle errors
    if (is_wp_error($response)) {
        return new WP_Error('keyzy_api_error', "Error fetching data for serial $serial");
    }

    // Parse the response
    $body = wp_remote_retrieve_body($response);
    return json_decode($body, true);
}

// Function to deactivate a license via Keyzy API
function keyzy_deactivate_license_api($activation_id, $app_id, $api_key) {
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
    return wp_remote_request($url, $args);
}

// Function to get activations from Keyzy API
function keyzy_get_activations($serial, $app_id, $api_key) {
    $url = "https://api.keyzy.io/v2/activations/$serial?app_id=$app_id&api_key=$api_key";
    $response = wp_remote_get($url, ['timeout' => 15]);

    // Handle errors
    if (is_wp_error($response)) {
        return $response;
    }

    // Parse the response
    $body = wp_remote_retrieve_body($response);
    return json_decode($body, true);
}

// Function to get product data from Keyzy API
function keyzy_get_product_data($serial, $app_id, $api_key) {
    $url = "https://api.keyzy.io/v2/licenses/products";
    $args = [
        'method'  => 'POST',
        'headers' => ['Content-Type' => 'application/json'],
        'body'    => json_encode([
            'app_id'  => $app_id,
            'api_key' => $api_key,
            'serial'  => $serial
        ]),
        'timeout' => 15,
    ];
    $response = wp_remote_post($url, $args);
    if (is_wp_error($response)) {
        return new WP_Error('keyzy_api_error', "Error fetching product data for serial $serial");
    }
    $body = wp_remote_retrieve_body($response);
    return json_decode($body, true);
}

// Function to deactivate a license via Keyzy API
function keyzy_delete_license_api($activation_id, $app_id, $api_key) {
    $url = "https://api.keyzy.io/v2/activations/$activation_id";
    $args = [
        'method'    => 'DELETE',
        'headers'   => ['Content-Type' => 'application/json'],
        'body'      => json_encode([
            'app_id'    => $app_id,
            'api_key'   => $api_key
        ]),
        'timeout'   => 15,
    ];
    return wp_remote_request($url, $args);
}