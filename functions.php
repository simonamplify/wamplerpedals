<?php
function custom_theme_scripts() {
    $parent_style = 'Divi';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style )
    );
    wp_enqueue_script( 'list-js', get_bloginfo( 'stylesheet_directory' ) . '/js/list.min.js', null, null, true);
    wp_enqueue_script( 'main-js', get_bloginfo( 'stylesheet_directory' ) . '/js/main.min.js', array('list-js'), null, true);
}
add_action( 'wp_enqueue_scripts', 'custom_theme_scripts' );
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
    get_template_part( 'artists' );
    return ob_get_clean(); 
}
add_shortcode('artistsDirectory', 'artistsDirectory');
// Load newsletter form with shortcode
function newsletterSignUp() {
    ob_start();
    get_template_part( 'newsletter' );
    return ob_get_clean(); 
}
add_shortcode('newsletterSignUp', 'newsletterSignUp');
?>