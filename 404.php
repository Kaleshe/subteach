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

	<main id="primary" class="site-main">
		<div class="container">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( '404 Page Not Found', 'subteach' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( 'Page can\'t be found', 'subteach' ); ?></p>
					<a href="<?= get_home_url( ); ?>"><?php esc_html_e( 'Go back to Dashboard' ); ?></a>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->
		
		</div>
	</main><!-- #main -->

<?php
get_footer();
