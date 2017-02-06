<?php
/**
 * Template Name: Child Pages
 */

remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
add_action( 'genesis_entry_content', 'agrilife_child_page_list' );

function agrilife_child_page_list() {

	echo do_shortcode( '[children]' );

}

genesis();
