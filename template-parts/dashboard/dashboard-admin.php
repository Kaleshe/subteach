<?php
/**
 * Template part for displaying the admin dashboard
 *
 * Displays the total schools, total teachers, school/teacher ratio,
 * most recent school signup, most recent teacher signup
 * 
 * @package Subteach
 */

?>

<div class="admin-dashboard mt-space-2 px-space">
    <div class="container">
        <div class="cards grid gap-space md:cols-2 lg:cols-3">
            <?php 
                echo dataCard( esc_html( 'Total Schools' ), get_total_schools() );
                echo dataCard( esc_html( 'Total Teachers' ), get_total_teachers() );
                echo dataCard( esc_html( 'School/Teacher Ratio' ), get_school_teacher_ratio(true) );
                echo profileCard( 'Most Recent (School)', get_most_recent_user_id('school'), 'school', 'recent-user' );
                echo profileCard( 'Most Recent (Teacher)', get_most_recent_user_id('teacher'), 'teacher', 'recent-user' );
                echo dataCard( esc_html( 'Sign Up By Type' ), get_total_paying_teachers() );
            ?>
        </div>

        <div class="search-table mt-space-2">
            <?= do_shortcode( '[wpdatatable id=7]' ); ?>
        </div>

    </div>
</div>