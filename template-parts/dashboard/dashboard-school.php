<?php
/**
 * Template part for displaying the school dashboard
 *
 * Displays the number of placements, last search, last booked profile
 * with meta data, links to a generated search with autofilled data from last search
 * 
 * @package Subteach
 */

$school_id = 88;

;?>

<div class="school-dashboard">
    <div class="cards grid md:cols-3 gap-space">
        <?php
            echo dataCard( esc_html( 'Number of Placements' ), 0 );
        ?>
        <div class="card card-blue p-space text-center flex justify-center items-center">
            <div>
                <p class="text-lg font-bold">Last Search</p>
                <a href="" class="border-rounded">Duplicate</a>
            </div>
        </div>
        <?php
            echo profileCard( 'Last booked profile', 2 );
        ?>
    </div>
</div>