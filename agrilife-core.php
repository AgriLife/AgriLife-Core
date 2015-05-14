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

$agrilife_singlecolumn_template = new \AgriLife\Core\PageTemplate();
$agrilife_singlecolumn_template->with_path( AG_CORE_TEMPLATE_PATH )->with_file( 'singlecolumn' )->with_name( 'Single Column' );
$agrilife_singlecolumn_template->register();

if ( class_exists( 'Acf' ) ) {
    $agrilife_core_fields = new \AgriLife\Core\CustomFields( 'Agency Details', AG_CORE_DIR_PATH . '/fields' );
    $agrilife_service_fields = new \AgriLife\Core\CustomFields( 'Services', AG_CORE_DIR_PATH . '/fields' );
} else {
    add_action( 'admin_notices', 'agrilife_acf_notice' );
}
// All child plugins should hook into 'agrilife_core_init' where necessary
add_action( 'plugins_loaded', function() {
	do_action('agrilife_core_init');
}, 15);

function agrilife_acf_notice() {
    ?>
    <div class="error">
        <p><?php _e( 'Please activate Advanced Custom Fields 5', 'agrilife-core' ); ?></p>
    </div>
<?php
}
