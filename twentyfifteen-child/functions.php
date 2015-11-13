<?php 

function sg_print_pre($value) {
    echo "<pre>",print_r($value, true),"</pre>";
}

function theme_enqueue_assets() {
	global $wp_query;
    $parent_style = 'parent-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style )
    );
    // wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
    wp_enqueue_script( 'ajax-pagination',  get_stylesheet_directory_uri() . '/js/ajax-pagination.js', array( 'jquery' ), '1.0', true );
    // wp_localize_script( 'ajax-pagination', 'ajaxpagination', array('ajaxurl' => admin_url( 'admin-ajax.php' )));
	wp_localize_script( 'ajax-pagination', 'ajaxpagination', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'query_vars' => json_encode( $wp_query->query)
	));
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_assets' );



add_action( 'wp_ajax_nopriv_ajax_pagination', 'my_ajax_pagination' );
add_action( 'wp_ajax_ajax_pagination', 'my_ajax_pagination' );

function my_ajax_pagination() {
    $query_vars = json_decode( stripslashes( $_POST['query_vars'] ), true );
	//Using our passed parameters we build a custom query. 
	//This involves basically taking the query variables we passed 
	//and making sure that the page number we passed overwrites the paged parameter. 
    $query_vars['paged'] = $_POST['page']; 
    // print_r($query_vars);

	// We then use our final $query_vars array to create a new query.
    $posts = new WP_Query( $query_vars );

    // We need to make the $GLOBALS['wp_query'] variable equal to our new posts object. 
    // The reason we need to do this is that the the_posts_pagination() function uses this global variable.
    $GLOBALS['wp_query'] = $posts;

    // sg_print_pre($posts);
	// This was something unexpected that came up. I actually created a WordPress Trac Ticket. 
    add_filter( 'editor_max_image_size', 'my_image_size_override' );

	// The next step is to use our query to list our posts. 
	// I copied a lot from the index.php file in the parent theme.
    if( ! $posts->have_posts() ) { 
        get_template_part( 'content', 'none' );
    }
    else {
        while ( $posts->have_posts() ) { 
            $posts->the_post();
            global $post;
            if ( $post->post_status == 'publish') { //this works but leaves a "gap" in the layout?
	            get_template_part( 'content', get_post_format() );
            }
        }
    }
    remove_filter( 'editor_max_image_size', 'my_image_size_override' );

	// Finally we use the same pagination format we see in the index file.
    the_posts_pagination( array(
        'prev_text'          => __( 'Previous page', 'twentyfifteen' ),
        'next_text'          => __( 'Next page', 'twentyfifteen' ),
        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>',
    ) );

    die();
}


// Nice tutorial, I used some parts of it on my new website!
// Only one problem with this: If you schedule posts, it will cause duplicate posts with a custom theme (didn’t test it with the default themes). This is because the post status is not defined in the AJAX function.
// A solution for this is to add this $query_vars[‘post_status’] = ‘publish'; after $query_vars[‘paged’] = $_POST[‘page’];

function my_image_size_override() {
    return array( 825, 510 );
}





function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );