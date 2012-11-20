<?php
/**
 * Template Name: One column, no sidebar
 *
 * A custom page template without sidebar.
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>

<h3 class="feed"><?php the_title(); ?></h3>


<div id="container" class="single-attachment">
    <?php
				// Check if this is a post or page, if it has a thumbnail, and if it's a big one
					
				
				if ( is_singular() &&
					has_post_thumbnail( $post->ID ) ) :
					// Houston, we have a new header image!
					echo get_the_post_thumbnail( $post->ID );
						
			endif; ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<h1><?php the_title(); ?></h1>
				<?php the_content(); ?>
				<?php wp_link_pages( array( 'before' => '' . __( 'Pages:', 'twentyten' ), 'after' => '' ) ); ?>
				<?php edit_post_link( __( 'Edit', 'twentyten' ), '', '' ); ?>

				<?php comments_template( '', true ); ?>

<?php endwhile; ?>

</div>

<?php get_footer(); ?>