<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Subteach
 */

?>

	<footer id="colophon" class="site-footer mt-space-2 text-sm mb-space">
		<div class="container">
			<!-- <?php esc_html_e( 'Substeach - Streitgasse 20, 4051 Basel - +41 61 511 08 65 - hello@substeach.ch', 'subteach' ) ;?> -->
		</div>
		<div class="site-info">
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->
 
<?php 

	if ( is_school() && !is_page('dashboard') ) {
		include( get_template_directory() . '/event-modal.php' );
		echo '<div>';
		echo '<button data-micromodal-trigger="modal-1">New Event</button>';
		echo '</div>';
	}

	wp_footer(); 
	
?>

</body>
</html>
