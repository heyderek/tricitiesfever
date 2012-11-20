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

<h3 class="feed">&#35;<?php echo get_post_meta(get_the_ID(), 'rs_num', true); ?></h3>			

		<div id="container">
			<div id="content" role="main">
				
				
				<h1><?php the_title(); ?></h1>

			<?php
				// Check if this is a post or page, if it has a thumbnail, and if it's a big one
				if ( is_singular() &&
					has_post_thumbnail( $post->ID ) ) :
					// Houston, we have a new header image!
					echo get_the_post_thumbnail( $post->ID );
						
			endif; ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

					    
						<?php
						$num = get_post_meta(get_the_ID(), 'rs_num', true);
						$pos = get_post_meta(get_the_ID(), 'rs_pos', true);
						$het = get_post_meta(get_the_ID(), 'rs_het', true);
						$wet = get_post_meta(get_the_ID(), 'rs_wet', true);
						$col = get_post_meta(get_the_ID(), 'rs_col', true);
						$bio = get_post_meta(get_the_ID(), 'rs_bio', true);
						?>
						<ul>
						    <li><strong>Number:</strong> <?php echo $num; ?></li>
						    <li><strong>Position:</strong> <?php echo $pos; ?></li>
						    <li><strong>Height:</strong> <?php echo $het; ?></li>
						    <li><strong>Weight:</strong> <?php echo $wet; ?></li>
						    <li><strong>College</strong> <?php echo $col; ?></li>
						</ul>
						
						<strong>Player Bio:</strong>
						<?php echo $bio; ?>



<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #container -->


<?php get_sidebar(); ?>
				</div>
				
	</div><!-- #main -->
<?php get_footer(); ?>