<?php
/**
 * The template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>

	<div id="primary" class="woo_content_area">
   
		<div id="woo_content" class="site-content" role="main">

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); 
			$woo_answer = get_post_meta( $post->ID,'questions_answer', true );
			
			
			
			?>
           <div class="woo-title"><?php  the_title();  ?></div>
           <div class="woo_answer"><p><?php  echo $woo_answer;   ?></p></div>
			

			<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->


<?php get_footer(); ?>