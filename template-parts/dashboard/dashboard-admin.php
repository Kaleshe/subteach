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
    <div class="cards grid gap-space md:cols-3">
        <?php 
            echo dataCard( esc_html( 'Total Schools' ), get_total_schools() );
            echo dataCard( esc_html( 'Total Teachers' ), get_total_teachers() );
            echo dataCard( esc_html( 'Shool/Teacher Ratio' ), 'n/a' );
            echo dataCard( esc_html( 'Most Recent (School)' ), 'n/a' );
            echo dataCard( esc_html( 'Most Recent (Teacher)' ), 'n/a' );
            echo dataCard( esc_html( 'Sign Up By Type' ), 'n/a' );
        ?>
    </div>
</div>