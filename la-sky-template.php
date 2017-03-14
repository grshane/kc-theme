<?php
/**
* Template Name: LA Sky Template
* Description: Used as a page template to show page contents with custom header
*/

// Force Full Width Layout

add_filter('genesis_pre_get_option_site_layout','__genesis_return_full_width_content');
// Add custom body class to the head
add_filter( 'body_class', 'add_body_class' );
function add_body_class( $classes ) {
   $classes[] = 'la-sky';
   return $classes;
}
genesis();