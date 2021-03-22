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
$description = 'Description';
$signup_date = get_the_date();

$url = get_bloginfo('url');

get_header();
?>

	<main id="primary" class="site-main">
        <div class="container">

            <?php

            if ( is_user_logged_in() ): ?>

            <section class="user-profile">
                <div class="container gap-space md:gap-y-space-2">

                    <img class="user-profile-photo" src="<?= esc_url( get_avatar_url($school_id, array('size' => 250) ) ); ?>">
                    
                    <div class="user-profile-info">
                        <p class="font-bold text-lg"><?php the_title(); ?></p>
                        <p class="description | mb-space-half text-sm"><?= $description ? $description : esc_html('No Description'); ?></p>
                        <div class="grid cols-2 gap-x-space gap-y-space-half">
                            <p class="email | font-medium">Email</p> <p><?= $email ? $email : esc_html('-'); ?></p>
                            <p class="telephone | font-medium">Telephone</p> <p><?= $telephone ? $telephone : esc_html('-'); ?></p>
                            <p class="city | font-medium">City</p> <p><?= $city ? $city : esc_html('-'); ?></p>
                            <p class="postcode | font-medium">Postcode</p> <p><?= $postcode ? $postcode : esc_html('-'); ?></p>
                            <p class="address | font-medium">Address</p> <p><?= $address ? $address : esc_html('-'); ?></p>
                            <p class="signup-date | font-medium">Sign Up Date</p> <p><?= $signup_date; ?></p>
                        </div>
                        <?php
                            if (current_user_can('delete_posts')){
                                echo '<a class="mt-space" href="';
                                echo wp_nonce_url("$url/wp-admin/post.php?post=$school_id&action=delete", 'delete-post_' . $school_id);
                                echo '">Delete your listing</a>';
                            }
                            ;?>
                    </div>

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
