<?php
/**
 * The dashboard template file
 *
 * @package Subteach
 */

get_header();
?>

	<main id="primary" class="site-main">
        <div class="container">

            <?php
            
            if ( is_user_logged_in() && current_user_can( 'read' ) ) {

                // Load different dashboard for admins and schools
                $dashboard = !is_school() ? 'admin' : 'school';
                
                get_template_part( 'template-parts/dashboard/dashboard', $dashboard );

            } else {

                esc_html_e( 'Sorry you do not have access to this page.', 'subteach' );

            }
            
            ?>

        </div>
	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
