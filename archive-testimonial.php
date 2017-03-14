<?php
/*
Template Name: Portfolio Archive Template
*/

?>

<?php
 remove_filter( 'the_content', 'show_share_buttons');
//* Remove the entry title (requires HTML5 theme support)
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
add_action('genesis_entry_content', 'genesis_do_post_title');

remove_action( 'genesis_entry_header', 'genesis_post_info', 5 );

//* Remove the entry meta in the entry footer (requires HTML5 theme support)
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

//* Remove the post info function
remove_action( 'genesis_before_post_content', 'genesis_post_info' );

// Display custom fields
add_action('genesis_entry_content', 'id_display_testimonial_fields');

?>

<?php genesis(); ?>