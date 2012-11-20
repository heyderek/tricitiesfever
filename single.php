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

<h3 class="feed"><?php the_category(' '); ?></h3>			

		<div id="container">
			<div id="content" role="main">
				
				<p class="date"><?php the_time('F j, Y'); ?></p>
				
				<h1><?php the_title(); ?></h1>

			<?php
				// Check if this is a post or page, if it has a thumbnail, and if it's a big one
				if ( is_singular() &&
					has_post_thumbnail( $post->ID ) ) :
					// Houston, we have a new header image!
					echo get_the_post_thumbnail( $post->ID );
						
			endif; ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

						
						<h2 class="subheading"><?php echo get_post_meta(get_the_ID(), 'sh_shead', true); ?></h2>
						
						<p class="author">By <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
							<?php printf( __( '%s', 'twentyten' ), get_the_author() ); ?>
						</a></p>
						

						<?php the_content(); ?>
							<span class="meta"><?php twentyten_posted_in(); ?></span>
						<?php edit_post_link( __( 'Edit', 'twentyten' ), '', '' ); ?>
					

				<?php if ( get_the_author_meta( 'description' ) ) : // If a user has filled out their description, show a bio on their entries  ?>
							<div id="author-card">
								<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentyten_author_bio_avatar_size', 60 ) ); ?>
								<h2><?php printf( esc_attr__( '%s', 'twentyten' ), get_the_author() ); ?></h2>
								<div><?php the_author_meta( 'description' ); ?>
									<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
										<?php printf( __( 'View all %s&rsquo;s posts', 'twentyten' ), get_the_author() ); ?>
									</a>
								</div>
							</div><!--author-card-->
<?php endif; ?>

					


				

<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #container -->



				</div>
	<?php get_sidebar(); ?>			
	</div><!-- #main -->
<?php get_footer(); ?>