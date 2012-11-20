<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>

	<div id="main">
	    
	    <?php if ( function_exists( 'breadcrumb_trail' ) ) breadcrumb_trail(); ?>

		<div id="secondary-wrapper">

				<h1 class="feed"><?php
					printf( __( '%s', 'twentyten' ), '' . single_cat_title( '', false ) . '' );
				?></h1>

				<div id="container">
				<div id="content" role="main">
				<?php

				/* Run the loop for the category page to output the posts.
				 * If you want to overload this in a child theme then include a file
				 * called loop-category.php and that will be used instead.
				 */
				get_template_part( 'loop', 'category' );
				?>
				
				</div><!--#content-->
				</div>




				</div>
<?php get_sidebar(); ?>				
	</div><!-- #main -->

<?php get_footer(); ?>