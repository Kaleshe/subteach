<?php
/**
 * Template part for displaying the school dashboard
 *
 * Displays the number of placements, last search, last booked profile
 * with meta data, links to a generated search with autofilled data from last search
 * 
 * @package Subteach
 */

$school_id = get_the_ID();

;?>

<div class="school-dashboard">
    <div class="cards grid md:cols-3 gap-space">
        <?php
            echo dataCard( esc_html( 'Number of Placements' ), 10 );
        ?>
        <div class="card card-blue p-space text-center flex justify-center items-center">
            <div>
                <p class="text-lg font-bold">Last Search</p>
                <a href="">Duplicate</a>
            </div>
        </div>
        <div class="card p-space text-center">
            <img class="user-profile-photo" src="<?= esc_url( get_avatar_url($school_id, array('size' => 150) ) ); ?>">
            <p>Last Booked Profile</p>
        </div>
    </div>
</div>