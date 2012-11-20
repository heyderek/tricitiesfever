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

<div id="fp-main">
		
		<div id="fp-container">
				<h3 id="news-hd">News</h3>
				<div id="fp-content">
					<ul class="article-list">
					<?php
						$args = array(
							      'numberposts' => 2,
							      'order'=> 'DEC',
							      'category_name' => 'news',
							      'orderby' => 'post_date'
							);
						$postslist = get_posts( $args );
						foreach ($postslist as $post) :  setup_postdata($post); ?> 
							<li>
								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('fp-medium'); ?></a>
								<h2 id="news-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<p><a href="<?php the_permalink(); ?>" class="date"><?php the_time('F j, Y'); ?></a>
								
								</p>

								<?php wpe_excerpt('wpe_excerptlength_teaser'); ?>

								<?php wp_reset_postdata(); ?>
							
							</li>

				<?php endforeach; ?>
			
					</ul><!--./article-list-->
					
				</div> <!--fp-content-->
		</div><!--fp-container-->
		
		<div id="fp-primary">
		<h3 id="blog-hd">Blog</h3>
			<ul class="article-list">
			
				<?php
				$args = array(
					      'numberposts' => 3,
					      'order'=> 'DEC',
					      'category_name' => 'blog',
					      'orderby' => 'post_date'
					);
				$postslist = get_posts( $args );
				foreach ($postslist as $post) :  setup_postdata($post); ?> 
					<li>
						<h4 class="article-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
						<p><?php the_time('F j, Y'); ?></p>
						
					</li>
				<?php endforeach; ?>
				
			</ul><!--./article-list-->
			
			<?php
								// A second sidebar for widgets, just because.
								if ( is_active_sidebar( 'secondary-widget-area' ) ) : ?>
							
									<div id="secondary" class="widget-area" role="complementary">
										<ul class="xoxo">
											<?php dynamic_sidebar( 'secondary-widget-area' ); ?>
										</ul>
									</div><!-- #secondary .widget-area -->
							
							<?php endif; ?>
			
		</div><!--fp-primary-->
		
		<div id="fp-secondary">
		<h3 id="media-hd">Media</h3>
			<ul class="article-list">
			
				<?php
				$args = array(
					      'numberposts' => 5,
					      'order'=> 'DEC',
					      'category_name' => 'media',
					      'orderby' => 'post_date'
					      
					);
				$postslist = get_posts( $args );
				foreach ($postslist as $post) :  setup_postdata($post); ?> 
					<li>
						<h4 class="article-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
						<p><?php the_time('F j, Y'); ?></p>
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumb'); ?></a>
						
					</li>
					
				<?php endforeach; ?>
				
			</ul><!--./article-list-->
		
		</div><!--fp-secondary-->
		
		</div><!--#main-->
			
		<ul id="schedule">
		<?php
				global $post;
				$args = array(
					      'numberposts' => -1,
					      'post_type' => 'schedule',
					      'order'=> 'ASC'
				);
				$myposts = get_posts( $args );
				foreach( $myposts as $post ) :	setup_postdata($post); ?>
					<li>
						<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail('game-icon'); ?>
						<span><?php echo get_post_meta(get_the_ID(), 'sc_out', true); ?> <?php echo get_post_meta(get_the_ID(), 'sc_score', true); ?></span>
						</a>
						
					</li>
				<?php endforeach; ?>
		</ul>

<?php get_footer(); ?>