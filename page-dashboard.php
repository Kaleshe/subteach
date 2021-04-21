<?php
/**
 * The dashboard template file
 *
 * @package Subteach
 */

get_header();
?>

	<main id="primary" class="site-main">

        <?php
  
        if ( is_user_logged_in() && current_user_can( 'read' ) && is_active_user() ) {

            // Load different dashboard for admins and schools
            $dashboard = !is_school() ? 'admin' : 'school';
            
            get_template_part( 'template-parts/dashboard/dashboard', $dashboard );

        } else {

            get_template_part( 'template-parts/content/content-page-restricted' );

        }
        
        ?>

	</main><!-- #main -->

<?php
get_footer();
