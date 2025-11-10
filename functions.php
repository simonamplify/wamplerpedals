<?php
function custom_theme_scripts() {
    $parent_handle = 'Divi';
    wp_enqueue_style(
        'child-style',
        get_stylesheet_directory_uri() . '/css/stylesheet.css',
        array( $parent_handle ),
        filemtime( get_stylesheet_directory() . '/css/stylesheet.css' )
    );
    if ( class_exists('WooCommerce') && strpos($_SERVER['REQUEST_URI'], 'keyzy-licenses') !== false ) {
        wp_enqueue_style(
            'keyzy-style',
            get_stylesheet_directory_uri() . '/css/keyzy.css',
            array( 'child-style' ),
            filemtime( get_stylesheet_directory() . '/css/keyzy.css' )
        );
    }
    wp_enqueue_script(
        'list-js',
        get_stylesheet_directory_uri() . '/js/lib/list.min.js',
        null,
        null,
        true
    );
    wp_enqueue_script(
        'main-js',
        get_stylesheet_directory_uri() . '/js/main.min.js',
        array('list-js'),
        filemtime( get_stylesheet_directory() . '/js/main.min.js' ),
        true
    );
    add_filter('script_loader_tag', function($tag, $handle, $src) {
        if ( 'main-js' !== $handle ) return $tag;
        return '<script type="module" src="' . esc_url( $src ) . '"></script>';
    }, 10, 3);
}
add_action( 'wp_enqueue_scripts', 'custom_theme_scripts', 11 ); // 11 to ensure it runs after the parent theme's scripts
// Enqueue login styles
function my_logincustomCSSfile() {
    wp_enqueue_style('login-styles', get_stylesheet_directory_uri() . '/css/login_stylesheet.css');
}
add_action('login_enqueue_scripts', 'my_logincustomCSSfile');
// Change login logo url and title text
function my_loginURL() {
    return '/';
}
add_filter('login_headerurl', 'my_loginURL');
function my_loginURLtext() {
    return 'wamplerpedals.com';
}
add_filter('login_headertitle', 'my_loginURLtext');
// Create year shortcode
function year() {
    return date("Y");
}
add_shortcode('year', 'year');
// Change sale badge text to
add_filter('woocommerce_sale_flash', 'change_sale_text');
function change_sale_text() {
    return '<span class="onsale">On Sale</span>';
}
// Add cart button to shop archive pages
add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10);
// Change related products header
add_filter('woocommerce_product_upsells_products_heading', 'custom_related_products_heading');
function custom_related_products_heading() {
    return 'Related Products';
}
// Enable product search
function custom_remove_default_et_pb_custom_search() {
	remove_action( 'pre_get_posts', 'et_pb_custom_search' );
	add_action( 'pre_get_posts', 'custom_et_pb_custom_search' );
}
// Redirect to homepage after login/logout
add_filter('woocommerce_login_redirect', 'login_redirect');
function login_redirect($redirect_to) {
    return home_url();
}
add_action('wp_logout','logout_redirect');
function logout_redirect(){
    wp_redirect( home_url() );
    exit;
}
// Load artists with shortcode
function artistsDirectory() {
    ob_start();
    get_template_part( 'includes/artists' );
    return ob_get_clean(); 
}
add_shortcode('artistsDirectory', 'artistsDirectory');
// Change 'Related Products' heading on the cart page
add_filter('woocommerce_product_related_products_heading', 'cart_related_products_heading');
function cart_related_products_heading($heading) {
    if (is_cart()) {
        $heading = 'Before you go...';
    }
    return $heading;
}
// Exclude categories from FiboSearch plugin
add_filter( 'dgwt/wcas/search/product_cat/args', function ( $args ) {
    $args['exclude'] = array(779); // The IDs of categories to exclude
    return $args;
} );
// Add stock message to single product pages after the price 
add_action('woocommerce_single_product_summary', 'stockWarning', 11);
function stockWarning() {
    if ( locate_template( 'includes/stock-warning.php' ) ) {
        get_template_part( 'includes/stock-warning' );
    }
    return '';
}
// Load product recommendation with shortcode
// function productRecommendation_shortcode() {
//     require_once get_stylesheet_directory() . '/includes/product-recommendation.php';
//     return render_product_recommendation();
// }
// add_shortcode( 'productRecommendation', 'productRecommendation_shortcode' );

// KEYZY LICENSE INCLUDE
$keyzy_deactivate = get_theme_file_path( '/includes/keyzy/keyzy-deactivate.php' );
$keyzy_delete = get_theme_file_path( '/includes/keyzy/keyzy-delete.php' );
$keyzy_enqueue = get_theme_file_path( '/includes/keyzy/keyzy.php' );
if ( file_exists( $keyzy_enqueue ) ) {
    require_once $keyzy_delete;
    require_once $keyzy_deactivate;
    require_once $keyzy_enqueue;
} else {
    error_log( 'Missing include(s): ' 
        . ( file_exists( $keyzy_enqueue ) ? '' : $keyzy_enqueue . ' ' )
        . ( file_exists( $keyzy_deactivate ) ? '' : $keyzy_deactivate . ' ' )
        . ( file_exists( $keyzy_delete ) ? '' : $keyzy_delete )
    );
}
?>