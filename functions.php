<?php
/**
 *THUS BEGINS MY FUNCTIONS FILE...
 *
 *First, let's call up some jQuery, and put it into "no-conflict" mode.  Also, let's set up a few scripts to run for the front-end of the theme.
 *
 *
 *If you must use "$" wrap it:
 *
 *jQuery(document).ready(function($) {
	   // $() will work as an alias for jQuery() inside of this function
	});	
 *
 *More info: http://codex.wordpress.org/Function_Reference/wp_enqueue_script
 *
 *
 *
 *
*/

function my_init() {
 if (!is_admin()) {// instruction to only load if it is not the admin area
    wp_register_script('formalize',
	get_bloginfo('template_directory') . '/js/jquery.formalize-noconflict.min.js');// Fire up some Formalize from Nathan Smith (formalize.me).
    wp_register_script('selectivizr',
	get_bloginfo('template_directory') . '/js/selectivizr.min.js');// While we're at it, let's make sure IE can handle CSS3 selectors using jQuery (selectivr.com).
    wp_register_script('custom',
       get_bloginfo('template_directory') . '/js/custom.js');// Let's load up a custom script...
    wp_enqueue_script('jquery');// Let's fire up some jQuery in no-conflict mode.
    wp_enqueue_script('formalize');
    wp_enqueue_script('selectivizr');
    wp_enqueue_script('custom');
 }
}

add_action('init', 'my_init');

/**
 *
 * Let's add a Custom Post Type
 * 
 */
add_action('init', 'register_sc', 1); // Set priority to avoid plugin conflicts

function register_sc() { // A unique name for our function
 	$labels = array( // Used in the WordPress admin
		'name' => _x('Schedule', 'post type general name'),
		'singular_name' => _x('Schedule', 'post type singular name'),
		'add_new' => _x('Add New', 'Game'),
		'add_new_item' => __('Add Game'),
		'edit_item' => __('Edit Game'),
		'new_item' => __('New Game'),
		'view_item' => __('View Game'),
		'search_items' => __('Search Schedule'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash')
	);
	$args = array(
		'labels' => $labels, // Set above
		'public' => true, // Make it publicly accessible
		'hierarchical' => false, // No parents and children here
		'menu_position' => 5, // Appear right below "Posts"
		'has_archive' => true, // Activate the archive
		'capability_type' => 'page',
		'nav_menu_item' => 'Schedule',
		'supports' => array('title','thumbnail', 'editor')
	);
	register_post_type( 'schedule', $args ); // Create the post type, use options above
}

add_action('init', 'register_rs', 1); // Set priority to avoid plugin conflicts

function register_rs() { // A unique name for our function
 	$labels = array( // Used in the WordPress admin
		'name' => _x('Roster', 'post type general name'),
		'singular_name' => _x('Roster', 'post type singular name'),
		'add_new' => _x('Add Player', 'Player'),
		'add_new_item' => __('Add Player'),
		'edit_item' => __('Edit Player'),
		'new_item' => __('New Player'),
		'view_item' => __('View Player'),
		'search_items' => __('Search Roster'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
	);
	$args = array(
		'labels' => $labels, // Set above
		'public' => true, // Make it publicly accessible
		'hierarchical' => false, // No parents and children here
		'menu_position' => 5, // Appear right below "Posts"
		'has_archive' => false, // Activate the archive
		'capability_type' => 'post',
		'nav_menu_item' => 'Roster',
		'supports' => array('thumbnail','title')
	);
	register_post_type( 'roster', $args ); // Create the post type, use options above
}

add_action('init', 'register_ig', 1); // Set priority to avoid plugin conflicts

function register_ig() { // A unique name for our function
 	$labels = array( // Used in the WordPress admin
		'name' => _x('Image Galleries', 'post type general name'),
		'singular_name' => _x('Image Gallery', 'post type singular name'),
		'add_new' => _x('Add Gallery', 'Gallery'),
		'add_new_item' => __('Add Gallery'),
		'edit_item' => __('Edit Gallery'),
		'new_item' => __('New Gallery'),
		'view_item' => __('View Gallery'),
		'search_items' => __('Search Galleries'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash')
	);
	$args = array(
		'labels' => $labels, // Set above
		'public' => true, // Make it publicly accessible
		'hierarchical' => false, // No parents and children here
		'menu_position' => 5, // Appear right below "Posts"
		'has_archive' => false, // Activate the archive
		'capability_type' => 'post',
		'nav_menu_item' => 'Image Galleries',
		'supports' => array('title','thumbnail','editor')
	);
	register_post_type( 'gallery', $args ); // Create the post type, use options above
}

//----------------edit custom columns display for back-end
add_action("manage_posts_custom_column", "my_custom_columns");
add_filter("manage_edit-gallery_columns", "my_gallery_columns");
 
function my_gallery_columns($columns) //this function display the columns headings
{
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Gallery Title",
		"date" => "Date",
		"ID" => "ID",
		"description" => "Description",
		"thumbnail" => "Thumbnail"
	);
	return $columns;
}
 
function my_custom_columns($column)
{
	global $post;
	if ("ID" == $column) echo $post->ID; //displays title
	elseif ("description" == $column) echo $post->post_content; //displays the content excerpt
	elseif ("thumbnail" == $column) echo $post->post_thumbnail; //shows up our post thumbnail that we previously created.
}

/**
 *
 * Create custom categories for use in the front-page, news, blog, and media templates.  Doing this insures everything is installed and working correctly.
 * 
 */

$parent_term = term_exists( 'media', 'category' ); // array is returned if taxonomy is given
$parent_term_id = $parent_term['term_id']; // get numeric term id
wp_insert_term(
  'Media', // the term 
  'category', // the taxonomy
  array(
    'description'=> 'Fever pictures, videos, music, etc.',
    'slug' => 'media'
  )
);
$parent_term = term_exists( 'news', 'category' ); // array is returned if taxonomy is given
$parent_term_id = $parent_term['term_id']; // get numeric term id
wp_insert_term(
  'News', // the term 
  'category', // the taxonomy
  array(
    'description'=> 'Latest news from the Tri Cities Fever.',
    'slug' => 'news'
  )
);
$parent_term = term_exists( 'blog', 'category' ); // array is returned if taxonomy is given
$parent_term_id = $parent_term['term_id']; // get numeric term id
wp_insert_term(
  'Blog', // the term 
  'category', // the taxonomy
  array(
    'description'=> 'Blog section of the website.  Reserved for mainly op-ed and analysis.',
    'slug' => 'blog'
  )
);
$parent_term = term_exists( 'featured', 'category' ); // array is returned if taxonomy is given
$parent_term_id = $parent_term['term_id']; // get numeric term id
wp_insert_term(
  'Featured', // the term 
  'category', // the taxonomy
  array(
    'description'=> 'Category specifically reserved for front page articles.  A Featured post can appear in multiple categories, or simply the Featured category for use in the front page; however, any post intended for the front page MUST have a featured image attached to it.',
    'slug' => 'featured'
  )
);


/**
 * TwentyTen functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, twentyten_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'twentyten_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 960;

/** Tell WordPress to run twentyten_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'twentyten_setup' );

if ( ! function_exists( 'twentyten_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override twentyten_setup() in a child theme, add your own twentyten_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_custom_background() To add support for a custom background.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Ten 1.0
 */

function twentyten_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'twentyten', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'twentyten' ),
	) );

	// This theme allows users to set a custom background
	
	add_theme_support('custom-background');

	// Your changeable header business starts here
	define( 'HEADER_TEXTCOLOR', '' );
	// No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.
	define( 'HEADER_IMAGE', '%s/images/headers/versatile.png' );

	// The height and width of your custom header. You can hook into the theme's own filters to change these values.
	// Add a filter to twentyten_header_image_width and twentyten_header_image_height to change these values.
	define( 'HEADER_IMAGE_WIDTH', apply_filters( 'twentyten_header_image_width', 620 ) );
	define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'twentyten_header_image_height', 350 ) );
	
	add_image_size('frontpage', 960, 350, true);
	add_image_size('fp-medium', 515, 300, false);
	add_image_size('game-icon', 65, 55, false);
	add_image_size('thumb', 175, 150, false);
	add_image_size('player', 75, 75, false);

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be 940 pixels wide by 198 pixels tall.
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, false );

	// Don't support text inside the header image.
	define( 'NO_HEADER_TEXT', true );
	
	add_theme_support('custom-header');

	// ... and thus ends the changeable header business.

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'berries' => array(
			'url' => '%s/images/headers/versatile.png',
			'thumbnail_url' => '%s/images/headers/versatile-thumbnail.png',
			/* translators: header image description */
			'description' => __( 'Versatile', 'twentyten' )
		)
	) );
}
endif;

if ( ! function_exists( 'twentyten_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in twentyten_setup().
 *
 * @since Twenty Ten 1.0
 */
function twentyten_admin_header_style() {
?>
<style type="text/css">
/* Shows the same border as on front end */
#headimg {
	
}
/* If NO_HEADER_TEXT is false, you would style the text with these selectors:
	#headimg #name { }
	#headimg #desc { }
*/
</style>
<?php
}
endif;

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'twentyten_page_menu_args' );

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since Twenty Ten 1.0
 * @return int
 */
function twentyten_excerpt_length( $length ) {
	return 100;
}
add_filter( 'excerpt_length', 'twentyten_excerpt_length' );


function wpe_excerptlength_teaser($length) {
    return 100;
}
function wpe_excerptlength_index($length) {
    return 30;
}
function wpe_excerpt($length_callback='', $more_callback='') {
    global $post;
    if(function_exists($length_callback)){
        add_filter('excerpt_length', $length_callback);
    }
    if(function_exists($more_callback)){
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>'.$output.'</p>';
    echo $output;
}
/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since Twenty Ten 1.0
 * @return string "Continue Reading" link
 */
function twentyten_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Keep Reading <span class="meta-nav">&raquo;</span>', 'twentyten' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and twentyten_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string An ellipsis
 */
function twentyten_auto_excerpt_more( $more ) {
	return ' &hellip;' . twentyten_continue_reading_link();
}
add_filter( 'excerpt_more', 'twentyten_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function twentyten_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= twentyten_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'twentyten_custom_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in Twenty Ten's style.css.
 *
 * @since Twenty Ten 1.0
 * @return string The gallery style filter, with the styles themselves removed.
 */
function twentyten_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'twentyten_remove_gallery_css' );

if ( ! function_exists( 'twentyten_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentyten_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( __( '%s <span class="says">says:</span>', 'twentyten' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em><?php _e( 'Your comment is awaiting moderation.', 'twentyten' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'twentyten' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'twentyten' ), ' ' );
			?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'twentyten' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'twentyten'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override twentyten_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * @since Twenty Ten 1.0
 * @uses register_sidebar
 */
function twentyten_widgets_init() {
	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => __( 'Primary Widget Area', 'twentyten' ),
		'id' => 'primary-widget-area',
		'description' => __( 'The primary widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 2, located below the Primary Widget Area in the sidebar. Empty by default.
	register_sidebar( array(
		'name' => __( 'Secondary Widget Area', 'twentyten' ),
		'id' => 'secondary-widget-area',
		'description' => __( 'The secondary widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 3, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'First Footer Widget Area', 'twentyten' ),
		'id' => 'first-footer-widget-area',
		'description' => __( 'The first footer widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 4, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Second Footer Widget Area', 'twentyten' ),
		'id' => 'second-footer-widget-area',
		'description' => __( 'The second footer widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 5, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Third Footer Widget Area', 'twentyten' ),
		'id' => 'third-footer-widget-area',
		'description' => __( 'The third footer widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 6, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Fourth Footer Widget Area', 'twentyten' ),
		'id' => 'fourth-footer-widget-area',
		'description' => __( 'The fourth footer widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
       //Area 7, located primarily on the Front-Page, serves as a widget/featured area for the Fever Pro Shop.
       register_sidebar( array( 
		'name' => __( 'Pro Shop Widget Area', '' ),
		'id' => 'ps-widget-area',
		'description' => __( 'Widget Area on the Front Page for the Fever Pro Shop', '' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="ps-widget-title">',
		'after_title' => '</h3>',
	) );
		// Area 8, located below the footer (hence, sub-footer). Should contain list of links to other league teams.
	register_sidebar( array(
		'name' => __( 'Sub-Footer Widget Area (for links)', 'twentyten' ),
		'id' => 'sf-widget-area',
		'description' => __( 'Sub-footer widget area intended for league links.', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h4 class="sf-widget-title">',
		'after_title' => '</h4>',
	) );
}

/** Register sidebars by running twentyten_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'twentyten_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 * To override this in a child theme, remove the filter and optionally add your own
 * function tied to the widgets_init action hook.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'twentyten_remove_recent_comments_style' );

if ( ! function_exists( 'twentyten_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post—date/time and author.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_on() {
	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'twentyten' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'twentyten' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;

if ( ! function_exists( 'twentyten_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( '<strong>This entry was posted in </strong> %1$s <strong>and tagged</strong> %2$s. <strong>Bookmark the</strong> <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( '<strong>This entry was posted in </strong> %1$s.<strong>Bookmark the </strong> <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	} else {
		$posted_in = __( '<strong>Bookmark the </strong><a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;







/**
 * This portion of the functions.php script was created by Jake Goldman
 * 
 */   


/**
 * we do our login css hijacking up here, since we'll wrap the rest in "is_admin"
 */
 
add_action( 'login_head', 'custom_login_css' );

function custom_login_css() {
	echo '<link rel="stylesheet" href="' . get_stylesheet_directory_uri() . '/admin-styles.css" type="text/css" media="all" />'; 
}


// lots of front end functions? consider compartmentalizing admin:
// if ( is_admin() ) require_once('functions_admin.php');

if ( is_admin() ) : // why execute all the code below at all if we're not in admin?

/**************************/
/*** PART ONE: BRANDING ***/
/**************************/
 
/**
 * call in custom admin stylesheet - this will be global for admin and also login
 */
 
//add_action( 'admin_print_styles', 'load_custom_admin_css' );
//
//function load_custom_admin_css() {
//	wp_enqueue_style( 'custom_admin_css', get_stylesheet_directory_uri() . '/admin-styles.css' );
//} 


/**
 * overriding footer "credit" text
 */
 
add_filter( 'admin_footer_text', 'custom_footer_text' );

function custom_footer_text($default_text) {
	return '<span id="footer-thankyou">Site managed by <a href="http://www.versatiledesignstudios.com">Versatile Design Studios</a><span> | Powered by <a href="http://www.wordpress.org">WordPress</a>';
}


/**
 * cleaning up and customizing the dashboard
 */
 
add_action('wp_dashboard_setup', 'custom_dashboard_widgets');

function custom_dashboard_widgets() {
	global $wp_meta_boxes;
	
	// remove unnecessary widgets
	// var_dump( $wp_meta_boxes['dashboard'] ); // use to get all the widget IDs
	unset(
		$wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'],
		$wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary'],
		$wp_meta_boxes['dashboard']['side']['core']['dashboard_primary'],
		$wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links'],
		$wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']
	);
	
	//custom dashboard widgets
	wp_add_dashboard_widget('dashboard_custom_feed', 'News from Versatile Design Studios', 'dashboard_custom_feed_output'); //add new rss feed output
	wp_add_dashboard_widget('custom_help_widget', 'Help and Support', 'custom_dashboard_help'); // add a new custom widget for help and support
}

function dashboard_custom_feed_output() {
	echo '<div class="rss-widget">';
	wp_widget_rss_output(array(
		'url' => 'http://www.versatiledesignstudios.com/?feed=rdf',
		'title' => 'What\'s up at Versatile Design Studios',
		'items' => 2,
		'show_summary' => 1,
		'show_author' => 0,
		'show_date' => 1 
	));
	echo "</div>";	
}

function custom_dashboard_help() {
	echo '
		<p>Need help? That "help" tab up top provides contextual help throughout the administrative panel. If you need additional support, you can contact your web team at <a href="http://www.versatiledesignstudios.com">VersatileDesignStudios</a>:</p>
		<p><strong>phone:</strong> 509.396.9991</p>
		<p><strong>email:</strong> <a href="mailto:office@versatiledesignstudios.com">office@versatiledesignstudios.com</a><p> 
	';
}


/**
 * custom contextual help - tack on our support information to the end of the contextual help
 */
 
add_filter( 'contextual_help', 'custom_help_support', 100 ); //giving a very late priority (100) to make sure it's always at the end (10 is default)

function custom_help_support($help) {
	$help .= '
		<p><strong>Additional support</strong> - Contact the web team at <a href="http://www.versatiledesignstudios.com">Versatile Design Studios</a> 
		by phone at 509.396.9991 or by email at <a href="mailto:office@versatiledesignstudios.com">office@versatiledesignstudios.com</a>.<p>
	';
	return $help;
}


/***********************************/
/*** PART TWO: CLEANING UP ADMIN ***/
/***********************************/

/**
 * custom "admin lite" role
 * we want an editor that can also: manage users, manage plugins, unfiltered upload, manage options
 */

add_action( 'admin_init', 'setup_admin_lite_role' );

function setup_admin_lite_role() {
	// remove_role( 'adminlite' ); // for testing - once you add the role, it sticks!

	if ( !get_role('adminlite') ) {
		$caps = get_role('admin')->capabilities; //let's use the editor( now admin ) as the base  capabilities
		$caps = array_merge( $caps, array(
			'install_plugins' => true,
			'activate_plugins' => true,
			'update_plugins' => false,
			'delete_plugins' => false,
			'list_users' => true, //wp3.0
			'create_users' => true,
			'edit_users' => false,
			'delete_users' => false,
			'unfiltered_upload' => true,
			'edit_theme_options' => true //wp3.0
		)); //adding new capabilities: reference http://codex.wordpress.org/Roles_and_Capabilities#Capability_vs._Role_Table
		
		add_role( 'adminlite', 'Administrator Lite', $caps );
	}
}
 


/**
 * If you're a CMS use case, maybe your client thinks of "posts" as "articles" (news).
 * Let's hijack the text translation an globally replace "post" with "article" in the admin.
 */
 
add_filter( 'gettext', 'change_post_to_article' );
add_filter( 'ngettext', 'change_post_to_article' );

function change_post_to_article( $translated ) {
	$translated = str_ireplace( 'Post', 'Article', $translated );	// ireplace is PHP5 only
	return $translated;
}

/**
 * let's eliminate some sidebar widgets we know the client will never use
 */
 
add_action( 'widgets_init', 'custom_remove_widgets' );

function custom_remove_widgets() {
	//unregister_widget( 'WP_Widget_Pages' );
	//unregister_widget( 'WP_Widget_Categories' );
	unregister_widget( 'WP_Widget_Archives' );	
	unregister_widget( 'WP_Widget_Meta' );	
	//unregister_widget( 'WP_Widget_Links' );
}


/**
 * meaningful post specific help
 */
 
add_filter( 'contextual_help', 'custom_post_help', 10, 3 );	

function custom_post_help( $help, $screenid, $screen ) {
	if ( $screenid == 'post' ) {
		$help .= '
			<p><strong>Front Page Posts</strong> - Be sure to assign posts you want highlighted 
			on the front page of the website to the "Featured" category.<p>
		';
	}
	
	return $help;
}


/**
 * trim down page and post meta boxes to the basics... except for full admins
 * tip: looking for the ID? inspect the meta box wrapper in the HTML and look for the ID attribute 
 */

if ( !current_user_can('manage_options') )
	add_action('admin_init','customize_page_meta_boxes');

function customize_page_meta_boxes() {
	remove_meta_box('postcustom','page','normal');
	remove_meta_box('postcustom','post','normal');
	remove_meta_box('commentstatusdiv','page','normal');
	remove_meta_box('authordiv','page','normal');
	remove_meta_box('trackbacksdiv','post','normal');
}


/**
 * let's tailor TinyMCE a bit based on what they plan to do
 */
 
add_filter("mce_external_plugins", "add_nonbreaking_tinymce_plugin"); // let's add a new tinymce plugin

function add_nonbreaking_tinymce_plugin($plugins) {
	$plugins['nonbreaking'] = get_stylesheet_directory_uri() . '/tinymce-plugins/nonbreaking.js'; //this was pulled out of original tinymce plugins
	return $plugins;
}
 
add_filter('mce_buttons_2', 'custom_mcetable_buttons'); //let's remove some buttons from the second row, and add this one 

function custom_mcetable_buttons($buttons) {
	// var_dump($buttons); // use this to get the names or keys of all the tinymce buttons... or just count
	 
	unset( $buttons[2] ); // full justify
	unset( $buttons[9] ); // embed media
	
	array_splice( $buttons, 9, 0, "nonbreaking" );	// add new nonbreaking button after the special characters buttons
	
	return $buttons;
}


/**
 * customizing editor styles - super easy in WordPress 3.0!
 */

add_action( 'after_setup_theme', 'custom_admin_after_setup' ); 

function custom_admin_after_setup() {
	add_editor_style(); // that's it! by default it looks for 'editor-style.css', but you can pass can alernate file name if desired
}


/**
 * adding the post ID to the posts list
 */

add_filter( 'manage_posts_columns', 'custom_post_id_column', 10, 2 );

function custom_post_id_column( $post_columns, $post_type ) {
	if ( $post_type == 'post' ) {
		$beginning = array_slice( $post_columns, 0, 1 );
		$beginning['postid'] = __('ID');
		$ending = array_slice( $post_columns, 1 );
		$post_columns = array_merge( $beginning, $ending );
	}
	return $post_columns;
}

add_action( 'manage_posts_custom_column', 'custom_post_column_id', 10, 2 );

function custom_post_column_id( $column_name, $postid ) {
	if ( $column_name == "postid" )
		echo $postid;
}


endif; //wrapper for admin functions
/**
 * Retrieve or display pagination code.
 *
 * The defaults for overwriting are:
 * 'page' - Default is null (int). The current page. This function will
 *      automatically determine the value.
 * 'pages' - Default is null (int). The total number of pages. This function will
 *      automatically determine the value.
 * 'range' - Default is 3 (int). The number of page links to show before and after
 *      the current page.
 * 'gap' - Default is 3 (int). The minimum number of pages before a gap is 
 *      replaced with ellipses (...).
 * 'anchor' - Default is 1 (int). The number of links to always show at begining
 *      and end of pagination
 * 'before' - Default is '<div class="emm-paginate">' (string). The html or text 
 *      to add before the pagination links.
 * 'after' - Default is '</div>' (string). The html or text to add after the
 *      pagination links.
 * 'title' - Default is '__('Pages:')' (string). The text to display before the
 *      pagination links.
 * 'next_page' - Default is '__('&raquo;')' (string). The text to use for the 
 *      next page link.
 * 'previous_page' - Default is '__('&laquo')' (string). The text to use for the 
 *      previous page link.
 * 'echo' - Default is 1 (int). To return the code instead of echo'ing, set this
 *      to 0 (zero).
 *
 * @author Eric Martin <eric@ericmmartin.com>
 * @copyright Copyright (c) 2009, Eric Martin
 * @version 1.0
 *
 * @param array|string $args Optional. Override default arguments.
 * @return string HTML content, if not displaying.
 */
function emm_paginate($args = null) {
	$defaults = array(
		'page' => null, 'pages' => null, 
		'range' => 3, 'gap' => 3, 'anchor' => 1,
		'before' => '<div class="emm-paginate">', 'after' => '</div>',
		'title' => __('Pages:'),
		'nextpage' => __('&raquo;'), 'previouspage' => __('&laquo'),
		'echo' => 1
	);

	$r = wp_parse_args($args, $defaults);
	extract($r, EXTR_SKIP);

	if (!$page && !$pages) {
		global $wp_query;

		$page = get_query_var('paged');
		$page = !empty($page) ? intval($page) : 1;

		$posts_per_page = intval(get_query_var('posts_per_page'));
		$pages = intval(ceil($wp_query->found_posts / $posts_per_page));
	}
	
	$output = "";
	if ($pages > 1) {	
		$output .= "$before<span class='emm-title'>$title</span>";
		$ellipsis = "<span class='emm-gap'>...</span>";

		if ($page > 1 && !empty($previouspage)) {
			$output .= "<a href='" . get_pagenum_link($page - 1) . "' class='emm-prev'>$previouspage</a>";
		}
		
		$min_links = $range * 2 + 1;
		$block_min = min($page - $range, $pages - $min_links);
		$block_high = max($page + $range, $min_links);
		$left_gap = (($block_min - $anchor - $gap) > 0) ? true : false;
		$right_gap = (($block_high + $anchor + $gap) < $pages) ? true : false;

		if ($left_gap && !$right_gap) {
			$output .= sprintf('%s%s%s', 
				emm_paginate_loop(1, $anchor), 
				$ellipsis, 
				emm_paginate_loop($block_min, $pages, $page)
			);
		}
		else if ($left_gap && $right_gap) {
			$output .= sprintf('%s%s%s%s%s', 
				emm_paginate_loop(1, $anchor), 
				$ellipsis, 
				emm_paginate_loop($block_min, $block_high, $page), 
				$ellipsis, 
				emm_paginate_loop(($pages - $anchor + 1), $pages)
			);
		}
		else if ($right_gap && !$left_gap) {
			$output .= sprintf('%s%s%s', 
				emm_paginate_loop(1, $block_high, $page),
				$ellipsis,
				emm_paginate_loop(($pages - $anchor + 1), $pages)
			);
		}
		else {
			$output .= emm_paginate_loop(1, $pages, $page);
		}

		if ($page < $pages && !empty($nextpage)) {
			$output .= "<a href='" . get_pagenum_link($page + 1) . "' class='emm-next'>$nextpage</a>";
		}

		$output .= $after;
	}

	if ($echo) {
		echo $output;
	}

	return $output;
}

/**
 * Helper function for pagination which builds the page links.
 *
 * @access private
 *
 * @author Eric Martin <eric@ericmmartin.com>
 * @copyright Copyright (c) 2009, Eric Martin
 * @version 1.0
 *
 * @param int $start The first link page.
 * @param int $max The last link page.
 * @return int $page Optional, default is 0. The current page.
 */
function emm_paginate_loop($start, $max, $page = 0) {
	$output = "";
	for ($i = $start; $i <= $max; $i++) {
		$output .= ($page === intval($i)) 
			? "<span class='emm-page emm-current'>$i</span>" 
			: "<a href='" . get_pagenum_link($i) . "' class='emm-page'>$i</a>";
	}
	return $output;
}



//Breadcrumb functionality
/**
 * Yes, we're localizing the plugin.  This partly makes sure non-English users can use it too.  
 * To translate into your language use the breadcrumb-trail-en_EN.po file as as guide.  Poedit 
 * is a good tool to for translating.
 * @link http://poedit.net
 *
 * @since 0.1.0
 */
load_plugin_textdomain( 'breadcrumb-trail', false, 'breadcrumb-trail' );

/**
 * Shows a breadcrumb for all types of pages.  This function is formatting the final output of the 
 * breadcrumb trail.  The breadcrumb_trail_get_items() function returns the items and this function 
 * formats those items.
 *
 * @since 0.1.0
 * @param array $args Mixed arguments for the menu.
 * @return string Output of the breadcrumb menu.
 */
function breadcrumb_trail( $args = array() ) {
	global $wp_query;

	/* Get the textdomain. */
	$textdomain = breadcrumb_trail_textdomain();

	/* Create an empty variable for the breadcrumb. */
	$breadcrumb = '';

	/* Set up the default arguments for the breadcrumb. */
	$defaults = array(
		'separator' => '&raquo;',
		'before' => '<span class="breadcrumb-title">' . __( '', $textdomain ) . '</span>',
		'after' => false,
		'front_page' => false,
		'show_home' => __( 'Home', $textdomain ),
		'echo' => true
	);

	/* Allow singular post views to have a taxonomy's terms prefixing the trail. */
	if ( is_singular() )
		$defaults["singular_{$wp_query->post->post_type}_taxonomy"] = false;

	/* Apply filters to the arguments. */
	$args = apply_filters( 'breadcrumb_trail_args', $args );

	/* Parse the arguments and extract them for easy variable naming. */
	$args = wp_parse_args( $args, $defaults );

	/* Get the trail items. */
	$trail = breadcrumb_trail_get_items( $args );

	/* Connect the breadcrumb trail if there are items in the trail. */
	if ( !empty( $trail ) && is_array( $trail ) ) {

		/* Open the breadcrumb trail containers. */
		$breadcrumb = '<div class="breadcrumb breadcrumbs"><div class="breadcrumb-trail">';

		/* If $before was set, wrap it in a container. */
		$breadcrumb .= ( !empty( $args['before'] ) ? '<span class="trail-before">' . $args['before'] . '</span> ' : '' );

		/* Wrap the $trail['trail_end'] value in a container. */
		if ( !empty( $trail['trail_end'] ) )
			$trail['trail_end'] = '<span class="trail-end">' . $trail['trail_end'] . '</span>';

		/* Format the separator. */
		$separator = ( !empty( $args['separator'] ) ? '<span class="sep">' . $args['separator'] . '</span>' : '<span class="sep">/</span>' );

		/* Join the individual trail items into a single string. */
		$breadcrumb .= join( " {$separator} ", $trail );

		/* If $after was set, wrap it in a container. */
		$breadcrumb .= ( !empty( $args['after'] ) ? ' <span class="trail-after">' . $args['after'] . '</span>' : '' );

		/* Close the breadcrumb trail containers. */
		$breadcrumb .= '</div></div>';
	}

	/* Allow developers to filter the breadcrumb trail HTML. */
	$breadcrumb = apply_filters( 'breadcrumb_trail', $breadcrumb );

	/* Output the breadcrumb. */
	if ( $args['echo'] )
		echo $breadcrumb;
	else
		return $breadcrumb;
}

/**
 * Gets the items for the breadcrumb trail.  This is the heart of the script.  It checks the current page 
 * being viewed and decided based on the information provided by WordPress what items should be
 * added to the breadcrumb trail.
 *
 * @since 0.4.0
 * @todo Build in caching based on the queried object ID.
 * @param array $args Mixed arguments for the menu.
 * @return array List of items to be shown in the trail.
 */
function breadcrumb_trail_get_items( $args = array() ) {
	global $wp_query, $wp_rewrite;

	/* Get the textdomain. */
	$textdomain = breadcrumb_trail_textdomain();

	/* Set up an empty trail array and empty path. */
	$trail = array();
	$path = '';

	/* If $show_home is set and we're not on the front page of the site, link to the home page. */
	if ( !is_front_page() && $args['show_home'] )
		$trail[] = '<a href="' . home_url() . '" title="' . esc_attr( get_bloginfo( 'name' ) ) . '" rel="home" class="trail-begin">' . $args['show_home'] . '</a>';

	/* If viewing the front page of the site. */
	if ( is_front_page() ) {
		if ( $args['show_home'] && $args['front_page'] )
			$trail['trail_end'] = "{$args['show_home']}";
	}

	/* If viewing the "home"/posts page. */
	elseif ( is_home() ) {
		$home_page = get_page( $wp_query->get_queried_object_id() );
		$trail = array_merge( $trail, breadcrumb_trail_get_parents( $home_page->post_parent, '' ) );
		$trail['trail_end'] = get_the_title( $home_page->ID );
	}

	/* If viewing a singular post (page, attachment, etc.). */
	elseif ( is_singular() ) {

		/* Get singular post variables needed. */
		$post = $wp_query->get_queried_object();
		$post_id = absint( $wp_query->get_queried_object_id() );
		$post_type = $post->post_type;
		$parent = absint( $post->post_parent );

		/* Get the post type object. */
		$post_type_object = get_post_type_object( $post_type );

		/* If viewing a singular 'post'. */
		if ( 'post' == $post_type ) {

			/* If $front has been set, add it to the $path. */
			$path .= trailingslashit( $wp_rewrite->front );

			/* If there's a path, check for parents. */
			if ( !empty( $path ) )
				$trail = array_merge( $trail, breadcrumb_trail_get_parents( '', $path ) );

			/* Map the permalink structure tags to actual links. */
			$trail = array_merge( $trail, breadcrumb_trail_map_rewrite_tags( $post_id, get_option( 'permalink_structure' ) ) );
		}

		/* If viewing a singular 'attachment'. */
		elseif ( 'attachment' == $post_type ) {

			/* If $front has been set, add it to the $path. */
			$path .= trailingslashit( $wp_rewrite->front );

			/* If there's a path, check for parents. */
			if ( !empty( $path ) )
				$trail = array_merge( $trail, breadcrumb_trail_get_parents( '', $path ) );

			/* Map the post (parent) permalink structure tags to actual links. */
			$trail = array_merge( $trail, breadcrumb_trail_map_rewrite_tags( $post->post_parent, get_option( 'permalink_structure' ) ) );
		}

		/* If a custom post type, check if there are any pages in its hierarchy based on the slug. */
		elseif ( 'page' !== $post_type ) {

			/* If $front has been set, add it to the $path. */
			if ( $post_type_object->rewrite['with_front'] && $wp_rewrite->front )
				$path .= trailingslashit( $wp_rewrite->front );

			/* If there's a slug, add it to the $path. */
			if ( !empty( $post_type_object->rewrite['slug'] ) )
				$path .= $post_type_object->rewrite['slug'];

			/* If there's a path, check for parents. */
			if ( !empty( $path ) )
				$trail = array_merge( $trail, breadcrumb_trail_get_parents( '', $path ) );

			/* If there's an archive page, add it to the trail. */
			if ( !empty( $post_type_object->rewrite['archive'] ) && function_exists( 'get_post_type_archive_link' ) )
				$trail[] = '<a href="' . get_post_type_archive_link( $post_type ) . '" title="' . esc_attr( $post_type_object->labels->name ) . '">' . $post_type_object->labels->name . '</a>';
		}

		/* If the post type path returns nothing and there is a parent, get its parents. */
		if ( ( empty( $path ) && 0 !== $parent ) || ( 'attachment' == $post_type ) )
			$trail = array_merge( $trail, breadcrumb_trail_get_parents( $parent, '' ) );

		/* Or, if the post type is hierarchical and there's a parent, get its parents. */
		elseif ( 0 !== $parent && is_post_type_hierarchical( $post_type ) )
			$trail = array_merge( $trail, breadcrumb_trail_get_parents( $parent, '' ) );

		/* Display terms for specific post type taxonomy if requested. */
		if ( !empty( $args["singular_{$post_type}_taxonomy"] ) && $terms = get_the_term_list( $post_id, $args["singular_{$post_type}_taxonomy"], '', ', ', '' ) )
			$trail[] = $terms;

		/* End with the post title. */
		$post_title = get_the_title();
		if ( !empty( $post_title ) )
			$trail['trail_end'] = $post_title;
	}

	/* If we're viewing any type of archive. */
	elseif ( is_archive() ) {

		/* If viewing a taxonomy term archive. */
		if ( is_tax() || is_category() || is_tag() ) {

			/* Get some taxonomy and term variables. */
			$term = $wp_query->get_queried_object();
			$taxonomy = get_taxonomy( $term->taxonomy );

			/* Get the path to the term archive. Use this to determine if a page is present with it. */
			if ( is_category() )
				$path = get_option( 'category_base' );
			elseif ( is_tag() )
				$path = get_option( 'tag_base' );
			else {
				if ( $taxonomy->rewrite['with_front'] && $wp_rewrite->front )
					$path = trailingslashit( $wp_rewrite->front );
				$path .= $taxonomy->rewrite['slug'];
			}

			/* Get parent pages by path if they exist. */
			if ( $path )
				$trail = array_merge( $trail, breadcrumb_trail_get_parents( '', $path ) );

			/* If the taxonomy is hierarchical, list its parent terms. */
			if ( is_taxonomy_hierarchical( $term->taxonomy ) && $term->parent )
				$trail = array_merge( $trail, breadcrumb_trail_get_term_parents( $term->parent, $term->taxonomy ) );

			/* Add the term name to the trail end. */
			if ( function_exists( 'single_term_title' ) )
				$trail['trail_end'] = single_term_title( '', false );
			else
				$trail['trail_end'] = $term->name;
		}

		/* If viewing a post type archive. */
		elseif ( function_exists( 'is_post_type_archive' ) && is_post_type_archive() ) {

			/* Get the post type object. */
			$post_type_object = get_post_type_object( get_query_var( 'post_type' ) );

			/* If $front has been set, add it to the $path. */
			if ( $post_type_object->rewrite['with_front'] && $wp_rewrite->front )
				$path .= trailingslashit( $wp_rewrite->front );

			/* If there's a slug, add it to the $path. */
			if ( !empty( $post_type_object->rewrite['archive'] ) )
				$path .= $post_type_object->rewrite['archive'];

			/* If there's a path, check for parents. */
			if ( !empty( $path ) )
				$trail = array_merge( $trail, breadcrumb_trail_get_parents( '', $path ) );

			/* Add the post type [plural] name to the trail end. */
			$trail['trail_end'] = $post_type_object->labels->name;
		}

		/* If viewing an author archive. */
		elseif ( is_author() ) {

			/* If $front has been set, add it to $path. */
			if ( !empty( $wp_rewrite->front ) )
				$path .= trailingslashit( $wp_rewrite->front );

			/* If an $author_base exists, add it to $path. */
			if ( !empty( $wp_rewrite->author_base ) )
				$path .= $wp_rewrite->author_base;

			/* If $path exists, check for parent pages. */
			if ( !empty( $path ) )
				$trail = array_merge( $trail, breadcrumb_trail_get_parents( '', $path ) );

			/* Add the author's display name to the trail end. */
			$trail['trail_end'] = get_the_author_meta( 'display_name', get_query_var( 'author' ) );
		}

		/* If viewing a time-based archive. */
		elseif ( is_time() ) {

			if ( get_query_var( 'minute' ) && get_query_var( 'hour' ) )
				$trail['trail_end'] = get_the_time( __( 'g:i a', $textdomain ) );

			elseif ( get_query_var( 'minute' ) )
				$trail['trail_end'] = sprintf( __( 'Minute %1$s', $textdomain ), get_the_time( __( 'i', $textdomain ) ) );

			elseif ( get_query_var( 'hour' ) )
				$trail['trail_end'] = get_the_time( __( 'g a', $textdomain ) );
		}

		/* If viewing a date-based archive. */
		elseif ( is_date() ) {

			/* If $front has been set, check for parent pages. */
			if ( $wp_rewrite->front )
				$trail = array_merge( $trail, breadcrumb_trail_get_parents( '', $wp_rewrite->front ) );

			if ( is_day() ) {
				$trail[] = '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '" title="' . get_the_time( esc_attr__( 'Y', $textdomain ) ) . '">' . get_the_time( __( 'Y', $textdomain ) ) . '</a>';
				$trail[] = '<a href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '" title="' . get_the_time( esc_attr__( 'F', $textdomain ) ) . '">' . get_the_time( __( 'F', $textdomain ) ) . '</a>';
				$trail['trail_end'] = get_the_time( __( 'd', $textdomain ) );
			}

			elseif ( get_query_var( 'w' ) ) {
				$trail[] = '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '" title="' . get_the_time( esc_attr__( 'Y', $textdomain ) ) . '">' . get_the_time( __( 'Y', $textdomain ) ) . '</a>';
				$trail['trail_end'] = sprintf( __( 'Week %1$s', $textdomain ), get_the_time( esc_attr__( 'W', $textdomain ) ) );
			}

			elseif ( is_month() ) {
				$trail[] = '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '" title="' . get_the_time( esc_attr__( 'Y', $textdomain ) ) . '">' . get_the_time( __( 'Y', $textdomain ) ) . '</a>';
				$trail['trail_end'] = get_the_time( __( 'F', $textdomain ) );
			}

			elseif ( is_year() ) {
				$trail['trail_end'] = get_the_time( __( 'Y', $textdomain ) );
			}
		}
	}

	/* If viewing search results. */
	elseif ( is_search() )
		$trail['trail_end'] = sprintf( __( 'Search results for &quot;%1$s&quot;', $textdomain ), esc_attr( get_search_query() ) );

	/* If viewing a 404 error page. */
	elseif ( is_404() )
		$trail['trail_end'] = __( '404 Not Found', $textdomain );

	/* Allow devs to step in and filter the $trail array. */
	return apply_filters( 'breadcrumb_trail_items', $trail );
}

/**
 * Turns %tag% from permalink structures into usable links for the breadcrumb trail.  This feels kind of
 * hackish for now because we're checking for specific %tag% examples and only doing it for the 'post' 
 * post type.  In the future, maybe it'll handle a wider variety of possibilities, especially for custom post
 * types.
 *
 * @since 0.4.0
 * @param int $post_id ID of the post whose parents we want.
 * @param string $path Path of a potential parent page.
 * @return array $trail Array of links to the post breadcrumb.
 */
function breadcrumb_trail_map_rewrite_tags( $post_id = '', $path = '' ) {

	/* Set up an empty $trail array. */
	$trail = array();

	/* Make sure there's a $path and $post_id before continuing. */
	if ( empty( $path ) || empty( $post_id ) )
		return $trail;

	/* Get the post based on the post ID. */
	$post = get_post( $post_id );

	/* If no post is returned, an error is returned, or the post does not have a 'post' post type, return. */
	if ( empty( $post ) || is_wp_error( $post ) || 'post' !== $post->post_type )
		return $trail;

	/* Get the textdomain. */
	$textdomain = breadcrumb_trail_textdomain();

	/* Trim '/' from both sides of the $path. */
	$path = trim( $path, '/' );

	/* Split the $path into an array of strings. */
	$matches = explode( '/', $path );

	/* If matches are found for the path. */
	if ( is_array( $matches ) ) {

		/* Loop through each of the matches, adding each to the $trail array. */
		foreach ( $matches as $match ) {

			/* Trim any '/' from the $match. */
			$tag = trim( $match, '/' );

			/* If using the %year% tag, add a link to the yearly archive. */
			if ( '%year%' == $tag )
				$trail[] = '<a href="' . get_year_link( get_the_time( 'Y', $post_id ) ) . '" title="' . get_the_time( esc_attr__( 'Y', $textdomain ), $post_id ) . '">' . get_the_time( __( 'Y', $textdomain ), $post_id ) . '</a>';

			/* If using the %monthnum% tag, add a link to the monthly archive. */
			elseif ( '%monthnum%' == $tag )
				$trail[] = '<a href="' . get_month_link( get_the_time( 'Y', $post_id ), get_the_time( 'm', $post_id ) ) . '" title="' . get_the_time( esc_attr__( 'F Y', $textdomain ), $post_id ) . '">' . get_the_time( __( 'F', $textdomain ), $post_id ) . '</a>';

			/* If using the %day% tag, add a link to the daily archive. */
			elseif ( '%day%' == $tag )
				$trail[] = '<a href="' . get_day_link( get_the_time( 'Y', $post_id ), get_the_time( 'm', $post_id ), get_the_time( 'd', $post_id ) ) . '" title="' . get_the_time( esc_attr__( 'F j, Y', $textdomain ), $post_id ) . '">' . get_the_time( __( 'd', $textdomain ), $post_id ) . '</a>';

			/* If using the %author% tag, add a link to the post author archive. */
			elseif ( '%author%' == $tag )
				$trail[] = '<a href="' . get_author_posts_url( $post->post_author ) . '" title="' . esc_attr( get_the_author_meta( 'display_name', $post->post_author ) ) . '">' . get_the_author_meta( 'display_name', $post->post_author ) . '</a>';

			/* If using the %category% tag, add a link to the first category archive to match permalinks. */
			elseif ( '%category%' == $tag ) {

				/* Get the post categories. */
				$terms = get_the_category( $post_id );

				/* Check that categories were returned. */
				if ( $terms ) {

					/* Sort the terms by ID and get the first category. */
					usort( $terms, '_usort_terms_by_ID' );
					$term = get_term( $terms[0], 'category' );

					/* If the category has a parent, add the hierarchy to the trail. */
					if ( 0 !== $term->parent )
						$trail = array_merge( $trail, breadcrumb_trail_get_term_parents( $term->parent, 'category' ) );

					/* Add the category archive link to the trail. */
					$trail[] = '<a href="' . get_term_link( $term, 'category' ) . '" title="' . esc_attr( $term->name ) . '">' . $term->name . '</a>';
				}
			}
		}
	}

	/* Return the $trail array. */
	return $trail;
}

/**
 * Gets parent pages of any post type or taxonomy by the ID or Path.  The goal of this function is to create 
 * a clear path back to home given what would normally be a "ghost" directory.  If any page matches the given 
 * path, it'll be added.  But, it's also just a way to check for a hierarchy with hierarchical post types.
 *
 * @since 0.3.0
 * @param int $post_id ID of the post whose parents we want.
 * @param string $path Path of a potential parent page.
 * @return array $trail Array of parent page links.
 */
function breadcrumb_trail_get_parents( $post_id = '', $path = '' ) {

	/* Set up an empty trail array. */
	$trail = array();

	/* If neither a post ID nor path set, return an empty array. */
	if ( empty( $post_id ) && empty( $path ) )
		return $trail;

	/* If the post ID is empty, use the path to get the ID. */
	if ( empty( $post_id ) ) {

		/* Get parent post by the path. */
		$parent_page = get_page_by_path( $path );

		/* If a parent post is found, set the $post_id variable to it. */
		if ( !empty( $parent_page ) )
			$post_id = $parent_page->ID;
	}

	/* If a post ID and path is set, search for a post by the given path. */
	if ( $post_id == 0 && !empty( $path ) ) {

		/* Separate post names into separate paths by '/'. */
		$path = trim( $path, '/' );
		preg_match_all( "/\/.*?\z/", $path, $matches );

		/* If matches are found for the path. */
		if ( isset( $matches ) ) {

			/* Reverse the array of matches to search for posts in the proper order. */
			$matches = array_reverse( $matches );

			/* Loop through each of the path matches. */
			foreach ( $matches as $match ) {

				/* If a match is found. */
				if ( isset( $match[0] ) ) {

					/* Get the parent post by the given path. */
					$path = str_replace( $match[0], '', $path );
					$parent_page = get_page_by_path( trim( $path, '/' ) );

					/* If a parent post is found, set the $post_id and break out of the loop. */
					if ( !empty( $parent_page ) && $parent_page->ID > 0 ) {
						$post_id = $parent_page->ID;
						break;
					}
				}
			}
		}
	}

	/* While there's a post ID, add the post link to the $parents array. */
	while ( $post_id ) {

		/* Get the post by ID. */
		$page = get_page( $post_id );

		/* Add the formatted post link to the array of parents. */
		$parents[]  = '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( get_the_title( $post_id ) ) . '">' . get_the_title( $post_id ) . '</a>';

		/* Set the parent post's parent to the post ID. */
		$post_id = $page->post_parent;
	}

	/* If we have parent posts, reverse the array to put them in the proper order for the trail. */
	if ( isset( $parents ) )
		$trail = array_reverse( $parents );

	/* Return the trail of parent posts. */
	return $trail;
}

/**
 * Searches for term parents of hierarchical taxonomies.  This function is similar to the WordPress 
 * function get_category_parents() but handles any type of taxonomy.
 *
 * @since 0.3.0
 * @param int $parent_id The ID of the first parent.
 * @param object|string $taxonomy The taxonomy of the term whose parents we want.
 * @return array $trail Array of links to parent terms.
 */
function breadcrumb_trail_get_term_parents( $parent_id = '', $taxonomy = '' ) {

	/* Set up some default arrays. */
	$trail = array();
	$parents = array();

	/* If no term parent ID or taxonomy is given, return an empty array. */
	if ( empty( $parent_id ) || empty( $taxonomy ) )
		return $trail;

	/* While there is a parent ID, add the parent term link to the $parents array. */
	while ( $parent_id ) {

		/* Get the parent term. */
		$parent = get_term( $parent_id, $taxonomy );

		/* Add the formatted term link to the array of parent terms. */
		$parents[] = '<a href="' . get_term_link( $parent, $taxonomy ) . '" title="' . esc_attr( $parent->name ) . '">' . $parent->name . '</a>';

		/* Set the parent term's parent as the parent ID. */
		$parent_id = $parent->parent;
	}

	/* If we have parent terms, reverse the array to put them in the proper order for the trail. */
	if ( !empty( $parents ) )
		$trail = array_reverse( $parents );

	/* Return the trail of parent terms. */
	return $trail;
}

/**
 * Returns the textdomain used by the script and allows it to be filtered by plugins/themes.
 *
 * @since 0.4.0
 * @returns string The textdomain for the script.
 */
function breadcrumb_trail_textdomain() {
	return apply_filters( 'breadcrumb_trail_textdomain', 'breadcrumb-trail' );
}
/**
 * Create meta box for editing pages in WordPress
 *
 * Compatible with custom post types since WordPress 3.0
 * Support input types: text, textarea, checkbox, checkbox list, radio box, select, wysiwyg, file, image, date, time, color
 *
 * @author Rilwis <rilwis@gmail.com>
 * @link http://www.deluxeblogtips.com/p/meta-box-script-for-wordpress.html
 * @example meta-box-usage.php Sample declaration and usage of meta boxes
 * @version: 3.2.2
 *
 * @license GNU General Public License v3.0
 */

/**
 * Meta Box class
 */
class RW_Meta_Box {

	protected $_meta_box;
	protected $_fields;

	// Create meta box based on given data
	function __construct($meta_box) {
		// run script only in admin area
		if (!is_admin()) return;

		// assign meta box values to local variables and add it's missed values
		$this->_meta_box = $meta_box;
		$this->_fields = &$this->_meta_box['fields'];
		$this->add_missed_values();

		add_action('add_meta_boxes', array(&$this, 'add'));	// add meta box, using 'add_meta_boxes' for WP 3.0+
		add_action('save_post', array(&$this, 'save'));		// save meta box's data

		// check for some special fields and add needed actions for them
		$this->check_field_upload();
		$this->check_field_color();
		$this->check_field_date();
		$this->check_field_time();
		$this->check_field_wysiwyg();

		// load common js, css files
		// must enqueue for all pages as we need js for the media upload, too
		add_action('admin_print_styles', array(__CLASS__, 'js_css'));
	}

	// Load common js, css files for the script
	static function js_css() {
		// change '\' to '/' in case using Windows
		$content_dir = str_replace('\\', '/', WP_CONTENT_DIR);
		$script_dir = str_replace('\\', '/', dirname(__FILE__));
		
		// get URL of the directory of current file, this works in both theme or plugin
		$base_url = str_replace($content_dir, WP_CONTENT_URL, $script_dir);

		wp_enqueue_style('rw-meta-box', $base_url . '/css/meta-box.css');
		wp_enqueue_script('rw-meta-box', $base_url . '/js/meta-box.js', array('jquery'), null, true);
	}

	/******************** BEGIN UPLOAD **********************/

	// Check field upload and add needed actions
	function check_field_upload() {
		if (!$this->has_field('image') && !$this->has_field('file')) return;

		add_action('post_edit_form_tag', array(&$this, 'add_enctype'));				// add data encoding type for file uploading

		// make upload feature works even when custom post type doesn't support 'editor'
		wp_enqueue_script('media-upload');
		add_thickbox();
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-sortable');

		add_filter('media_upload_gallery', array(&$this, 'insert_images'));			// process adding multiple images to image meta field
		add_filter('media_upload_library', array(&$this, 'insert_images'));
		add_filter('media_upload_image', array(&$this, 'insert_images'));

		// add_action('delete_post', array(&$this, 'delete_attachments'));			// delete all attachments when delete post
		add_action('wp_ajax_rw_delete_file', array(&$this, 'delete_file'));			// ajax delete files
		add_action('wp_ajax_rw_reorder_images', array(&$this, 'reorder_images'));	// ajax reorder images
	}

	// Add data encoding type for file uploading
	function add_enctype() {
		echo ' enctype="multipart/form-data"';
	}

	// Process adding images to image meta field, modifiy from 'Faster image insert' plugin
	function insert_images() {
		if (!isset($_POST['rw-insert']) || empty($_POST['attachments'])) return;

		check_admin_referer('media-form');

		$nonce = wp_create_nonce('rw_ajax_delete');
		$post_id = $_POST['post_id'];
		$id = $_POST['field_id'];

		// modify the insertion string
		$html = '';
		foreach ($_POST['attachments'] as $attachment_id => $attachment) {
			$attachment = stripslashes_deep($attachment);
			if (empty($attachment['selected']) || empty($attachment['url'])) continue;

			$li = "<li id='item_$attachment_id'>";
			$li .= "<img src='{$attachment['url']}' />";
			$li .= "<a title='" . __('Delete this image') . "' class='rw-delete-file' href='#' rel='$nonce|$post_id|$id|$attachment_id'>" . __('Delete') . "</a>";
			$li .= "<input type='hidden' name='{$id}[]' value='$attachment_id' />";
			$li .= "</li>";
			$html .= $li;
		}

		media_send_to_editor($html);
	}

	// Delete all attachments when delete post
	function delete_attachments($post_id) {
		$attachments = get_posts(array(
			'numberposts' => -1,
			'post_type' => 'attachment',
			'post_parent' => $post_id
		));
		if (!empty($attachments)) {
			foreach ($attachments as $att) {
				wp_delete_attachment($att->ID);
			}
		}
	}

	// Ajax callback for deleting files. Modified from a function used by "Verve Meta Boxes" plugin (http://goo.gl/LzYSq)
	function delete_file() {
		if (!isset($_POST['data'])) die();

		list($nonce, $post_id, $key, $attach_id) = explode('|', $_POST['data']);

		if (!wp_verify_nonce($nonce, 'rw_ajax_delete')) die('1');

		// wp_delete_attachment($attach_id);
		delete_post_meta($post_id, $key, $attach_id);

		die('0');
	}

	// Ajax callback for reordering images
	function reorder_images() {
		if (!isset($_POST['data'])) die();

		list($order, $post_id, $key, $nonce) = explode('|',$_POST['data']);

		if (!wp_verify_nonce($nonce, 'rw_ajax_reorder')) die('1');

		parse_str($order, $items);
		$items = $items['item'];
		$order = 1;
		foreach ($items as $item) {
			wp_update_post(array(
				'ID' => $item,
				'post_parent' => $post_id,
				'menu_order' => $order
			));
			$order++;
		}

		die('0');
	}

	/******************** END UPLOAD **********************/

	/******************** BEGIN OTHER FIELDS **********************/

	// Check field color
	function check_field_color() {
		if ($this->has_field('color') && self::is_edit_page()) {
			wp_enqueue_style('farbtastic');		// enqueue built-in script and style for color picker
			wp_enqueue_script('farbtastic');
		}
	}

	// Check field date
	function check_field_date() {
		if ($this->has_field('date') && self::is_edit_page()) {
			// add style and script, use proper jQuery UI version
			wp_enqueue_style('rw-jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/' . self::get_jqueryui_ver() . '/themes/base/jquery-ui.css');
			wp_enqueue_script('rw-jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/' . self::get_jqueryui_ver() . '/jquery-ui.min.js', array('jquery'));
		}
	}

	// Check field time
	function check_field_time() {
		if ($this->has_field('time') && self::is_edit_page()) {
			// add style and script, use proper jQuery UI version
			wp_enqueue_style('rw-jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/' . self::get_jqueryui_ver() . '/themes/base/jquery-ui.css');
			wp_enqueue_script('rw-jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/' . self::get_jqueryui_ver() . '/jquery-ui.min.js', array('jquery'));
			wp_enqueue_script('rw-timepicker', 'https://github.com/trentrichardson/jQuery-Timepicker-Addon/raw/master/jquery-ui-timepicker-addon.js', array('rw-jquery-ui'));
		}
	}

	// Check field WYSIWYG
	function check_field_wysiwyg() {
		if ($this->has_field('wysiwyg') && self::is_edit_page()) {
			add_action('admin_print_footer_scripts', 'wp_tiny_mce', 25);
		}
	}
	
	/******************** END OTHER FIELDS **********************/

	/******************** BEGIN META BOX PAGE **********************/

	// Add meta box for multiple post types
	function add() {
		foreach ($this->_meta_box['pages'] as $page) {
			add_meta_box($this->_meta_box['id'], $this->_meta_box['title'], array(&$this, 'show'), $page, $this->_meta_box['context'], $this->_meta_box['priority']);
		}
	}

	// Callback function to show fields in meta box
	function show() {
		global $post;

		wp_nonce_field(basename(__FILE__), 'rw_meta_box_nonce');
		echo '<table class="form-table">';

		foreach ($this->_fields as $field) {
			$meta = get_post_meta($post->ID, $field['id'], !$field['multiple']);
			$meta = ($meta !== '') ? $meta : $field['std'];

			$meta = is_array($meta) ? array_map('esc_attr', $meta) : esc_attr($meta);

			echo '<tr>';
			// call separated methods for displaying each type of field
			call_user_func(array(&$this, 'show_field_' . $field['type']), $field, $meta);
			echo '</tr>';
		}
		echo '</table>';
	}

	/******************** END META BOX PAGE **********************/

	/******************** BEGIN META BOX FIELDS **********************/

	function show_field_begin($field, $meta) {
		echo "<th class='rw-label'><label for='{$field['id']}'>{$field['name']}</label></th><td class='rw-field'>";
	}

	function show_field_end($field, $meta) {
		echo "<br />{$field['desc']}</td>";
	}

	function show_field_text($field, $meta) {
		$this->show_field_begin($field, $meta);
		echo "<input type='text' class='rw-text' name='{$field['id']}' id='{$field['id']}' value='$meta' size='30' />";
		$this->show_field_end($field, $meta);
	}

	function show_field_textarea($field, $meta) {
		$this->show_field_begin($field, $meta);
		echo "<textarea class='rw-textarea large-text' name='{$field['id']}' id='{$field['id']}' cols='60' rows='10'>$meta</textarea>";
		$this->show_field_end($field, $meta);
	}

	function show_field_select($field, $meta) {
		if (!is_array($meta)) $meta = (array) $meta;
		$this->show_field_begin($field, $meta);
		echo "<select class='rw-select' name='{$field['id']}" . ($field['multiple'] ? "[]' id='{$field['id']}' multiple='multiple'" : "'") . ">";
		foreach ($field['options'] as $key => $value) {
			echo "<option value='$key'" . selected(in_array($key, $meta), true, false) . ">$value</option>";
		}
		echo "</select>";
		$this->show_field_end($field, $meta);
	}

	function show_field_radio($field, $meta) {
		$this->show_field_begin($field, $meta);
		foreach ($field['options'] as $key => $value) {
			echo "<input type='radio' class='rw-radio' name='{$field['id']}' value='$key'" . checked($meta, $key, false) . " /> $value ";
		}
		$this->show_field_end($field, $meta);
	}

	function show_field_checkbox($field, $meta) {
		$this->show_field_begin($field, $meta);
		echo "<input type='checkbox' class='rw-checkbox' name='{$field['id']}' id='{$field['id']}'" . checked(!empty($meta), true, false) . " /> {$field['desc']}</td>";
	}

	function show_field_wysiwyg($field, $meta) {
		$this->show_field_begin($field, $meta);
		echo "<textarea class='rw-wysiwyg theEditor large-text' name='{$field['id']}' id='{$field['id']}' cols='60' rows='10'>$meta</textarea>";
		$this->show_field_end($field, $meta);
	}

	function show_field_file($field, $meta) {
		global $post;

		if (!is_array($meta)) $meta = (array) $meta;

		$this->show_field_begin($field, $meta);
		echo "{$field['desc']}<br />";

		if (!empty($meta)) {
			$nonce = wp_create_nonce('rw_ajax_delete');
			echo '<div style="margin-bottom: 10px"><strong>' . __('Uploaded files') . '</strong></div>';
			echo '<ol class="rw-upload">';
			foreach ($meta as $att) {
				// if (wp_attachment_is_image($att)) continue; // what's image uploader for?
				echo "<li>" . wp_get_attachment_link($att, '' , false, false, ' ') . " (<a class='rw-delete-file' href='#' rel='$nonce|{$post->ID}|{$field['id']}|$att'>" . __('Delete') . "</a>)</li>";
			}
			echo '</ol>';
		}

		// show form upload
		echo "<div style='clear: both'><strong>" . __('Upload new files') . "</strong></div>
			<div class='new-files'>
				<div class='file-input'><input type='file' name='{$field['id']}[]' /></div>
				<a class='rw-add-file' href='#'>" . __('Add more file') . "</a>
			</div>
		</td>";
	}

	function show_field_image($field, $meta) {
		global $wpdb, $post;

		if (!is_array($meta)) $meta = (array) $meta;

		$this->show_field_begin($field, $meta);
		echo "{$field['desc']}<br />";

		$nonce_delete = wp_create_nonce('rw_ajax_delete');
		$nonce_sort = wp_create_nonce('rw_ajax_reorder');

		echo "<input type='hidden' class='rw-images-data' value='{$post->ID}|{$field['id']}|$nonce_sort' />
			  <ul class='rw-images rw-upload' id='rw-images-{$field['id']}'>";

		// re-arrange images with 'menu_order', thanks Onur
		if (!empty($meta)) {
			$meta = implode(',', $meta);
			$images = $wpdb->get_col("
				SELECT ID FROM $wpdb->posts
				WHERE post_type = 'attachment'
				AND ID in ($meta)
				ORDER BY menu_order ASC
			");
			foreach ($images as $image) {
				$src = wp_get_attachment_image_src($image);
				$src = $src[0];

				echo "<li id='item_$image'>
						<img src='$src' />
						<a title='" . __('Delete this image') . "' class='rw-delete-file' href='#' rel='$nonce_delete|{$post->ID}|{$field['id']}|$image'>" . __('Delete') . "</a>
						<input type='hidden' name='{$field['id']}[]' value='$image' />
					</li>";
			}
		}
		echo '</ul>';

		echo "<a href='#' class='rw-upload-button button' rel='{$post->ID}|{$field['id']}'>" . __('Add more images') . "</a>";
	}

	function show_field_color($field, $meta) {
		if (empty($meta)) $meta = '#';
		$this->show_field_begin($field, $meta);
		echo "<input class='rw-color' type='text' name='{$field['id']}' id='{$field['id']}' value='$meta' size='8' />
			  <a href='#' class='rw-color-select' rel='{$field['id']}'>" . __('Select a color') . "</a>
			  <div style='display:none' class='rw-color-picker' rel='{$field['id']}'></div>";
		$this->show_field_end($field, $meta);
	}

	function show_field_checkbox_list($field, $meta) {
		if (!is_array($meta)) $meta = (array) $meta;
		$this->show_field_begin($field, $meta);
		$html = array();
		foreach ($field['options'] as $key => $value) {
			$html[] = "<input type='checkbox' class='rw-checkbox_list' name='{$field['id']}[]' value='$key'" . checked(in_array($key, $meta), true, false) . " /> $value";
		}
		echo implode('<br />', $html);
		$this->show_field_end($field, $meta);
	}

	function show_field_date($field, $meta) {
		$this->show_field_begin($field, $meta);
		echo "<input type='text' class='rw-date' name='{$field['id']}' id='{$field['id']}' rel='{$field['format']}' value='$meta' size='30' />";
		$this->show_field_end($field, $meta);
	}

	function show_field_time($field, $meta) {
		$this->show_field_begin($field, $meta);
		echo "<input type='text' class='rw-time' name='{$field['id']}' id='{$field['id']}' rel='{$field['format']}' value='$meta' size='30' />";
		$this->show_field_end($field, $meta);
	}

	/******************** END META BOX FIELDS **********************/

	/******************** BEGIN META BOX SAVE **********************/

	// Save data from meta box
	function save($post_id) {
		global $post_type;
		$post_type_object = get_post_type_object($post_type);

		if ((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)						// check autosave
		|| (!isset($_POST['post_ID']) || $post_id != $_POST['post_ID'])			// check revision
		|| (!in_array($post_type, $this->_meta_box['pages']))					// check if current post type is supported
		|| (!check_admin_referer(basename(__FILE__), 'rw_meta_box_nonce'))		// verify nonce
		|| (!current_user_can($post_type_object->cap->edit_post, $post_id))) {	// check permission
			return $post_id;
		}
		
		foreach ($this->_fields as $field) {
			$name = $field['id'];
			$type = $field['type'];
			$old = get_post_meta($post_id, $name, !$field['multiple']);
			$new = isset($_POST[$name]) ? $_POST[$name] : ($field['multiple'] ? array() : '');

			// validate meta value
			if (class_exists('RW_Meta_Box_Validate') && method_exists('RW_Meta_Box_Validate', $field['validate_func'])) {
				$new = call_user_func(array('RW_Meta_Box_Validate', $field['validate_func']), $new);
			}

			// call defined method to save meta value, if there's no methods, call common one
			$save_func = 'save_field_' . $type;
			if (method_exists($this, $save_func)) {
				call_user_func(array(&$this, 'save_field_' . $type), $post_id, $field, $old, $new);
			} else {
				$this->save_field($post_id, $field, $old, $new);
			}
		}
	}

	// Common functions for saving field
	function save_field($post_id, $field, $old, $new) {
		$name = $field['id'];

		delete_post_meta($post_id, $name);
		if ($new === '' || $new === array()) return;

		if ($field['multiple']) {
			foreach ($new as $add_new) {
				add_post_meta($post_id, $name, $add_new, false);
			}
		} else {
			update_post_meta($post_id, $name, $new);
		}

	}

	function save_field_wysiwyg($post_id, $field, $old, $new) {
		$new = wpautop($new);
		$this->save_field($post_id, $field, $old, $new);
	}

	function save_field_file($post_id, $field, $old, $new) {
		$name = $field['id'];
		if (empty($_FILES[$name])) return;

		self::fix_file_array($_FILES[$name]);

		foreach ($_FILES[$name] as $position => $fileitem) {
			$file = wp_handle_upload($fileitem, array('test_form' => false));

			if (empty($file['file'])) continue;
			$filename = $file['file'];

			$attachment = array(
				'post_mime_type' => $file['type'],
				'guid' => $file['url'],
				'post_parent' => $post_id,
				'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
				'post_content' => ''
			);
			$id = wp_insert_attachment($attachment, $filename, $post_id);
			if (!is_wp_error($id)) {
				wp_update_attachment_metadata($id, wp_generate_attachment_metadata($id, $filename));
				add_post_meta($post_id, $name, $id, false);	// save file's url in meta fields
			}
		}
	}

	/******************** END META BOX SAVE **********************/

	/******************** BEGIN HELPER FUNCTIONS **********************/

	// Add missed values for meta box
	function add_missed_values() {
		// default values for meta box
		$this->_meta_box = array_merge(array(
			'context' => 'normal',
			'priority' => 'high',
			'pages' => array('post')
		), $this->_meta_box);

		// default values for fields
		foreach ($this->_fields as &$field) {
			$multiple = in_array($field['type'], array('checkbox_list', 'file', 'image'));
			$std = $multiple ? array() : '';
			$format = 'date' == $field['type'] ? 'yy-mm-dd' : ('time' == $field['type'] ? 'hh:mm' : '');

			$field = array_merge(array(
				'multiple' => $multiple,
				'std' => $std,
				'desc' => '',
				'format' => $format,
				'validate_func' => ''
			), $field);
		}
	}

	// Check if field with $type exists
	function has_field($type) {
		foreach ($this->_fields as $field) {
			if ($type == $field['type']) return true;
		}
		return false;
	}

	// Check if current page is edit page
	static function is_edit_page() {
		global $pagenow;
		return in_array($pagenow, array('post.php', 'post-new.php'));
	}

	/**
	 * Fixes the odd indexing of multiple file uploads from the format:
	 *	 $_FILES['field']['key']['index']
	 * To the more standard and appropriate:
	 *	 $_FILES['field']['index']['key']
	 */
	static function fix_file_array(&$files) {
		$output = array();
		foreach ($files as $key => $list) {
			foreach ($list as $index => $value) {
				$output[$index][$key] = $value;
			}
		}
		$files = $output;
	}

	// Get proper jQuery UI version to not conflict with WP admin scripts
	static function get_jqueryui_ver() {
		global $wp_version;
		if (version_compare($wp_version, '3.1', '>=')) {
			return '1.8.10';
		}

		return '1.7.3';
	}

	/******************** END HELPER FUNCTIONS **********************/
}


/**
 * Registering meta boxes
 *
 * In this file, I'll show you how to extend the class to add more field type (in this case, the 'taxonomy' type)
 * All the definitions of meta boxes are listed below with comments, please read them carefully.
 * Note that each validation method of the Validation Class MUST return value instead of boolean as before
 *
 * You also should read the changelog to know what has been changed
 *
 * For more information, please visit: http://www.deluxeblogtips.com/2010/04/how-to-create-meta-box-wordpress-post.html
 *
 */

/********************* BEGIN EXTENDING CLASS ***********************/

/**
 * Extend RW_Meta_Box class
 * Add field type: 'taxonomy'
 */
class RW_Meta_Box_Taxonomy extends RW_Meta_Box {
	
	function add_missed_values() {
		parent::add_missed_values();
		
		// add 'multiple' option to taxonomy field with checkbox_list type
		foreach ($this->_meta_box['fields'] as $key => $field) {
			if ('taxonomy' == $field['type'] && 'checkbox_list' == $field['options']['type']) {
				$this->_meta_box['fields'][$key]['multiple'] = true;
			}
		}
	}
	
	// show taxonomy list
	function show_field_taxonomy($field, $meta) {
		global $post;
		
		if (!is_array($meta)) $meta = (array) $meta;
		
		$this->show_field_begin($field, $meta);
		
		$options = $field['options'];
		$terms = get_terms($options['taxonomy'], $options['args']);
		
		// checkbox_list
		if ('checkbox_list' == $options['type']) {
			foreach ($terms as $term) {
				echo "<input type='checkbox' name='{$field['id']}[]' value='$term->slug'" . checked(in_array($term->slug, $meta), true, false) . " /> $term->name<br/>";
			}
		}
		// select
		else {
			echo "<select name='{$field['id']}" . ($field['multiple'] ? "[]' multiple='multiple' style='height:auto'" : "'") . ">";
		
			foreach ($terms as $term) {
				echo "<option value='$term->slug'" . selected(in_array($term->slug, $meta), true, false) . ">$term->name</option>";
			}
			echo "</select>";
		}
		
		$this->show_field_end($field, $meta);
	}
}

/********************* END EXTENDING CLASS ***********************/

/********************* BEGIN DEFINITION OF META BOXES ***********************/

// prefix of meta keys, optional
// use underscore (_) at the beginning to make keys hidden, for example $prefix = '_rw_';
// you also can make prefix empty to disable it
$prefix = 'sh_';

$meta_boxes = array();

// first meta box
$meta_boxes[] = array(
	'id' => 'subhead',							// meta box id, unique per meta box
	'title' => 'Subheading',			// meta box title
	'pages' => array('post', 'page','article'),	// post types, accept custom post types as well, default is array('post'); optional
	'context' => 'normal',						// where the meta box appear: normal (default), advanced, side; optional
	'priority' => 'high',						// order of meta box: high (default), low; optional

	'fields' => array(							// list of meta fields
		array(
			'name' => 'Sub Heading',					// field name
			'desc' => 'Example: Fever put on show as they  route Grizzlies 72-10',	// field description, optional
			'id' => $prefix . 'shead',				// field id, i.e. the meta key
			'type' => 'text',						// text box
			'style' => 'width: 250px'				// custom style for field, added in v3.1
		)
	)
);
foreach ($meta_boxes as $meta_box) {
	new RW_Meta_Box_Taxonomy($meta_box);
}

$prefix = 'sc_';

$meta_boxes = array();

// second meta box
$meta_boxes[] = array(
	'id' => 'schedule',							// meta box id, unique per meta box
	'title' => 'Fever Schedule',			// meta box title
	'pages' => array('schedule'),	// post types, accept custom post types as well, default is array('post'); optional
	'context' => 'normal',						// where the meta box appear: normal (default), advanced, side; optional
	'priority' => 'high',						// order of meta box: high (default), low; optional

	'fields' => array(							// list of meta fields
		array(
			'name' => 'Opponent',					// field name
			'desc' => 'Example: Venom',	// field description, optional
			'id' => $prefix . 'opp',				// field id, i.e. the meta key
			'type' => 'text',						// text box
			'style' => 'width: 250px'				// custom style for field, added in v3.1
		),
		array(
			'name' => 'Event Date',
			'id' => $prefix . 'game',
			'type' => 'date',						// date
			'format' => 'M d'					// date format, default yy-mm-dd. Optional. See more formats here: http://goo.gl/po8vf
		),
		array(
			'name' => 'Location',
			'id' => $prefix . 'loc',
			'type' => 'radio',						// radio box
			'options' => array(						// array of key => value pairs for radio options
				'Home' => 'Home',
				'Away' => 'Away'
			)
		),
		array(
			'name' => 'Game Time',
			'id' => $prefix . 'time',
			'type' => 'time',						// time
			'format' => 'h:mm'					// time format, default hh:mm. Optional. See more formats here: http://goo.gl/hXHWz
		),
		array(
			'name' => 'Record',					// field name
			'desc' => 'Ex.: 0-0, 2-1',	// field description, optional
			'id' => $prefix . 'rec',				// field id, i.e. the meta key
			'type' => 'text',						// text box
			'style' => 'width: 250px'				// custom style for field, added in v3.1
		)
	)
);
// third meta box
$meta_boxes[] = array(
	'id' => 'postgame',
	'title' => 'Post Game',
	'pages' => array('schedule'),

	'fields' => array(
		array(
			'name' => 'Outcome',
			'id' => $prefix . 'out',
			'type' => 'radio',						// radio box
			'options' => array(						// array of key => value pairs for radio options
				'W' => 'Win',
				'L' => 'Loss'
			)
		),
		array(
			'name' => 'Final Score',	
			'desc' => 'Ex.: 35-22',	
			'id' => $prefix . 'score',	
			'type' => 'text',		
			'style' => 'width: 250px'	
		)
	)
);


foreach ($meta_boxes as $meta_box) {
	new RW_Meta_Box_Taxonomy($meta_box);
}

$prefix = 'rs_';

$meta_boxes = array();

// second meta box
$meta_boxes[] = array(
	'id' => 'roster',							// meta box id, unique per meta box
	'title' => 'Fever Roster',			// meta box title
	'pages' => array('roster'),	// post types, accept custom post types as well, default is array('post'); optional
	'context' => 'normal',						// where the meta box appear: normal (default), advanced, side; optional
	'priority' => 'high',						// order of meta box: high (default), low; optional

	'fields' => array(							// list of meta fields
		array(
			'name' => 'Number',					// field name
			'desc' => 'Example: 71',	// field description, optional
			'id' => $prefix . 'num',				// field id, i.e. the meta key
			'type' => 'text',						// text box
			'style' => 'width: 250px'				// custom style for field, added in v3.1
		),
		array(
			'name' => 'Last Name',					// field name
			'desc' => 'Example: Smith',	// field description, optional
			'id' => $prefix . 'lname',				// field id, i.e. the meta key
			'type' => 'text',						// text box
			'style' => 'width: 250px'				// custom style for field, added in v3.1
		),
		array(
			'name' => 'First Name',					// field name
			'desc' => 'Example: John',	// field description, optional
			'id' => $prefix . 'fname',				// field id, i.e. the meta key
			'type' => 'text',						// text box
			'style' => 'width: 250px'				// custom style for field, added in v3.1
		),
		array(
			'name' => 'Position',					// field name
			'desc' => 'Example: OLB',	// field description, optional
			'id' => $prefix . 'pos',				// field id, i.e. the meta key
			'type' => 'text',						// text box
			'style' => 'width: 250px'				// custom style for field, added in v3.1
		),
		array(
			'name' => 'Height',					// field name
			'desc' => 'Ex.: 6-2. NO APOSTROPHES&#33',
			'id' => $prefix . 'het',				// field id, i.e. the meta key
			'type' => 'text',						// text box
			'style' => 'width: 250px'				// custom style for field, added in v3.1
		),
		array(
			'name' => 'Weight',					// field name
			'id' => $prefix . 'wet',				// field id, i.e. the meta key
			'type' => 'text',						// text box
			'style' => 'width: 250px'				// custom style for field, added in v3.1
		),
		array(
			'name' => 'College',					// field name
			'desc' => 'Example: UTEP',	// field description, optional
			'id' => $prefix . 'col',				// field id, i.e. the meta key
			'type' => 'text',						// text box
			'style' => 'width: 250px'				// custom style for field, added in v3.1
		),
		array(
			'name' => 'Bio',					// field name
			'desc' => 'A brief bio or player statment.  Ex.: Lillard has been with the Fever since...',	// field description, optional
			'id' => $prefix . 'bio',				// field id, i.e. the meta key
			'type' => 'wysiwyg',						// text box
			'style' => 'width: 250px'				// custom style for field, added in v3.1
		)
	)
);

foreach ($meta_boxes as $meta_box) {
	new RW_Meta_Box_Taxonomy($meta_box);
}

/********************* END DEFINITION OF META BOXES ***********************/


 