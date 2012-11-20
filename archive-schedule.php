<?php
/**
 * The template for displaying the schedule table.
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
		    
			
		<h3 class="feed">Schedule</h3>
		
		<div id="container">
			<div id="content" role="main">
				
					<?php if ( is_front_page() ) { ?>
						<h2><?php echo get_post_meta(get_the_ID(), 'sh_shead', true); ?></h2>
					<?php } else { ?>	
						<h1><?php echo get_post_meta(get_the_ID(), 'sh_shead', true); ?></h1>
					<?php } ?>
					
					<table id="roster" cellspacing="1" cellpadding="3">
					    
					    <th>Date</th>
					    <th>Location</th>
					    <th>Time</th>
					    <th>Opponent</th>
					    <th>Final</th>
					    <th>Record</th>
					
					<?php
					$args = array(
						      'post_type' => 'schedule',
						      'posts_per_page' => -1,
						      'order' => 'ASC'
						      );
					$loop = new WP_Query( $args );
					while ( $loop->have_posts() ) : $loop->the_post(); ?>
					<tr>
					    <td><?php echo get_post_meta(get_the_ID(), 'sc_game', true); ?></td>
					    <td><?php echo get_post_meta(get_the_ID(), 'sc_loc', true); ?></td>
					    <td><?php echo get_post_meta(get_the_ID(), 'sc_time', true); ?></td>
					    <td><a href="<?php the_permalink(); ?>"><?php echo get_post_meta(get_the_ID(), 'sc_opp', true); ?></a></td>
					    <td><?php echo get_post_meta(get_the_ID(), 'sc_out', true); ?> <?php echo get_post_meta(get_the_ID(), 'sc_score', true); ?></td>
					    <td><?php echo get_post_meta(get_the_ID(), 'sc_rec', true); ?></td>
					</tr>
					<?php endwhile; ?>
					<tr>*All Game Times Are PST/PDT.</tr>
					</table>

			</div><!-- #content -->
		</div><!-- #container -->



		</div><!--#secondary-wrapper-->
			<?php get_sidebar(); ?>			
	</div><!-- #main -->

<?php get_footer(); ?>