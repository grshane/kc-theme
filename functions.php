<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'altitude', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'altitude' ) );

//* Add Image upload and Color select to WordPress Theme Customizer
require_once( get_stylesheet_directory() . '/lib/customize.php' );

//* Include Customizer CSS
include_once( get_stylesheet_directory() . '/lib/output.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Altitude Pro Theme' );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/altitude/' );
define( 'CHILD_THEME_VERSION', '1.0.5' );

//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'altitude_enqueue_scripts_styles' );
function altitude_enqueue_scripts_styles() {

	wp_enqueue_script( 'altitude-global', get_bloginfo( 'stylesheet_directory' ) . '/js/global.js', array( 'jquery' ), CHILD_THEME_VERSION );
	wp_enqueue_script( 'flowtype', get_bloginfo( 'stylesheet_directory' ) . '/js/FlowType/flowtype.js');

	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'altitude-google-fonts', '//fonts.googleapis.com/css?family=Ek+Mukta:200,800', array(), CHILD_THEME_VERSION );


}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add new image sizes
add_image_size( 'featured-page', 1140, 400, TRUE );

//* Add support for 1-column footer widget area
add_theme_support( 'genesis-footer-widgets', 1 );

//* Add support for footer menu
add_theme_support ( 'genesis-menus' , array ( 'primary' => __( 'Header Navigation Menu', 'altitude' ), 'secondary' => __( 'Above Header Navigation Menu', 'altitude' ), 'footer' => __( 'Footer Navigation Menu', 'altitude' ) ) );

//* Force full-width-content layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//* Unregister the header right widget area
unregister_sidebar( 'header-right' );

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

//* Remove output of primary navigation right extras
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_header', 'genesis_do_subnav', 5 );

//* Add secondary-nav class if secondary navigation is used
add_filter( 'body_class', 'altitude_secondary_nav_class' );
function altitude_secondary_nav_class( $classes ) {

	$menu_locations = get_theme_mod( 'nav_menu_locations' );

	if ( ! empty( $menu_locations['secondary'] ) ) {
		$classes[] = 'secondary-nav';
	}
	return $classes;

}

//* Hook menu in footer
add_action( 'genesis_footer', 'altitude_footer_menu', 7 );
function altitude_footer_menu() {

	genesis_nav_menu( array(
		'theme_location' => 'footer',
		'container'      => false,
		'depth'          => 1,
		'fallback_cb'    => false,
		'menu_class'     => 'genesis-nav-menu',
	) );

}

//* Add Attributes for Footer Navigation
add_filter( 'genesis_attr_nav-footer', 'genesis_attributes_nav' );

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'flex-height'     => true,
	'width'           => 360,
	'height'          => 76,
	'header-selector' => '.site-title a',
	'header-text'     => false,
) );

if ( !'front_page' ) {
add_theme_support( 'custom-header2', array(
	'flex-height'     => true,
	'width'           => 360,
	'height'          => 76,
	'header-selector' => '.site-title a',
	'header-text'     => false,
) );
}

//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	'subnav',
	'footer-widgets',
	'footer',
) );


//* Change the footer text
add_filter('genesis_footer_creds_text', 'sp_footer_creds_filter');
function sp_footer_creds_filter( $creds ) {
	$creds = '[footer_copyright] &middot; <a href="http://krusecontrolinc.com">Kruse Control, Inc.</a> &middot; Developed by <a href="http://macchiatomarketing.com">Macchiato Marketing</a>';
	return $creds;
}

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'altitude_author_box_gravatar' );
function altitude_author_box_gravatar( $size ) {

	return 176;

}


//* Remove the entry meta in the entry footer (requires HTML5 theme support)
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

//* Modify the size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'altitude_comments_gravatar' );
function altitude_comments_gravatar( $args ) {

	$args['avatar_size'] = 120;

	return $args;

}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'altitude_remove_comment_form_allowed_tags' );
function altitude_remove_comment_form_allowed_tags( $defaults ) {

	$defaults['comment_field'] = '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun', 'altitude' ) . '</label> <textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>';
	$defaults['comment_notes_after'] = '';

	return $defaults;

}

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Relocate after entry widget
remove_action( 'genesis_after_entry', 'genesis_after_entry_widget_area' );
add_action( 'genesis_after_entry', 'genesis_after_entry_widget_area', 5 );

//* Setup widget counts
function altitude_count_widgets( $id ) {
	global $sidebars_widgets;

	if ( isset( $sidebars_widgets[ $id ] ) ) {
		return count( $sidebars_widgets[ $id ] );
	}

}

function altitude_widget_area_class( $id ) {
	$count = altitude_count_widgets( $id );

	$class = '';

	if( $count == 1 ) {
		$class .= ' widget-full';
	} elseif( $count % 3 == 1 ) {
		$class .= ' widget-thirds';
	} elseif( $count % 4 == 1 ) {
		$class .= ' widget-fourths';
	} elseif( $count % 2 == 0 ) {
		$class .= ' widget-halves uneven';
	} else {
		$class .= ' widget-halves';
	}
	return $class;

}

//* Relocate the post info
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_action( 'genesis_entry_header', 'genesis_post_info', 5 );

//* Customize the entry meta in the entry header
add_filter( 'genesis_post_info', 'altitude_post_info_filter' );
function altitude_post_info_filter( $post_info ) {

    $post_info = '[post_date format="M d Y"] [post_edit]';

    return $post_info;

}

//* Customize the entry meta in the entry footer
add_filter( 'genesis_post_meta', 'altitude_post_meta_filter' );
function altitude_post_meta_filter( $post_meta ) {

	$post_meta = 'Written by [post_author_posts_link] [post_categories before=" &middot; Categorized: "]  [post_tags before=" &middot; Tagged: "]';

	return $post_meta;

}

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'front-page-1',
	'name'        => __( 'Front Page 1', 'altitude' ),
	'description' => __( 'This is the front page 1 section.', 'altitude' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-2',
	'name'        => __( 'Front Page 2', 'altitude' ),
	'description' => __( 'This is the front page 2 section.', 'altitude' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-3',
	'name'        => __( 'Front Page 3', 'altitude' ),
	'description' => __( 'This is the front page 3 section.', 'altitude' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-4',
	'name'        => __( 'Front Page 4', 'altitude' ),
	'description' => __( 'This is the front page 4 section.', 'altitude' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-5',
	'name'        => __( 'Front Page 5', 'altitude' ),
	'description' => __( 'This is the front page 5 section.', 'altitude' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-6',
	'name'        => __( 'Front Page 6', 'altitude' ),
	'description' => __( 'This is the front page 6 section.', 'altitude' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-7',
	'name'        => __( 'Front Page 7', 'altitude' ),
	'description' => __( 'This is the front page 7 section.', 'altitude' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-8',
	'name'        => __( 'Front Page 8', 'altitude' ),
	'description' => __( 'This is the front page 8 section.', 'altitude' ),
) );

 // Register Custom Post Types
    add_action( 'init', 'cptui_register_my_cpts' );
function cptui_register_my_cpts() {
    // Testimonials
	$labels = array(
		"name" => "Testimonials",
		"singular_name" => "Testimonial",
		);

	$args = array(
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"show_ui" => true,
		"has_archive" => true,
		"show_in_menu" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "testimonial", "with_front" => true ),
		"query_var" => true,
						"supports" => array( 'title', 'custom-fields', 'thumbnail', 'genesis-cpt-archives-settings' ), );
	register_post_type( "testimonial", $args );
	flush_rewrite_rules();

    // Invoice Custom Post Type
    $labels = array(
        "name" => "Invoices",
        "singular_name" => "Invoice",
        );

    $args = array(
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "show_ui" => true,
        "has_archive" => false,
        "show_in_menu" => true,
        "exclude_from_search" => true,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "menu_icon" => 'dashicons-tickets-alt',
        "rewrite" => array( "slug" => "invoice", "with_front" => true ),
        "query_var" => true,
                        "supports" => array( 'title', 'custom-fields', 'thumbnail' ), );
    register_post_type( "invoice", $args );
    flush_rewrite_rules();

// End of cptui_register_my_cpts()
}

/**
 * Remove Image Alignment from Featured Image
 *
 */
function be_remove_image_alignment( $attributes ) {
  $attributes['class'] = str_replace( 'aligncenter', 'alignleft', $attributes['class'] );
	return $attributes;
}




      /** Display Testimonial Custom Fields **/
    function id_display_testimonial_fields() {
        $client_title = get_field( 'client_title' );
        $client_company = get_field('client_company');
        $testimonial = get_field('testimonial');


        if ( $client_title || $client_company || $testimonial ) {
            echo '<div class="testimonial">';

            if ( $client_title ) {
                echo '<div class="client_title">' . $client_title . '</div>';
            }
            if ( $client_company ) {
                echo '<div class="client_company">' . $client_company . '</div>';
            }
            if ( $testimonial ) {
                echo '<div class="testimonial-quote">' . $testimonial . '</div>';
            }

            else {
                return;
            }//endelse


        }//end field if
        echo '</div>'; //class="testimonial"
    }//end function

// Add Read More Link to Excerpts
//add_filter('excerpt_more', 'get_read_more_link');
//add_filter( 'the_content_more_link', 'get_read_more_link' );
function get_read_more_link() {
   return '...&nbsp;<a href="' . get_permalink() . '">[Read&nbsp;More]</a>';
}

//iThemes convert per month on product pages

function my_translated_text_strings( $translated_text, $untranslated_text, $domain ) {
    $translated_text = $untranslated_text;
    if ( 'LION' === $domain || 'it-l10n-exchange-addon-membership' === $domain || 'it-l10n-exchange-addon-recurring-payments' === $domain ) {
        switch ( $untranslated_text ) {
            case 'every %s' :
                $translated_text = '/ Month';
                break;
            case 'every %d %s' :
                $translated_text = 'Custom Text Here';
                break;
            case '(after %d %s free)' :
                $translated_text = 'Custom Text Here';
                break;
            case ' %s %s free, then regular price' :
                $translated_text = 'Custom Text Here';
                break;
            case '1 %s free' :
                $translated_text = 'Custom Text Here';
                break;
            case '%d %ss free' :
                $translated_text = 'Custom Text Here';
                break;
            case '(after %s)' :
                $translated_text = 'Custom Text Here';
                break;
            case ' %s upgrade credit, then regular price' :
                $translated_text = 'Custom Text Here';
                break;
            case ' %s %s free, then regular price' :
                $translated_text = 'Custom Text Here';
                break;
        }
    }
    return $translated_text;
}
add_filter( 'gettext', 'my_translated_text_strings', 10, 3 );
add_filter( 'ngettext', 'my_translated_text_strings', 10, 3 );


// iThemes page URL fix
add_filter( 'it_exchange_get_page_url', function ( $url, $page ) {
    if ( $page === 'transaction' ) {
        $url = add_query_arg( 'transaction', 1, trailingslashit( site_url() ) );
    }
    return $url;
}, 10, 2 );
add_filter( 'it_exchange_get_transaction_confirmation_url', function ( $url, $transaction_id ) {
    // If we can't grab the hash, return false
    if ( ! $transaction_hash = it_exchange_get_transaction_hash( $transaction_id ) ) {
        return false;
    }
    // Get base page URL
    $confirmation_url = it_exchange_get_page_url( 'confirmation' );
    $slug             = it_exchange_get_page_slug( 'confirmation' );
    $confirmation_url = remove_query_arg( $slug, $confirmation_url );
    $confirmation_url = add_query_arg( $slug, $transaction_hash, $confirmation_url );
    return $confirmation_url;
}, 10, 2 );

//add_filter( 'the_excerpt_rss', 'rgc_add_featured_image_to_feed_excerpt', 1000, 1 );
function rgc_add_featured_image_to_feed_excerpt( $content ) {
	if ( has_post_thumbnail( get_the_ID() ) ) {
		$content = get_the_post_thumbnail( get_the_ID(), 'thumbnail', array( 'align' => 'left', 'style' => 'margin-right:20px;' ) ) . $content;
	}
	return $content;
}