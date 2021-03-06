<?php
/**
 * Subteach functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Subteach
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'subteach_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function subteach_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Subteach, use a find and replace
		 * to change 'subteach' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'subteach', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'school-menu' => esc_html__( 'School Menu', 'subteach' ),
				'admin-menu'  => esc_html( 'Admin Menu', 'subteach' )
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'subteach_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'subteach_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function subteach_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'subteach_content_width', 640 );
}
add_action( 'after_setup_theme', 'subteach_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function subteach_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'subteach' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'subteach' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'subteach_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function subteach_scripts() {
	wp_enqueue_style( 'subteach-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'subteach-style', 'rtl', 'replace' );

	wp_enqueue_script( 'subteach-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'subteach-script', get_template_directory_uri() . '/js/script.js', array('jquery'), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_page('users') ) {
		wp_enqueue_script( 'users-script', get_template_directory_uri() . '/js/users.js', array(), _S_VERSION, true);
	}
	
	if ( is_page('dashboard') || is_school() ) {
		wp_enqueue_script( 'micromodal', 'https://unpkg.com/micromodal/dist/micromodal.min.js', array(), _S_VERSION, true );

		add_action( 'wp_footer', function() {
			echo '<script>MicroModal.init();</script>';
		}, 100);
	}

	// Profile ajax request
	wp_enqueue_script( 'display_user_profile_script', get_template_directory_uri() . '/js/display_user_profile.js', array('jquery') );
	wp_localize_script( 'display_user_profile_script', 'display_user_profile_obj', array('ajaxurl' => admin_url('admin-ajax.php')) );
	wp_localize_script( 'display_user_profile_script', 'deactivate_user_obj', array('ajaxurl' => admin_url('admin-ajax.php')) );

	// Like a teacher ajax request
	wp_enqueue_script( 'like_teacher_script', get_template_directory_uri() . '/js/like_teacher.js', array('jquery') );
	wp_localize_script( 'like_teacher_script', 'like_teacher_obj', array('ajaxurl' => admin_url('admin-ajax.php')) );

		// Show interest ajax request
		wp_enqueue_script( 'show_interest_script', get_template_directory_uri() . '/js/show_interest.js', array('jquery') );
		wp_localize_script( 'show_interest_script', 'show_interest_obj', array('ajaxurl' => admin_url('admin-ajax.php')) );

}
add_action( 'wp_enqueue_scripts', 'subteach_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Redirect users to Dashboard after logging in
 */
add_filter( 'login_redirect', function( $url, $query, $user ) {
	return home_url();
}, 10, 3 );

add_action( 'admin_init', 'redirect_non_admin_users' );

/**
* Redirect non-admin users to home page
*
* This function is attached to the ???admin_init??? action hook.
*/
function redirect_non_admin_users() {
	if ( ! current_user_can( 'manage_options' )
    && ('/wp-admin/admin-post.php' !== $_SERVER['PHP_SELF'])
    && ('/wp-admin/admin-ajax.php' !== $_SERVER['PHP_SELF']) ) {
	wp_redirect( home_url() );
	exit;
	}
}

/**
 * Hide admin bar from certain user roles
 */
function hide_admin_bar( $show ) {

	if ( !current_user_can( 'edit_others_pages' ) ) :
		return false;
	endif;

	return $show;

}
add_filter( 'show_admin_bar', 'hide_admin_bar' );

/**
 * Add logout to the end of the menu
 */
function new_nav_menu_items($items) 
{
    $homelink = '<li class="home"><a href="' . wp_logout_url() . '">' . __('Logout') . '</a></li>';
    $items = $items . $homelink;

    return $items;
}
add_filter( 'wp_nav_menu_items', 'new_nav_menu_items' );