<?php
if ( class_exists( 'WooCommerce' ) ) {
    
    // Add Keyzy license endpoint
    function keyzy_license_endpoint() {
        add_rewrite_endpoint('keyzy-licenses', EP_ROOT | EP_PAGES);
    }
    add_action('init', 'keyzy_license_endpoint');

    // Add tab to WooCommerce account menu
    function keyzy_license_tab($items) {
        $items['keyzy-licenses'] = __('Product Licenses', 'wamplerpedals');
        return $items;
    }
    add_filter('woocommerce_account_menu_items', 'keyzy_license_tab');

    // Display content for the endpoint
    function keyzy_license_content() {
        // Include activations function
        require_once get_stylesheet_directory() . '/includes/keyzy/keyzy-activations.php';

        // Get API token from environment variable
        global $api_key;
        global $app_id;
        $api_key = defined('KEYZY_API_KEY') ? KEYZY_API_KEY : '';
        $app_id = defined('KEYZY_APP_ID') ? KEYZY_APP_ID : '';

        // If the user is not logged in, prompt to log in
        if (!is_user_logged_in()) {
            echo '<p>Please log in to view your licenses.</p>';
            return;
        }

        //// Use DOMDocument to parse the shortcode output

        // Get the shortcode HTML
        $shortcode_html = do_shortcode('[keyzy-downloads]');
        // Create an array to hold product serials
        $product_serials = [];
        libxml_use_internal_errors(true); // Suppress HTML warnings
        // Parse the HTML
        $dom = new DOMDocument();
        $dom->loadHTML($shortcode_html);
        // Find all <b> elements and extract serial numbers
        // foreach ($dom->getElementsByTagName('b') as $b) {
        //     if (strpos($b->nodeValue, 'Product Serial') !== false) {
        //         $serial = $b->parentNode->textContent;
        //         if (preg_match('/Product Serial\s*:\s*([A-Z0-9\-]+)/', $serial, $m)) {
        //             $product_serials[] = $m[1];
        //         }
        //     }
        // }
        $product_serials = ['M0W8-TCSU-FN07-ZKID-KQKA', 'KUUQ-MEUB-UJEM-JEE7-PZTY'];

        if (empty($product_serials)) {
            echo '<p>No product serials found.</p>';
            return;
        } else {
            echo '<h1>Your Product Licenses</h1>';
        }

        // Fetch and display SKU names for each serial
        foreach ($product_serials as $serial) {
            $url = "https://api.keyzy.io/v2/licenses/show-license/$serial?app_id=$app_id&api_key=$api_key";
            $response = wp_remote_get($url, ['timeout' => 15]);

            // Handle errors
            if (is_wp_error($response)) {
                echo "<p>Error fetching data for serial $serial</p>";
                continue;
            }

            // Parse the response
            $body = wp_remote_retrieve_body($response);
            $data = json_decode($body, true);

            // echo '<pre>';
            // print_r($data);
            // echo '</pre>';

            // Check and output sku_name
            if (!empty($data['data']['sku_name'])) {
                $sku_name = esc_html($data['data']['sku_name']);
                echo "<p>Serial: <strong>$serial</strong></p>";
                echo "<p><small>SKU Name: $sku_name</small></p>";
            } else {
                echo "<p>Serial: <strong>$serial</strong></p>";
                echo "<p><small>No associated SKU Name found</small></p>";
            }
            // Display activations for the serial
            keyzy_display_activations($serial);
        }
        
    }
    // Hook the content function to the endpoint action
    add_action('woocommerce_account_keyzy-licenses_endpoint', 'keyzy_license_content');
}