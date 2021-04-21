<?php
/**
 * Template part for displaying restricted page content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Subteach
 */

$email = $wpdb->get_var( $wpdb->prepare( "SELECT email FROM meta WHERE ID = %d", 1 ) );

?>

<div class="text-center mt-space-2">
  <h1 class="text-lg mb-space-half"><?php esc_html_e( 'Sorry you do not have access to this page.', 'subteach' ); ?></h1>
  <p class="w-max-sm mx-auto"><?php esc_html_e( 'Please contact our administrators if you think there is a problem', 'subteach' ); ?> <a href="mailto:<?= $email; ?>"><?= $email; ?></a></p>
</div>