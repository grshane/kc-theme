<?php
/*
Template Name: Testimonial Single Template
*/
?>
<?php
remove_filter( 'the_content', 'show_share_buttons');
remove_action( 'genesis_entry_header', 'genesis_post_info', 5 );


//* Display values of custom fields (those that are not empty)
add_action( 'genesis_entry_content', 'id_display_testimonial_fields' );
//* Remove the entry meta in the entry footer (requires HTML5 theme support)
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
?>

<?php

?>
<?php genesis(); ?>