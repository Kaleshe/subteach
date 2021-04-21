<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Subteach
 */

get_header();
?>

	<main id="primary" class="site-main text-center mt-space-2">
		<div class="container">

			<section class="error-404 not-found">
				<header class="page-header mb-space-half">
					<h1 class="page-title"><?php esc_html_e( '404 Page Not Found', 'subteach' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( 'Sorry, the page you\'re looking for can\'t be found. ', 'subteach' ); ?></p>
					<?php if ( is_user_logged_in() ) { ?>
						<a href="<?= get_home_url( ); ?>"><?php esc_html_e( 'Go back to Dashboard' ); ?></a>
					<?php } ?>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->
		
		</div>
	</main><!-- #main -->

<?php
get_footer();
