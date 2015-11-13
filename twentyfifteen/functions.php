<?php
/**
 * Twenty Fifteen functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */



// function sg_print_pre($value) {
//     echo "<pre>",print_r($value, true),"</pre>";
// }



// // \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

// /**
// * Campaign Taxonomies
// */
// if ( ! function_exists( 'sg_create_campaign_categories' ) ) {

//     function sg_create_campaign_categories() {

//         $labels = array(
//             'name'                       => 'Campaign Categories',
//             'singular_name'              => 'Campaign Category',
//             'menu_name'                  => 'Campaign Category',
//             'all_items'                  => 'All Items',
//             'parent_item'                => 'Parent Item',
//             'parent_item_colon'          => 'Parent Item:',
//             'new_item_name'              => 'New Item Name',
//             'add_new_item'               => 'Add New Item',
//             'edit_item'                  => 'Edit Item',
//             'update_item'                => 'Update Item',
//             'view_item'                  => 'View Item',
//             'separate_items_with_commas' => 'Separate items with commas',
//             'add_or_remove_items'        => 'Add or remove items',
//             'choose_from_most_used'      => 'Choose from the most used',
//             'popular_items'              => 'Popular Items',
//             'search_items'               => 'Search Items',
//             'not_found'                  => 'Not Found',
//         );
//         $args = array(
//             'labels'                     => $labels,
//             'hierarchical'               => false,
//             'public'                     => true,
//             'show_ui'                    => true,
//             'show_admin_column'          => true,
//             'show_in_nav_menus'          => false,
//             'show_tagcloud'              => false,
//         );
//     register_taxonomy( 'campaign_categories', array( 'campaigns' ), $args );
//     }
// add_action( 'init', 'sg_create_campaign_categories', 0 );
// }

// /**
// *   Camapaign Post Type
// */
// function sg_create_campaign_post_type() {

//     $labels = array(
//         'name'                => 'Campaigns',
//         'singular_name'       => 'Campaign',
//         'menu_name'           => 'Campaigns',
//         'parent_item_colon'   => 'Parent Item:',
//         'all_items'           => 'All Items',
//         'add_new_item'        => 'Add New Item',
//         'add_new'             => 'Add New',
//         'new_item'            => 'New Item',
//         'edit_item'           => 'Edit Item',
//         'update_item'         => 'Update Item',
//         'view_item'           => 'View Item',
//         'search_items'        => 'Search Item',
//         'not_found'           => 'Not found',
//         'not_found_in_trash'  => 'Not found in Trash',
//     );
//     $args = array(
//         'label'               => 'Campaign',
//         'description'         => 'Current Advocacy Campaigns',
//         'labels'              => $labels,
//         'supports'            => array( ),
//         'taxonomies'          => array('campaign_categories'),
//         'hierarchical'        => true,
//         'public'              => true,
//         'show_ui'             => true,
//         'show_in_menu'        => true,
//         'menu_position'       => 6,
//         'show_in_admin_bar'   => true,
//         'show_in_nav_menus'   => false,
//         'can_export'          => true,
//         'has_archive'         => true,
//         'exclude_from_search' => false,
//         'publicly_queryable'  => true,
//         'menu_icon'           => 'dashicons-megaphone',
//     );
//     register_post_type( 'campaigns', $args );

// }
// add_action( 'init', 'sg_create_campaign_post_type', 6 );






// //Enqueue Ajax Scripts
// add_action('wp_enqueue_scripts', 'sg_enqueue_ajax_scripts');
// function sg_enqueue_ajax_scripts() {
//     wp_register_script( 'campaign-ajax', get_stylesheet_directory_uri() . '/js/campaign-ajax.js', array( 'jquery' ), '', true );
//     wp_localize_script( 'campaign-ajax', 'ajax_campaign_params', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
//     wp_enqueue_script( 'campaign-ajax' );
// }
// global $query_args;

// function sg_get_query( $args ){

//     return new WP_Query( $args );
// }
// function get_taxonomy_terms(){
//     //get the campaign terms
//     $query_data = $_GET;
//     sg_print_pre($query_data);
//     $campaign_terms = ($query_data['campaigns']) ? explode(',',$query_data['campaigns']) : false;

//     $tax_query = ($campaign_terms) ? array( array(
//         'taxonomy' => 'campaign_categories',
//         'field' => 'id',
//         'terms' => $campaign_terms
//     ) ) : false;
//     return $tax_query;
// }

// function sg_get_args(){
//     $query_data = $_GET;
//     $paged = (isset($query_data['paged']) ) ? intval($query_data['paged']) : 1;
//     // sg_print_pre($paged);

//     $tax_query = get_taxonomy_terms();
//     $args = array(
//         'post_type' => 'campaigns',
//         // 's' => $search_value,
//         'posts_per_page' => 1,
//         'tax_query' => $tax_query,
//         'paged' => $paged,
//         'echo'  => 0
//     );
//     return $args;
// }
// //ajax testing
// //Add Ajax Actions
// add_action('wp_ajax_campaign_filter', 'ajax_campaign_filter');
// add_action('wp_ajax_nopriv_campaign_filter', 'ajax_campaign_filter');

// global $paged_global;
// $paged_global = (isset($query_data['paged']) ) ? intval($query_data['paged']) : 1;
// //Construct Loop & Results
// //
// function ajax_campaign_filter()
// {
//     $query_data = $_GET;
    
//     $paged = (isset($query_data['paged']) ) ? intval($query_data['paged']) : 1;

//     global $paged_global;
//     $paged_global = $paged;
//     sg_print_pre($paged_global);

//     $campaign_args = sg_get_args($paged);

//     $campaign_loop = sg_get_query( $campaign_args );

//     if( $campaign_loop->have_posts() ):
//         while( $campaign_loop->have_posts() ): $campaign_loop->the_post();
//             $output = '<div class="row voffset-md">';
//             $output .=  '   <div class="col-xs-12 campaign">
//                                 <h4>
//                                     <a href="';
//             $output .=  get_the_permalink();
//             $output .=  '">';
//             $output .=   get_the_title();
//             $output .=   '          </a>
//                                 </h4>
//                                 <p>';
//             // $output .=   sg_excerpt_limit(12);
//             $output .= get_the_excerpt();
//             $output .=   '      </p>
//                             </div>
//                         </div>
//                         <hr>';
//             echo $output;
//         endwhile;
    
//         echo $output;
//     else:
//         echo '<h3>Nothing here</h3>';
//     endif;
//     wp_reset_postdata();
    
//     die();
// }


// function sg_paginate_links() {
//     // $query_data = $_GET;
//     $args = sg_get_args();

//     global $paged_global;

//     $loop = sg_get_query($args);
//     $paged = $paged_global;
//     // sg_print_pre($paged);
//     $output ='<div class="campaign-filter-navigation">';
//     $big = 999999999;
//     // global $the_query;
//     // sg_print_pre($paged);
//     // echo sg_get_pagination($campaign_loop);
//     $output .= paginate_links( array(
//         // 'base' => '%_%',
//         'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
//         'format' => '?paged=%#%',
//         'current' => max( 0, $paged ),
//         'total' => $loop->max_num_pages
//     ) );
//     $output .= '</div>';  
//     echo $output;
// }

// function get_campaign_filters()
// {
//     $terms = get_terms('campaign_categories');
//     $filters_html = false;
    
//     if( $terms ):
//         $filters_html = '<ul>';
        
//         foreach( $terms as $term )
//         {
//             $term_id = $term->term_id;
//             $term_name = $term->name;
        
//             $filters_html .= '<li class="term_id_'.$term_id.'">'.$term_name.'<input type="checkbox" name="filter_category[]" value="'.$term_id.'"></li>';  
//         }
//         $filters_html .= '<span class="btn"><li class="clear-all">Clear All</li></span>';
//         $filters_html .= '</ul>';
        
//         return $filters_html;
//     endif;
// }





































/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Twenty Fifteen 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 660;
}

/**
 * Twenty Fifteen only works in WordPress 4.1 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.1-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'twentyfifteen_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Twenty Fifteen 1.0
 */
function twentyfifteen_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on twentyfifteen, use a find and replace
	 * to change 'twentyfifteen' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'twentyfifteen', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 825, 510, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu',      'twentyfifteen' ),
		'social'  => __( 'Social Links Menu', 'twentyfifteen' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

	$color_scheme  = twentyfifteen_get_color_scheme();
	$default_color = trim( $color_scheme[0], '#' );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'twentyfifteen_custom_background_args', array(
		'default-color'      => $default_color,
		'default-attachment' => 'fixed',
	) ) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', 'genericons/genericons.css', twentyfifteen_fonts_url() ) );
}
endif; // twentyfifteen_setup
add_action( 'after_setup_theme', 'twentyfifteen_setup' );

/**
 * Register widget area.
 *
 * @since Twenty Fifteen 1.0
 *
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
 */
function twentyfifteen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Widget Area', 'twentyfifteen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'twentyfifteen' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'twentyfifteen_widgets_init' );

if ( ! function_exists( 'twentyfifteen_fonts_url' ) ) :
/**
 * Register Google fonts for Twenty Fifteen.
 *
 * @since Twenty Fifteen 1.0
 *
 * @return string Google fonts URL for the theme.
 */
function twentyfifteen_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Noto Sans, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Noto Sans font: on or off', 'twentyfifteen' ) ) {
		$fonts[] = 'Noto Sans:400italic,700italic,400,700';
	}

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Noto Serif, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Noto Serif font: on or off', 'twentyfifteen' ) ) {
		$fonts[] = 'Noto Serif:400italic,700italic,400,700';
	}

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Inconsolata, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Inconsolata font: on or off', 'twentyfifteen' ) ) {
		$fonts[] = 'Inconsolata:400,700';
	}

	/*
	 * Translators: To add an additional character subset specific to your language,
	 * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
	 */
	$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'twentyfifteen' );

	if ( 'cyrillic' == $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' == $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'devanagari' == $subset ) {
		$subsets .= ',devanagari';
	} elseif ( 'vietnamese' == $subset ) {
		$subsets .= ',vietnamese';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

/**
 * JavaScript Detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Fifteen 1.1
 */
function twentyfifteen_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'twentyfifteen_javascript_detection', 0 );

/**
 * Enqueue scripts and styles.
 *
 * @since Twenty Fifteen 1.0
 */
function twentyfifteen_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'twentyfifteen-fonts', twentyfifteen_fonts_url(), array(), null );

	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.2' );

	// Load our main stylesheet.
	wp_enqueue_style( 'twentyfifteen-style', get_stylesheet_uri() );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'twentyfifteen-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentyfifteen-style' ), '20141010' );
	wp_style_add_data( 'twentyfifteen-ie', 'conditional', 'lt IE 9' );

	// Load the Internet Explorer 7 specific stylesheet.
	wp_enqueue_style( 'twentyfifteen-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'twentyfifteen-style' ), '20141010' );
	wp_style_add_data( 'twentyfifteen-ie7', 'conditional', 'lt IE 8' );

	wp_enqueue_script( 'twentyfifteen-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20141010', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'twentyfifteen-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20141010' );
	}

	wp_enqueue_script( 'twentyfifteen-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20150330', true );
	wp_localize_script( 'twentyfifteen-script', 'screenReaderText', array(
		'expand'   => '<span class="screen-reader-text">' . __( 'expand child menu', 'twentyfifteen' ) . '</span>',
		'collapse' => '<span class="screen-reader-text">' . __( 'collapse child menu', 'twentyfifteen' ) . '</span>',
	) );
}
add_action( 'wp_enqueue_scripts', 'twentyfifteen_scripts' );

/**
 * Add featured image as background image to post navigation elements.
 *
 * @since Twenty Fifteen 1.0
 *
 * @see wp_add_inline_style()
 */
function twentyfifteen_post_nav_background() {
	if ( ! is_single() ) {
		return;
	}

	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	$css      = '';

	if ( is_attachment() && 'attachment' == $previous->post_type ) {
		return;
	}

	if ( $previous &&  has_post_thumbnail( $previous->ID ) ) {
		$prevthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $previous->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-previous { background-image: url(' . esc_url( $prevthumb[0] ) . '); }
			.post-navigation .nav-previous .post-title, .post-navigation .nav-previous a:hover .post-title, .post-navigation .nav-previous .meta-nav { color: #fff; }
			.post-navigation .nav-previous a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}

	if ( $next && has_post_thumbnail( $next->ID ) ) {
		$nextthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-next { background-image: url(' . esc_url( $nextthumb[0] ) . '); border-top: 0; }
			.post-navigation .nav-next .post-title, .post-navigation .nav-next a:hover .post-title, .post-navigation .nav-next .meta-nav { color: #fff; }
			.post-navigation .nav-next a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}

	wp_add_inline_style( 'twentyfifteen-style', $css );
}
add_action( 'wp_enqueue_scripts', 'twentyfifteen_post_nav_background' );

/**
 * Display descriptions in main navigation.
 *
 * @since Twenty Fifteen 1.0
 *
 * @param string  $item_output The menu item output.
 * @param WP_Post $item        Menu item object.
 * @param int     $depth       Depth of the menu.
 * @param array   $args        wp_nav_menu() arguments.
 * @return string Menu item with possible description.
 */
function twentyfifteen_nav_description( $item_output, $item, $depth, $args ) {
	if ( 'primary' == $args->theme_location && $item->description ) {
		$item_output = str_replace( $args->link_after . '</a>', '<div class="menu-item-description">' . $item->description . '</div>' . $args->link_after . '</a>', $item_output );
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'twentyfifteen_nav_description', 10, 4 );

/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since Twenty Fifteen 1.0
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function twentyfifteen_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
add_filter( 'get_search_form', 'twentyfifteen_search_form_modify' );

/**
 * Implement the Custom Header feature.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/customizer.php';
