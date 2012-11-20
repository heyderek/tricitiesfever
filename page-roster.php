<?php
/**
 * The template for displaying the roster table.
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
					
					<table id="roster" cellspacing="1" cellpadding="3">
					    
					    <th>Player</th>
					    <th>Last Name</th>
					    <th>First Name</th>
					    <th>Number</th>
					    <th>Position</th>
					    <th>Height</th>
					    <th>Weight</th>
					    <th>College</th>
					
					<?php
					$args = array(
						      'post_type' => 'roster',
						      'posts_per_page' => -1,
						      'meta_key' => 'rs_lname',
						      'orderby' => 'meta_value',
						      'order' => 'ASC',
						      );
			
					$loop = new WP_Query( $args );
					while ( $loop->have_posts() ) : $loop->the_post(); ?>
					<tr>
					    <td><a href="<?php the_permalink(); ?>"><?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'player' ); } ?></a></td>
					    <td><?php echo get_post_meta(get_the_ID(), 'rs_lname', true); ?></td>
					    <td><?php echo get_post_meta(get_the_ID(), 'rs_fname', true); ?></td>
					    <td><?php echo get_post_meta(get_the_ID(), 'rs_num', true); ?></td>
					    <td><?php echo get_post_meta(get_the_ID(), 'rs_pos', true); ?></td>
					    <td><?php echo get_post_meta(get_the_ID(), 'rs_het', true); ?></td>
					    <td><?php echo get_post_meta(get_the_ID(), 'rs_wet', true); ?></td>
					    <td><?php echo get_post_meta(get_the_ID(), 'rs_col', true); ?></td>
					</tr>
					<?php endwhile; ?>
					</table>

			</div><!-- #content -->
		</div><!-- #container -->



				</div><!--#secondary-wrapper-->
<?php get_sidebar(); ?>				
	</div><!-- #main -->

<?php get_footer(); ?>