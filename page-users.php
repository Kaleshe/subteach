<?php
/**
 * The users template file
 *
 * @package Subteach
 */

get_header();
?>

	<main id="primary" class="site-main">

        <?php
  
        if ( current_user_can( 'read' ) && is_active_user() ) {

            // Load different dashboard for admins and schools
            $dashboard = !is_school() ? 'admin' : 'school';
            
            get_template_part( 'template-parts/content/content-users' );

        } else {

            get_template_part( 'template-parts/content/content-page-restricted' );

        }
        
        ?>

	</main><!-- #main -->

<?php
get_footer();
