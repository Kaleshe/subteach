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
?>

<!doctype html>
<html <?php language_attributes(); ?>>
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
			--secondary-colour: <?= $secondaryColour ? $secondaryColour : '#FFF'; ?>;
		}
	</style>

	<?php } ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<header id="masthead" class="site-header">
		<div class="container">
			<div class="site-branding">
				<?php
				the_custom_logo();
				
				if ( $user_id ): ?>

					 <h4 class="font-medium"><?php esc_html_e( 'Welcome, ' . get_userdata($user_id)->first_name , 'subteach' ); ?></h4>

				<?php endif; ?>

			</div><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'subteach' ); ?></button>
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
