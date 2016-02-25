<?php
/**
 * Plugin Name: AgriLife Core
 * Plugin URI: https://github.com/AgriLife/AgriLife-Core
 * Description: Core functionality for Texas A&M AgriLife sites
 * Version: 1.0
 * Author: J. Aaron Eaton
 * Author URI: http://channeleaton.com
 * Author Email: aaron@channeleaton.com
 * License: GPL2+
 */

require 'vendor/autoload.php';

define( 'AG_CORE_DIRNAME', 'agrilife-core' );
define( 'AG_CORE_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'AG_CORE_DIR_FILE', __FILE__ );
define( 'AG_CORE_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'AG_CORE_TEMPLATE_PATH', AG_CORE_DIR_PATH . 'templates' );

// Register plugin activation functions
$activate = new \AgriLife\Core\Activate;
register_activation_hook( __FILE__, array( $activate, 'run') );

// Register plugin deactivation functions
$deactivate = new \AgriLife\Core\Deactivate;
register_deactivation_hook( __FILE__, array( $deactivate, 'run' ) );

// Customize widgets
$agrilife_core_widgets = new \AgriLife\Core\Widgets();

// Remove unwanted widgets
$agrilife_remove_widgets = new \AgriLife\Core\RemoveWidgets();

// Add 'children' shortcode
$agrilife_core_shortcode_children = new \AgriLife\Core\Shortcode\Children();

// Add the loop shortcode
$agrilife_core_shortcode_loop = new \AgriLife\Core\Shortcode\Loop();

// Add the loop shortcode
$agrilife_core_shortcode_loop = new \AgriLife\Core\Accessibility();

// Add page templates
$agrilife_template_members_only = new \AgriLife\Core\PageTemplate();
$agrilife_template_members_only->with_path( AG_CORE_TEMPLATE_PATH )->with_file('members-only')->with_name( 'Members Only' );
$agrilife_template_members_only->register();

$agrilife_template_redirect = new \AgriLife\Core\PageTemplate();
$agrilife_template_redirect->with_path( AG_CORE_TEMPLATE_PATH )->with_file( 'redirect' )->with_name( 'Redirect' );
$agrilife_template_redirect->register();

$agrilife_child_list_template = new \AgriLife\Core\PageTemplate();
$agrilife_child_list_template->with_path( AG_CORE_TEMPLATE_PATH )->with_file( 'children' )->with_name( 'Child Page List' );
$agrilife_child_list_template->register();

$agrilife_template_landing = new \AgriLife\Core\PageTemplate();
$agrilife_template_landing->with_path( AG_CORE_TEMPLATE_PATH )->with_file( 'landing' )->with_name( 'Landing Page 2' );
$agrilife_template_landing->register();

// All child plugins should hook into 'agrilife_core_init' where necessary

add_action( 'plugins_loaded', function() {
    if ( class_exists( 'acf' ) ) {
        $agrilife_core_fields = new \AgriLife\Core\CustomFields( 'Agency Details', AG_CORE_DIR_PATH . '/fields' );
        $agrilife_service_fields = new \AgriLife\Core\CustomFields( 'Services', AG_CORE_DIR_PATH . '/fields' );
        require_once(AG_CORE_DIR_PATH . '/fields/landing-details.php');
        do_action('agrilife_core_init');
    }
}, 15);
add_action( 'admin_init', function(){
    if ( !class_exists( 'acf' ) ) {
        deactivate_plugins( plugin_basename( __FILE__ ) );
        wp_die( 'The AgriLife Core plugin requires Advanced Custom Fields 5. <br><a href="' . str_replace('?' . $_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']) . '">Return to Plugins page.</a>' );
    }
});

// Add Image Sizes
if ( function_exists( 'add_image_size' ) ) {
    add_image_size( 'landing-template-slider', 1024, 576, true );
    add_image_size( 'landing-template-thumbnail', 483, 272, true );
}
add_filter('image_size_names_choose', 'agrilife_core_image_sizes');
function agrilife_core_image_sizes($sizes) {
    $addsizes = array(
        "landing-template-slider" => __( "Landing Template Slider"),
        "landing-template-thumbnail" => __( "Landing Template Thumbnail")
    );
    $newsizes = array_merge($sizes, $addsizes);
    return $newsizes;
}