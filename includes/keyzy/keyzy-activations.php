<?php
function keyzy_display_activations($serial) {

    // Get API token from environment variable
    $api_key = defined('KEYZY_API_KEY') ? KEYZY_API_KEY : '';
    $app_id  = defined('KEYZY_APP_ID') ? KEYZY_APP_ID : '';

    // Validate inputs
    if (!$serial || !$api_key || !$app_id) {
        echo "<p>Missing serial, API key, or app ID.</p>";
        return;
    }

    // Fetch activations from Keyzy API
    $url = "https://api.keyzy.io/v2/activations/$serial?app_id=$app_id&api_key=$api_key";
    $response = wp_remote_get($url, ['timeout' => 15]);

    // Handle errors
    if (is_wp_error($response)) {
        echo "<p>Error fetching activations for serial $serial</p>";
        return;
    }

    // Parse the response
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    // Display activations
    if (!empty($data['data']) && is_array($data['data'])) {
        echo "<h4>Activations for Serial: " . esc_html($serial) . "</h4>";
        echo "<table><tr><th>Host ID</th><th>Device Tag</th><th>Activated</th><th>Created At</th></tr>";
        foreach ($data['data'] as $activation) {
            echo "<tr>";
            echo "<td>" . esc_html($activation['host_id'] ?? '') . "</td>";
            echo "<td>" . esc_html($activation['device_tag'] ?? '') . "</td>";
            echo "<td>" . (!empty($activation['activated']) ? 'Yes' : 'No') . "</td>";
            echo "<td>" . esc_html($activation['created_at'] ?? '') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No activations found for serial $serial.</p>";
    }
}