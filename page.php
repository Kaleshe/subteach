<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Subteach
 */

get_header();
?>

	<main id="primary" class="site-main mt-space-2">

		<?php if ( is_page('register') || current_user_can( 'read' ) && is_active_user() ) { ?>
			
		<div class="container">

			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content/content', 'page' );

			endwhile; // End of the loop.
			?>
			
		</div>

		<? } else {

					get_template_part( 'template-parts/content/content-page-restricted' );
		}
		?>
	</main><!-- #main -->

<?php
get_footer();
