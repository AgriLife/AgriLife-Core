<?php

namespace AgriLife\Core;

class Assets {

  public function __construct() {

    // Register admin scripts used in the theme
    add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_styles' ) );

    // Enqueue admin scripts
    add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );

  }

  /**
   * Registers globally used scripts
   * @since 1.0
   * @return void
   */
  public function register_admin_styles() {

    wp_register_style(
      'admin-styles',
      AG_CORE_DIR_URL . 'css/admin.css',
      array(),
      '',
      'screen'
    );

  }

  /**
   * Enqueues globally used scripts
   * @since 1.0
   * @return void
   */
  public function enqueue_admin_styles() {

    wp_enqueue_style( 'admin-styles' );

  }

}
