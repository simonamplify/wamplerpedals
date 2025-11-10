<?php
// Check if WooCommerce is active
if ( class_exists( 'WooCommerce' ) ) {
    
    // Add Keyzy license endpoint
    function keyzy_license_endpoint() {
        add_rewrite_endpoint('keyzy-licenses', EP_ROOT | EP_PAGES);
    }
    add_action('init', 'keyzy_license_endpoint');

    // Add tab to WooCommerce account menu
    function keyzy_license_tab($items) {
        // Remove and store the logout item
        $logout = $items['customer-logout'];
        unset($items['customer-logout']);

        // Add your custom tab
        $items['keyzy-licenses'] = __('Product Licenses', 'wamplerpedals');

        // Re-add the logout item at the end
        $items['customer-logout'] = $logout;

        return $items;
    }
    add_filter('woocommerce_account_menu_items', 'keyzy_license_tab');

    // Display content for the endpoint
    function keyzy_license_content() {

        // If the user is not logged in, prompt to log in
        if (!is_user_logged_in()) {
            echo '<p>Please log in to view your licenses.</p>';
            return;
        }

        // Get API token from environment variable
        $api_key = defined('KEYZY_API_KEY') ? KEYZY_API_KEY : '';
        $app_id = defined('KEYZY_APP_ID') ? KEYZY_APP_ID : '';

        // Include API functions
        require_once get_stylesheet_directory() . '/includes/keyzy/keyzy-api.php';
        
        // Include activations function
        require_once get_stylesheet_directory() . '/includes/keyzy/keyzy-activations.php';

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
        foreach ($dom->getElementsByTagName('b') as $b) {
            if (strpos($b->nodeValue, 'Product Serial') !== false) {
                $serial = $b->parentNode->textContent;
                if (preg_match('/Product Serial\s*:\s*([A-Z0-9\-]+)/', $serial, $m)) {
                    $product_serials[] = $m[1];
                }
            }
        }

        // Check if any serials were found and display messages
        if (empty($product_serials)) {
            echo '<div class="keyzy-licenses-info"><h2>Your Product Licenses</h2>';
            echo '<p>No product serials found.</p></div>';
            return;
        } else {
            echo '<div class="keyzy-licenses-info"><h2>Your Product Licenses</h2>';
            echo '<p>Below are the Product License Keys associated with your account. You can deactivate a license from a device by clicking the "Deactivate" button and confirming deactivation. This will disconnect the license from its current device, allowing you to activate it on a different device.</p>';
            echo '<p>You can download the latest versions of your purchased plugins from the <a href="/account/downloads/">Download Area</a> in your account. They are also available on their respective product pages.</p></div>';
        }

        echo '<div id="keyzy-licenses-list" role="region" aria-label="Your Product Licenses">';

        // Fetch and display SKU names for each serial
        foreach ($product_serials as $serial) {
            // Get license data from Keyzy API
            $data = keyzy_get_license_data($serial, $app_id, $api_key);
            if (is_wp_error($data)) {
                echo "<p>{$data->get_error_message()}</p>";
                continue;
            }

            // Get product data from Keyzy API
            $product_data = keyzy_get_product_data($serial, $app_id, $api_key);
            if (is_wp_error($product_data)) {
                echo "<p>{$product_data->get_error_message()}</p>";
                continue;
            }
            
            // Get max host count
            $max_host_count = isset($product_data['data'][0]['max_host_count']) ? intval($product_data['data'][0]['max_host_count']) : '';

            echo '<div class="keyzy-license" role="region" aria-label="License for serial ' . esc_attr($serial) . '">';
                // Check and output sku_name
                if (!empty($data['data']['sku_name'])) {
                    $sku_name = esc_html($data['data']['sku_name']);
                    echo "<h3>Serial: <strong>$serial</strong></h3>";
                    echo '<small class="sku">Plugin SKU: <span>' . $sku_name . '</span></small>';
                } else {
                    echo "<h3>Serial: <strong>$serial</strong></h3>";
                    echo "<small>No Plugin SKU found</small>";
                }
                // Display activations for the serial
                keyzy_display_activations($serial, $api_key, $app_id, $max_host_count);
            echo '</div>';
        }
        
        echo '</div>';

    }

    // Hook the content function to the endpoint action
    add_action('woocommerce_account_keyzy-licenses_endpoint', 'keyzy_license_content');

}