<?php
/**
 * Template part for displaying the school dashboard
 *
 * Displays the number of placements, last search, last booked profile
 * with meta data, links to a generated search with autofilled data from last search
 * 
 * @package Subteach
 */

 
$user_id = get_current_user_id();
$coverImageID = get_user_meta( $user_id )['cover_image'][0];
$coverImage = $coverImageID ? wp_get_attachment_image_src( $coverImageID, 'full' ) : false;

?>

<?php if ($coverImage) { ?>
    <div class="cover-image" style="height: 35vmin; width: 100%; background: url(<?= $coverImage[0]; ?>); background-position-y: 60%; background-size: cover;">

    </div>
<?php } ?>
<div class="school-dashboard">
    <div class="school-dashboard-cards coloured-bg py-space-2 px-space">
        <div class="container">
            <div class="cards grid md:cols-3 gap-space">
                <?php
                    echo dataCard( esc_html( 'Number of Placements' ), 0 );
                ?>
                <div class="card p-space text-center flex justify-center items-center">
                    <div>
                        <p class="text-md font-bold"><?= esc_html( 'Last Search' ); ?></p>
                        <button class="mt-space-half" data-micromodal-trigger="event-modal" href=""><?= esc_html( 'Duplicate' ); ?></button>
                    </div>
                </div>
                <?php
                    echo profileCard( 'Last booked profile', 2 );
                ?>
            </div>
        </div>
    </div>

    <div class="px-space">
        <div class="container">
            <h2 class="my-space"><?= esc_html( 'Liked Profiles' ); ?></h2>
            <?php

            // Loop through liked users and assign their user id as the second argument
                echo profileCard( 'View Profile', 2, 'inline-flex flex-col' );
                echo profileCard( 'View Profile', 2, 'inline-flex flex-col' );
                echo profileCard( 'View Profile', 2, 'inline-flex flex-col' );
                echo profileCard( 'View Profile', 2, 'inline-flex flex-col' );
            ?>
        </div>
    </div>
</div>