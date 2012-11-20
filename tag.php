<?php
/**
 * The template for displaying Tag Archive pages.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>

	<div id="main">
	    
	    <?php if ( function_exists( 'breadcrumb_trail' ) ) breadcrumb_trail(); ?>

		<div id="secondary-wrapper">

<h3 class="feed"><?php printf( __( '%s', 'twentyten' ), '' . single_tag_title( '', false ) . '' ); ?></h3>			

		<div id="container">
			<div id="content" role="main">

				<h1><?php
					printf( __( 'Tagged: %s', 'twentyten' ), '' . single_tag_title( '', false ) . '' );
				?></h1>

<?php
/* Run the loop for the tag archive to output the posts
 * If you want to overload this in a child theme then include a file
 * called loop-tag.php and that will be used instead.
 */
 get_template_part( 'loop', 'tag' );
?>
			</div><!-- #content -->
		</div><!-- #container -->
		
<?php get_sidebar(); ?>

				</div>
				
	</div><!-- #main -->
	
<?php get_footer(); ?>