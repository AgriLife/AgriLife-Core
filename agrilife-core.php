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
define( 'AG_CORE_TEMPLATE_PATH', AG_CORE_DIR_PATH . '/templates' );

// Register plugin activation functions
$activate = new \AgriLife\Core\Activate;
register_activation_hook( __FILE__, array( $activate, 'run') );

// Register plugin deactivation functions
$deactivate = new \AgriLife\Core\Deactivate;
register_deactivation_hook( __FILE__, array( $deactivate, 'run' ) );

$agrilife_options = new \AgriLife\Core\Options();

// Remove unwanted widgets
$agrilife_remove_widgets = new \AgriLife\Core\RemoveWidgets();

// Add 'children' shortcode
$agrilife_core_shortcode_children = new \AgriLife\Core\Shortcode\Children();

// Add the loop shortcode
$agrilife_core_shortcode_loop = new \AgriLife\Core\Shortcode\Loop();

// Add page templates
$agrilife_template_members_only = new \AgriLife\Core\PageTemplate();
$agrilife_template_members_only->with_path(AG_CORE_TEMPLATE_PATH )->with_file('members-only')->with_name( 'Members Only' );
$agrilife_template_members_only->register();

$agrilife_template_redirect = new \AgriLife\Core\PageTemplate();
$agrilife_template_redirect->with_path( AG_CORE_TEMPLATE_PATH )->with_file( 'redirect' )->with_name( 'Redirect' );
$agrilife_template_redirect->register();
