<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Subteach
 */

$user_id = get_current_user_id(); 
$profileImage = null;	
if ( isset(get_user_meta( $user_id )['profile_image']) ) {
	$profileImageID = get_user_meta( $user_id )['profile_image'][0];
	$profileImage = $profileImageID ? wp_get_attachment_image_src( $profileImageID, 'thumbnail' ) : false;
}

$status = is_active_user( $user_id ) ? 'active' : 'inactive';

/**
 * Redirect logged out users to the login page
 */
if ( !is_user_logged_in() ) {
	auth_redirect();

/**
 * Redirect inactive users to the dashboard
 */
} elseif( !is_active_user( $user_id ) && !is_page('dashboard') ) {

	wp_safe_redirect( '/' );
	exit;
}
?>

<!doctype html>
<html <?php language_attributes(); ?> data-status=<?= $status; ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php 
	wp_head(); 
	if ( is_school() ) {
		$primaryColour = get_user_meta( $user_id )['primary_colour'][0];
		$secondaryColour = get_user_meta( $user_id )['secondary_colour'][0];
	?>

	<style>
		body {
			--primary-colour: <?= $primaryColour ? $primaryColour : '#0076d6'; ?>;
			--secondary-colour: <?= $secondaryColour ? $secondaryColour : '#e3eaef'; ?>;
		}
	</style>

	<?php } ?>
</head>

<body <?php body_class(); ?> data-current-user-type=<?= get_user_type_as_string(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<header id="masthead" class="site-header">
		<div class="container">
			<div class="site-branding">
				<a href=<?= home_url(); ?>><?= $profileImage ?  '<img class="user-logo" src="' . $profileImage[0] . '" />' : get_custom_logo(); ?></a>
				
				<?php if ( $user_id ): $username = get_userdata($user_id)->first_name ? get_userdata($user_id)->first_name : get_userdata($user_id)->display_name; ?>

					 <h4 class="welcome-user font-medium"><?php esc_html_e( 'Welcome, ' . $username , 'subteach' ); ?></h4>
					 
				<?php endif; ?>

			</div><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'subteach' ); ?></button>
				<?php

				if ( is_user_logged_in() ) {
					wp_nav_menu(
						array(
							'theme_location' => get_user_type_as_string() . '-menu',
							'menu_id'        => 'primary-menu',
						)
					);
				}
		
				?>
			</nav><!-- #site-navigation -->
		</div>
	</header><!-- #masthead -->
