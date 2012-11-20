<?php
/*
 Template Name: Sponsors Page
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
                        
                        
                        
                        <?php
                        $args = array( 'post_type' => 'gallery', 'id' => '598', 'posts_per_page' => 1, 'size' => 'thumbnail', 'link' => 'custom_url');
                        $loop = new WP_Query( $args );
                        while ( $loop->have_posts() ) : $loop->the_post();
                                
                                echo '<div class="entry-content">';
                                echo do_shortcode('[gallery id="598" link="custom_url" columns="3" orderby="menu_order"]');

                                   // $gallery_shortcode = '[gallery id="598"]';
                                    print apply_filters( 'the_content', $gallery_shortcode );
                                    
                                    //echo do_shortcode('[gallery id="598" link="custom_url" columns="3" orderby="menu_order"]');
                                    

                                echo '</div>';
                        endwhile;
                        ?>
                        
                        
			
			<?php if( function_exists('ADDTOANY_SHARE_SAVE_KIT') ) { ADDTOANY_SHARE_SAVE_KIT(); } ?>

			
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '' . __( 'Pages:', 'twentyten' ), 'after' => '' ) ); ?>
						<?php edit_post_link( __( 'Edit', 'twentyten' ), '', '' ); ?>

				

<?php endwhile; ?>

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_sidebar(); ?>

				</div>
				
	</div><!-- #main -->

<?php get_footer(); ?>