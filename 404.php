<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>

        <div id="main">
	    
	    <?php if ( function_exists( 'breadcrumb_trail' ) ) breadcrumb_trail(); ?>

		<div id="secondary-wrapper">
		    		<h1 class="feed"><?php _e( 'Not Found', 'twentyten' ); ?></h1>
		
		<div id="container">
			<div id="content" role="main">



				<h1><?php _e( 'Not Found', 'twentyten' ); ?></h1>
				<p><?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', 'twentyten' ); ?></p>
				<?php get_search_form(); ?>

	<script type="text/javascript">
		// focus on search field after it has loaded
		document.getElementById('s') && document.getElementById('s').focus();
	</script>
				
			</div><!-- #content -->
		</div><!-- #container -->


<?php get_sidebar(); ?>
				</div>
	</div><!-- #main -->
        
<?php get_footer(); ?>


<?php get_footer(); ?>