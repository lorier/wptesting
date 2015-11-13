<?php
/*
 * Template Name: Campaigns
 */

get_header();
?>

<section id="primary" class="content-area">
	<div id="content" class="site-content" role="main">    
	<?php
    if( have_posts() ):
        while( have_posts() ): the_post();
            get_template_part('content');
        endwhile;
    endif;
    ?>
    
    <div class="entry-content">
<!--         <form id="campaign-search">
            <input type="text" class="text-search" placeholder="Search books..." />
            <input type="submit" value="Search" id="submit-search" />
        </form> -->
        <div id="campaign-filter">
            <?php 
            // echo get_campaign_filters(); 
            ?>
        </div>
        <div id="campaign-results"></div>
        <?php 
        // echo sg_paginate_links(); 
        ?>
    </div>
    
	</div>
</section>

<?php get_footer(); ?>