<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */
?>


	
	<?php if ( is_front_page() ) { ?>
			<?php if ( is_active_sidebar( 'ps-widget-area' ) ) : ?>
				<div id="ps-first" class="widget-area">
					<ul class="xoxo">
						<?php dynamic_sidebar( 'ps-widget-area' ); ?>
					</ul>
				</div><!-- #first .widget-area -->
<?php endif; ?>
<?php } ?>

	<div id="footer" role="contentinfo">
		<div id="colophon">
			
<?php
	/* A sidebar in the footer? Yep. You can can customize
	 * your footer with four columns of widgets.
	 */
	get_sidebar( 'footer' );
?>


		</div><!-- #colophon -->
			
			<div id="site-info">
				
				<span>&copy; <?php the_time('Y'); ?></span>
				
				<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					<?php bloginfo( 'name' ); ?>
				</a>
				
				<span>All Rights Reserved.</span>
				
				<span><?php wp_loginout(); ?></span>
				
			</div><!-- #site-info -->

			<ul id="credits">
				<li><a id="versatile" class="notxt" href="http://www.versatiledesignstudios.com" title="This has been a Versatile Design Studios Web Project">This has been a Versatile Design Studios Web Project</a></li>
			</ul><!-- #credits -->
			
	</div><!-- #footer -->

</div><!-- #wrapper-->

<?php if ( is_active_sidebar( 'sf-widget-area' ) ) : ?>

<div id="sub-footer">
	
	<div id="sf-branding">
		
		<a href="http://goifl.com/" id="ifl-home" class="notxt" title="Visit the home of the Indoor Football League" target="_blank" >Indoor Football League</a>
					
		<ul class="league-list">
			
			<?php dynamic_sidebar( 'sf-widget-area' ); ?>
			
		</ul><!--league-list-->
						
	</div><!--sf-branding-->
	
</div><!--sub-footer-->

<?php endif; ?>

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
<br class="clear" />
</body>
</html>