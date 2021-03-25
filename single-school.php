<?php
/**
 * The profile template file
 *
 * @package Subteach
 */

$school_id = get_the_ID();
$meta = get_post_meta( $school_id );
$email = $meta['email'][0];    
$telephone = $meta['school_telephone'][0];
$city = $meta['school_city'][0];
$postcode = $meta['school_postcode'][0];
$address = $meta['school_address'][0];
$description = get_the_content();
$signup_date = get_the_date();

$url = get_bloginfo('url');

get_header();
?>

	<main id="primary" class="site-main">
        <div class="container">

            <?php

            if ( is_user_logged_in() ): ?>

            <section class="user-profile grid md:cols-2">
                    
                    <div class="user-profile-info">
                        <div class="card text-sm">
                            <img class="user-profile-photo w-full" src="<?= esc_url( get_avatar_url($school_id, array('size' => 250) ) ); ?>">
                            
                            <div class="px-space py-space">
                                <p class="font-black text-md">Bio</p>
                                <p class="description | mb-space"><?= $description ? $description : esc_html('No Description'); ?></p>

                                <div class="grid cols-2 gap">
                                    <p class="email">Email</p> <p class="font-medium"><?= $email ? $email : esc_html('-'); ?></p>
                                    <p class="telephone">Telephone</p> <p class="font-medium"><?= $telephone ? $telephone : esc_html('-'); ?></p>
                                    <p class="city">City</p> <p class="font-medium"><?= $city ? $city : esc_html('-'); ?></p>
                                    <p class="postcode">Postcode</p> <p class="font-medium"><?= $postcode ? $postcode : esc_html('-'); ?></p>
                                    <p class="address">Address</p> <p class="font-medium"><?= $address ? $address : esc_html('-'); ?></p>
                                    <p class="signup-date">Sign Up Date</p> <p class="font-medium"><?= $signup_date; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <p class="font-black text-xl"><?php the_title(); ?></p>
                    </div>

            </section>

            <?php else: ?>

                <?php esc_html_e( 'Sorry you do not have access to this page.', 'subteach' ); ?>

            <?php endif; ?>

        </div>
	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
