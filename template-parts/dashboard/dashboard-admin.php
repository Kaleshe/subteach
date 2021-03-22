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
            echo card( esc_html( 'Total Schools' ), get_total_schools() );
            echo card( esc_html( 'Total Teachers' ), get_total_teachers() );
        ?>
    </div>
</div>