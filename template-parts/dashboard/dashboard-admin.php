<?php
/**
 * Template part for displaying the admin dashboard
 *
 * Displays the total schools, total teachers, school/teacher ratio,
 * most recent school signup, most recent teacher signup
 * 
 * @package Subteach
 */

;?>

<div class="admin-dashboard">
    <div class="cards grid gap-space sm:cols-2 md:cols-3">
        <?php 
            echo dataCard( esc_html( 'Total Schools' ), get_total_schools() );
            echo dataCard( esc_html( 'Total Teachers' ), get_total_teachers() );
            echo dataCard( esc_html( 'Shool/Teacher Ratio' ), '2:1' ); 
            echo profileCard( 'Most Recent (School)', get_most_recent_user('school')->ID );
            echo profileCard( 'Most Recent (Teacher)', get_most_recent_user('teacher')->ID );
            echo dataCard( esc_html( 'Sign Up By Type' ), 'n/a' );
        ?>
    </div>
</div>