<?php 

function sg_print_pre($value) {
    echo "<pre>",print_r($value, true),"</pre>";
}

function theme_enqueue_assets() {
	global $wp_query;
    // sg_print_pre($wp_query);
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
    sg_print_pre($_GET);
    
    $query_vars = json_decode( stripslashes( $_GET['query_vars'] ), true );
    
    // set_query_var( 'genres', array());
    $query_vars['paged'] = isset($_GET['page']) ? $_GET['page'] : '';
    $query_vars['genres'] = isset($_GET['genres']) ? $_GET['genres'] : '';
    // if (isset($query_vars['paged'])) {
    //     $query_vars['paged'] = $_POST['page'];
    // }else{
    //     $query_vars
    // }

    $genre_terms = ($query_vars['genres']) ? explode(',',$query_vars['genres']) : false; //if there are genres in the query, return the genres as an array, otherwise return false
    // sg_print_pre($genre_terms);

    $tax_query = ($genre_terms) ? array( array(
        'taxonomy' => 'genre',
        'field' => 'id',
        'terms' => $genre_terms
    ) ) : false;
    sg_print_pre($tax_query); //is empty on the first page load because there's no taxonomy in the query vars

    $paged = (isset($query_vars['paged']) ) ? intval($query_vars['paged']) : 1;

    $book_args = array(
        'post_type' => 'book',
        'posts_per_page' => 2,
        'tax_query' => $tax_query,
        'paged' => $paged
    );

	//Using our passed parameters we build a custom query. 
	//This involves basically taking the query variables we passed 
	//and making sure that the page number we passed overwrites the paged parameter. 
    // $book_args['paged'] = $_POST['page']; 
    // print_r($query_vars);

	// We then use our final $query_vars array to create a new query.
    $posts = new WP_Query( $book_args );

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
        'mid_size'          => 3,
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


//Register books post type
function codex_custom_init() {
    $args = array(
        'public' => true,
        'label'  => 'Books'
    );
    register_post_type( 'book', $args );
}
add_action( 'init', 'codex_custom_init' );

//Register book genre taxonomy
add_action( 'init', 'create_book_tax' );

function create_book_tax() {
    register_taxonomy(
        'genre',
        'book',
        array(
            'label' => __( 'Genre' ),
            'rewrite' => array( 'slug' => 'genre' ),
            'hierarchical' => true
        )
    );
}
function get_genre_filters(){
    $terms = get_terms('genre');
        //if there are no terms in the taxonomy then exit;
        if (empty($terms)) { return; };
        $output = <<<EOT

        <form id="category-select" class="category-select" action="" method="get">
EOT;
    $args = array(
                'show_option_all' => 'All Categories',
                'taxonomy'  => 'genre',
                'class' => 'form-control postform',
                'echo' => 0,
                'value_field' => 'term_id'
            );
    $output  .= wp_dropdown_categories($args);
    $output .=  '</form>';
    echo $output;
}
//Get Genre Filters
// function get_genre_filters()
// {
//     $terms = get_terms('genre');
//     $filters_html = false;
    
//     if( $terms ):
//         $filters_html = '<ul>';
        
//         foreach( $terms as $term )
//         {
//             $term_id = $term->term_id;
//             $term_name = $term->name;
        
//             $filters_html .= '<li class="term_id_'.$term_id.'">'.$term_name.'<input type="checkbox" name="filter_genre[]" value="'.$term_id.'"></li>';  
//         }
//         $filters_html .= '<li class="clear-all">Clear All</li>';
//         $filters_html .= '</ul>';
        
//         return $filters_html;
//     endif;
// }


function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );