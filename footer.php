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

	<footer id="colophon" class="site-footer">
		<div class="container">
		</div>
		<div class="site-info">
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php if ( is_school() ): ?>
	<button data-micromodal-trigger="modal-1">New Event</button>
	<?php echo create_event(); ?>
<?php endif; ?>
 
<?php wp_footer(); ?>

</body>
</html>
