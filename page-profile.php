<?php
/**
 * The profile template file
 *
 * @package Subteach
 */

get_header();
?>

<main id="primary" class="site-main mt-space-2 px-space">
    <div class="container">

    <?php the_title('<h1 class="mb-space-half text-center text mb-space">', '</h1>'); ?>

        <?php
        
        if ( current_user_can( 'read' ) && is_active_user() ) {

            // Load different dashboard for admins and schools
            $form = !is_school() ? 'admin' : 'school';
            
            get_template_part( 'template-parts/profile/profile-form', $form );

        } else {

            get_template_part( 'template-parts/content/content-page-restricted' );

        }
        
        ?>

    </div>
</main><!-- #main -->

<?php
get_footer();
