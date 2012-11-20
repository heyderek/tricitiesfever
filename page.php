<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the wordpress construct of pages
 * and that other 'pages' on your wordpress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>

	<div id="main">
	    
	    <?php if ( function_exists( 'breadcrumb_trail' ) ) breadcrumb_trail(); ?>

		<div id="secondary-wrapper">
			
		<h3 class="feed"><?php the_title(); ?></h3>
		
		<div id="container">
			<div id="content" role="main">
				
					<?php if ( is_front_page() ) { ?>
						<h2><?php echo get_post_meta(get_the_ID(), 'sh_shead', true); ?></h2>
					<?php } else { ?>	
						<h1><?php echo get_post_meta(get_the_ID(), 'sh_shead', true); ?></h1>
					<?php } ?>

			
			<?php
				// Check if this is a post or page, if it has a thumbnail, and if it's a big one
					if ( is_singular() &&
					has_post_thumbnail( $post->ID ) ) :
					// Houston, we have a new header image!
					echo get_the_post_thumbnail( $post->ID );
						
			endif; ?>
			
			<?php if( function_exists('ADDTOANY_SHARE_SAVE_KIT') ) { ADDTOANY_SHARE_SAVE_KIT(); } ?>

			
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '' . __( 'Pages:', 'twentyten' ), 'after' => '' ) ); ?>
						<?php edit_post_link( __( 'Edit', 'twentyten' ), '', '' ); ?>

				

<?php endwhile; ?>

			</div><!-- #content -->
		</div><!-- #container -->



				</div>
<?php get_sidebar(); ?>				
	</div><!-- #main -->

<?php get_footer(); ?>