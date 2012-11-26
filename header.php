<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'toolbox' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/images/favicon.ico" />
<link rel="stylesheet" type="text/css" media="all" href="index.php" />
<link href='http://fonts.googleapis.com/css?family=Nova+Square' rel='stylesheet' type='text/css'>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-18565750-25']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<?php wp_enqueue_script('jquery'); ?>

<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
		

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	 
	wp_head();
?>
<script type="application/x-javascript" src="<?php echo home_url( '/' ); ?>wp-content/themes/fever/js/jquery.flexslider.js"></script>

    
    <script type="text/javascript">
					
	var $j = jQuery.noConflict();

	$j(window).load(function() {
		$j('.flexslider').flexslider({
		  animation: "slide",
		  controlsContainer: ".flexslider-container"
		  });
		});
    </script>
    
    
</head>

<body <?php body_class(); ?>>
<div class="notxt" id="champions-banner">Back to Back Intense Conference Champions</div>
<div id="wrapper">
	<div id="header">
		<div id="site-description-wrapper">
		<div id="site-description">
			<div id="title"><?php bloginfo( 'name' ); ?></div> <div id="description"><?php bloginfo( 'description' ); ?></div>
			<ul id="social">
				<li><a class="notxt" id="facebook" href="https://www.facebook.com/pages/Tri-Cities-Fever/152436907129" target="_blank">Facebook</a></li>
				<li><a class="notxt" id="twitter" href="http://twitter.com/#!/tcfever" target="blank">Twitter</a></li>
				<li><a class="notxt" id="rss" target="_blank" href="<?php bloginfo('rss2_url'); ?>">RSS</a></li>
			</ul>
			<div id="header-player"></div>
			<br class="clear">
		</div>
		</div>
		<div id="masthead">
			<div id="access" role="navigation">
				<div id="branding" role="banner">
					<?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>
					<<?php echo $heading_tag; ?> id="site-title">
						<span>
							<a class="notxt" href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
						</span>
					</<?php echo $heading_tag; ?>>
				</div><!-- #branding -->
				<div id="navsearch"><?php get_search_form( true ); ?></div><!--navsearch-->
			  <?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff */ ?>
				<div class="skip-link screen-reader-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentyten' ); ?>"><?php _e( 'Skip to content', 'twentyten' ); ?></a></div>
				<?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.  The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.  */ ?>
				<?php wp_nav_menu( array(
					'container_class' => 'menu-header',
					'theme_location' => 'primary'
					)
				    );
				?>
			</div><!-- #access -->
		</div><!-- #masthead -->
	</div><!-- #header-->
	<?php
				if (is_front_page() ) : ?>
				<!-- Hook up the FlexSlider -->
											<div class="flexslider-container">
												<div class="flexslider">
													    <ul class="slides">
															<?php
																$args = array(
																	'numberposts' => 5,
																	'offset'=> 0, 
																	'category_name' => 'featured',
																	'orderby' => ''
																	);
																$slideshow = get_posts( $args );
																foreach( $slideshow as $post ) :  setup_postdata($post); ?>
																	<li>
																	<?php the_post_thumbnail( 'frontpage' ); ?>
																	<div class="caption">
																		<h3><?php the_title(); ?></h3>
																		<?php wpe_excerpt('wpe_excerptlength_index', 'wpe_excerptmore'); ?>
																	</div> <!--caption-->
																	</li>
																<?php endforeach; ?>
													    </ul>
												</div>
											</div>
				<?php endif; ?>