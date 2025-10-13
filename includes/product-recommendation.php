<?php
// Rendering function called only when shortcode is processed.
function render_product_recommendation() {
    // Ensure WooCommerce is active
    if ( ! class_exists( 'WooCommerce' ) ) {
        return '<div class="product-recommendation error">WooCommerce unavailable.</div>';
    }

    // Path to JSON data file and fallback product ID
    $json_file = get_stylesheet_directory() . '/data/pedal-recommendations.json';
    $default_recommendation_id = 247;

    // Collect raw query parameters (expected keys)
    $raw_params = array(
        'style'   => $_GET['style']   ?? '',
        'use'     => $_GET['use']     ?? '',
        'want' => $_GET['want'] ?? '',
    );

    // Normalization closure for consistent matching
    $normalize = function( $v ) {
        if ($v === null) return '';
        $v = rawurldecode( $v );                       // Decode percent-encoding
        $v = html_entity_decode( $v, ENT_QUOTES | ENT_HTML5, 'UTF-8' ); // Decode HTML entities
        $v = str_replace('_', ' ', $v);                // Allow underscores as spaces
        $v = preg_replace('/\s*&\s*/', ' & ', $v);     // Normalize spacing around &
        $v = preg_replace('/\s+/', ' ', $v);           // Collapse multiple spaces
        return strtolower( trim( $v ) );               // Case-insensitive compare
    };

    // Normalized parameters
    $params = array_map( $normalize, $raw_params );

    // Basic guard if nothing provided
    if ( $params['style'] === '' && $params['use'] === '' && $params['want'] === '' ) {
        return '<div class="product-recommendation notice">Something went wrong... Please try again.</div>';
    }

    // Static cache of JSON data (only read once per request)
    static $recommendation_data = null;
    if ( $recommendation_data === null ) {
        if ( is_readable( $json_file ) ) {
            $data = json_decode( file_get_contents( $json_file ), true );
            $recommendation_data = is_array( $data ) ? $data : array();
        } else {
            $recommendation_data = array(); // Missing file -> empty dataset
        }
    }

    // Attempt to find a matching recommendation
    $matched_id = null;
    foreach ( $recommendation_data as $row ) {
        if ( ! is_array( $row ) ) continue;
        $row_style   = isset($row['Style'])   ? $normalize($row['Style'])   : '';
        $row_use     = isset($row['Use'])     ? $normalize($row['Use'])     : '';
        $row_want = isset($row['Want']) ? $normalize($row['Want']) : '';
        if ( $row_style === $params['style'] && $row_use === $params['use'] && $row_want === $params['want'] ) {
            if ( ! empty( $row['Recommendation'] ) ) {
                $matched_id = trim( $row['Recommendation'] );
            }
            break; // Stop after first match
        }
    }

    // If multiple IDs provided and comma-separated, pick the first
    if ( $matched_id && strpos($matched_id, ',') !== false ) {
        $matched_id = trim( explode(',', $matched_id)[0] );
    }

    // Use matched or fallback product ID
    $product_id = $matched_id ?: $default_recommendation_id;
    if ( ! $product_id ) {
        return '<div class="product-recommendation not-found">No recommendation found.</div>';
    }

    // Load WooCommerce product
    $product = wc_get_product( $product_id );
    if ( ! $product ) {
        return '<div class="product-recommendation not-found">Recommended product unavailable.</div>';
    }

    // Gather product display data
    $title        = esc_html( $product->get_name() );
    $short_desc   = apply_filters( 'woocommerce_short_description', $product->get_short_description() );
    $price_html   = $product->get_price_html();
    $permalink    = get_permalink( $product_id );

    // Responsive image (with placeholder fallback)
    $image_id = $product->get_image_id();
    if ( $image_id ) {
        $image_html = wp_get_attachment_image(
            $image_id,
            'medium',
            false,
            array(
                'class'   => 'product-recommendation-image-img',
                'loading' => 'lazy',
                'alt'     => $product->get_name()
            )
        );
    } else {
        $placeholder = wc_placeholder_img_src();
        $image_html  = '<img src="' . esc_url( $placeholder ) . '" alt="" class="product-recommendation-image-img" loading="lazy" />';
    }

    // Add to cart button via shortcode
    $add_to_cart  = do_shortcode( '[add_to_cart id="' . intval($product_id) . '" show_price="false" style=""]' );

    // Prepare decoded params for display
    $decode_for_display = function( $v ) {
        return esc_html( html_entity_decode( urldecode( $v ), ENT_QUOTES | ENT_HTML5, 'UTF-8' ) );
    };
    $display_params = array(
        'style'   => $decode_for_display( $raw_params['style'] ),
        'use'     => $decode_for_display( $raw_params['use'] ),
        'want' => $decode_for_display( $raw_params['want'] ),
    );

    // Output buffer for HTML
    ob_start(); ?>
    <!--<p style="color:white;">
        <strong>Style:</strong> <?php echo $display_params['style'] ?: '<em>n/a</em>'; ?> |
        <strong>Use:</strong> <?php echo $display_params['use'] ?: '<em>n/a</em>'; ?> |
        <strong>Want:</strong> <?php echo $display_params['want'] ?: '<em>n/a</em>'; ?>
    </p>-->
    <div class="product-recommendation" data-product-id="<?php echo esc_attr( $product_id ); ?>">
        <p class="product-recommendation-intro">Based on your preferences below, your recommended pedal is...</p>
        <div class="product-recommendation-inner">
            <div class="product-recommendation-details">
                <div class="product-recommendation-details-inner">
                    
                    <h1 class="product-recommendation-title">
                        <a href="<?php echo esc_url( $permalink ); ?>"><?php echo $title; ?></a>
                    </h1>
                    <?php if ( $short_desc ): ?>
                        <div class="product-recommendation-excerpt"><?php echo wp_kses_post( $short_desc ); ?></div>
                    <?php endif; ?>
                    <div class="product-recommendation-price"><?php echo wp_kses_post( $price_html ); ?></div>
                    <div class="product-recommendation-buttons">
                        <a class="button drkBtn" href="<?php echo esc_url( $permalink ); ?>">View Product</a>
                        <div class="product-recommendation-cart"><?php echo $add_to_cart; ?></div>
                    </div>
                    
                </div>
            </div>
            <div class="product-recommendation-image">
                <a href="<?php echo esc_url( $permalink ); ?>">
                    <?php echo $image_html; ?>
                </a>
            </div>
        </div>
    </div>
    <?php
    // Return buffered HTML
    return ob_get_clean();
}