<?php
namespace AgriLife\Core;

class Accessibility {

	public function __construct() {

		add_action( 'genesis_before', array( $this, 'add_skip_link' ), 1 );

        add_action( 'genesis_before_entry', array( $this, 'add_skip_link_anchor' ), 1 );

	}

	public function add_skip_link() {
        ?>
            <!-- Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff -->
            <div class="skip-link screen-reader-text">
                <a href="#content" title="Skip to content">Skip to content</a>
            </div>
        <?php
	}

    public function add_skip_link_anchor() {
        ?>
            <a id="content" title="content"></a>
        <?php
    }


}