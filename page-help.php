<?php
/**
 * The help template file
 *
 * @package Subteach
 */

get_header();
?>

	<main id="primary" class="site-main">
        <div class="container">

          <?php the_title('<h1 class="mb-space-half text-center mb-space">', '</h1>'); ?>

            <?php
            
            if ( is_user_logged_in() && current_user_can( 'read' ) ) {

                if ( is_school() ) {
                  get_template_part( 'template-parts/faq' );
                }
                
            } else {

                esc_html_e( 'Sorry you do not have access to this page.', 'subteach' );

            }
            
            ?>

        </div>
	</main><!-- #main -->

<?php
get_footer();
