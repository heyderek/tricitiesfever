<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>
	
        <div id="main">
	    
	    <?php if ( function_exists( 'breadcrumb_trail' ) ) breadcrumb_trail(); ?>

		<div id="secondary-wrapper">
		    		<h1 class="feed"><?php printf( __( 'Search Results for: %s', 'twentyten' ), '' . get_search_query() . '' ); ?></h1>
		
		<div id="container">
			<div id="content" role="main">

<?php if ( have_posts() ) : ?>
				<?php
				/* Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called loop-search.php and that will be used instead.
				 */
				 get_template_part( 'loop', 'search' );
				?>
<?php else : ?>
					<h2><?php _e( 'Nothing Found', 'twentyten' ); ?></h2>
					<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentyten' ); ?></p>
					<?php get_search_form(); ?>
<?php endif; ?>


			</div><!-- #content -->
		</div><!-- #container -->


<?php get_sidebar(); ?>
				</div>
	</div><!-- #main -->
        
<?php get_footer(); ?>
