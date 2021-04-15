<?php
/**
 * Template part for displaying the school profile form
 *
 * @package Subteach
 */

global $wpdb;

$ID = 1;
$telephone = '';
$email = '';
$city = '';
$postcode = '';
$street_address = '';

if (isset($_POST['update'])) {

    // Prepare and bind
    $wpdb->update('meta', [
        'telephone' => $_POST['telephone'], "email" => $_POST['email'], "city" => $_POST['city'],
        "postcode" => $_POST['postcode'], "street_address" => $_POST['street_address']],
        ['id' => $ID],
        ['%s', '%s', '%s', '%s', '%s'],
        ['%d']);

}

if ($row = $wpdb->get_row($wpdb->prepare('SELECT telephone, email, city, postcode, street_address FROM meta WHERE id=%d', $ID), ARRAY_A)) {
    $telephone = $row['telephone'];
    $email = $row['email'];
    $city = $row['city'];
    $postcode = $row['postcode'];
    $street_address = $row['street_address'];
}; ?>

<div class="school-form | card px-space py-space w-max-theme mx-auto">
    <form class="grid gap-space-half" method="post" action="">
        <h2 class="mb-space-half">Contact Information</h2>
        <div>
            <label for="telephone">Telephone</label>
            <input type="tel" name="telephone" id="telephone" value="<?php esc_attr_e($telephone, 'subteach'); ?>">
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php esc_attr_e($email, 'subteach'); ?>">
        </div>

        <div>
            <label for="city">City</label>
            <input type="text" name="city" id="city" value="<?php esc_attr_e($city, 'subteach'); ?>">
        </div>

        <div>
            <label for="postcode">Postcode</label>
            <input type="text" name="postcode" id="postcode" value="<?php esc_attr_e($postcode, 'subteach'); ?>">
        </div>

        <div>
            <label for="street_address">Street Address</label>
            <input type="text" name="street_address" id="street_address"
                   value="<?php esc_attr_e($street_address, 'subteach'); ?>">
        </div>

        <input class="justify-self-start" type="submit" value="Update" name="update" id="update">

    </form>
</div>