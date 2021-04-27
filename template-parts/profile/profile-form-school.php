<?php
/**
 * Template part for displaying the school profile form
 *
 * @package Subteach
 */

$user_id = get_current_user_id();
$meta = get_user_meta( $user_id );
$data = get_userdata( $user_id )->data;
$email = $data->user_email;    
$telephone = $meta['telephone'][0];
$city = $meta['city'][0];
$postcode = $meta['postcode'][0];
$address = $meta['address'][0];
$primaryColour = $meta['primary_colour'][0];
$secondaryColour = $meta['secondary_colour'][0];

if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-user' ) {

    echo "<meta http-equiv='refresh' content='0'>";


    if ( !empty( $_POST['telephone']) )
        update_user_meta( $user_id, 'telephone', esc_attr( $_POST['telephone'] ) );

    if ( !empty( $_POST['email']) )
        wp_update_user( $user_id, 'user_email', esc_attr( $_POST['email'] ) );

    if ( !empty( $_POST['city']) )
        update_user_meta( $user_id, 'city', esc_attr( $_POST['city'] ) );

    if ( !empty( $_POST['postcode']) )
        update_user_meta( $user_id, 'postcode', esc_attr( $_POST['postcode'] ) );

    if ( !empty( $_POST['street_address']) )
        update_user_meta( $user_id, 'street_address', esc_attr( $_POST['street_address'] ) );

    if ( !empty( $_POST['primary_colour']) )
        update_user_meta( $user_id, 'primary_colour', esc_attr( $_POST['primary_colour'] ) );

    if ( !empty( $_POST['secondary_colour']) )
        update_user_meta( $user_id, 'secondary_colour', esc_attr( $_POST['secondary_colour'] ) );

}

?>

<div class="school-form | card px-space py-space w-max-theme mx-auto">
    <form class="grid gap-space-half" method="post" action="<?php the_permalink(); ?>">
        <h2><?php _e( 'School Information', 'subteach' ); ?></h2>
        <div>
            <label for="telephone"><?php _e( 'Telephone', 'subteach' ); ?></label>
            <input type="tel" name="telephone" id="telephone" value="<?= $telephone; ?>">
        </div>

        <div>
            <label for="email"><?php _e( 'Email', 'subteach' ); ?></label>
            <input type="email" name="email" id="email" value="<?= $email; ?>">
        </div>

        <div>
            <label for="city"><?php _e( 'City', 'subteach' ); ?></label>
            <input type="text" name="city" id="city" value="<?= $city; ?>">
        </div>

        <div>
            <label for="postcode"><?php _e( 'Postcode', 'subteach' ); ?></label>
            <input type="text" name="postcode" id="postcode" value="<?= $postcode; ?>">
        </div>

        <div>
            <label for="street_address"><?php _e( 'Street Address', 'subteach' ); ?></label>
            <input type="text" name="street_address" id="street_address"
                   value="<?= $address; ?>">
        </div>

        <h2 class="mt-space-half"><?php _e( 'Appearance', 'subteach' ); ?></h2>
        <div>
            <label for="primary_colour"><?php _e( 'Primary Colour', 'subteach' ); ?></label>
            <input type="color" name="primary_colour" id="primary_colour" value="<?php esc_attr_e($primaryColour, 'subteach'); ?>">
        </div>

        <div>
            <label for="secondary_color"><?php _e( 'Secondary Colour', 'subteach' ); ?></label>
            <input type="color" name="secondary_colour" id="secondary_colour" value="<?php esc_attr_e($secondaryColour, 'subteach'); ?>">
        </div>

        <input class="justify-self-start" name="updateuser" type="submit" id="updateuser" class="submit button" value="<?php _e('Update', 'profile'); ?>" />
        <?php wp_nonce_field( 'update-user' ) ?>
        <input name="action" type="hidden" id="action" value="update-user" />
    </form>
</div>