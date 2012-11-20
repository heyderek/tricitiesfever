<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>

	<div id="main">
	    
	    <?php if ( function_exists( 'breadcrumb_trail' ) ) breadcrumb_trail(); ?>

		<div id="secondary-wrapper">

<h3 class="feed">Schedule</h3>			

		<div id="container">
			<div id="content" role="main">
				

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>



					<h1><?php the_title(); ?></h1>
					<?php the_post_thumbnail(); ?>
					    
					    <?php
					    $game = get_post_meta(get_the_ID(), 'sc_game', true);
					    $loc = get_post_meta(get_the_ID(), 'sc_loc', true);
					    $opp = get_post_meta(get_the_ID(), 'sc_opp', true);
					    $time = get_post_meta(get_the_ID(), 'sc_time', true); ?>
				    <ul>
					<li><strong>When:</strong> <?php echo $game; ?></li>
					<li><strong>Where:</strong> <?php echo $loc; ?></li>
					<li><strong>Opponent:</strong> <?php echo $opp; ?></li>
					<li><strong>Time:</strong> <?php echo $time; ?></li>
					<li><strong>Final:</strong><?php echo get_post_meta(get_the_ID(), 'sc_out', true); ?> <?php echo get_post_meta(get_the_ID(), 'sc_score', true); ?> </li>
				    </ul>
				    
				    <strong>Additional Info:</strong>
				    <?php the_content(); ?>

						

						
					


					


				

<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #container -->



				</div>
	<?php get_sidebar(); ?>			
	</div><!-- #main -->
<?php get_footer(); ?>