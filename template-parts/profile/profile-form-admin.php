<?php
/**
 * Template part for displaying the admin profile form
 * 
 * @package Subteach
 */

include( get_template_directory() . '/config/mysqli_connect.php' );

$ID = 1;
$telephone = '';
$email = '';
$city = '';
$postcode = '';
$street_address = '';

if( isset($_POST['update']) ) {

    // Prepare and bind
    $stmt = $mysqli->prepare("UPDATE meta SET telephone=?, email=?, city=?, postcode=?, street_address=? WHERE id=?");
    $stmt->bind_param("dssssi", $_POST['telephone'], $_POST['email'], $_POST['city'], $_POST['postcode'], $_POST['street_address'], $ID);
    $stmt->execute();
    $stmt->close();

} else {

    $stmt = $mysqli->prepare("SELECT * FROM meta WHERE id=?");
    $stmt->bind_param("i", $ID);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows === 0) exit('No rows');
    while($row = $result->fetch_assoc()) {
    $telephone = $row['telephone'];
    $email = $row['email'];
    $city = $row['city'];
    $postcode = $row['postcode'];
    $street_address = $row['street_address'];
    $stmt->close();

    }
}

// hello@educampus.ch	+41 61 511 08 65	Streitgasse 20	4051	Schweiz	
// TODO:
// Set the value for the inputs as its current database value

;?>

<div class="admin-form">
    <form class="grid gap-y-space-half" method="post" action="<?php $_PHP_SELF; ?>">
        <h1>Contact Information</h1>
        <div>
            <label for="telephone">Telephone:</label>
            <input type="tel" name="telephone" id="telephone" value="<?php esc_attr_e( $telephone, 'subteach') ;?>">
        </div>

        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php esc_attr_e( $email, 'subteach') ;?>">
        </div>
        
        <div>
            <label for="city">City:</label>
            <input type="text" name="city" id="city" value="<?php esc_attr_e( $city, 'subteach') ;?>">
        </div>

        <div>
            <label for="postcode">Postcode:</label>
            <input type="text" name="postcode" id="postcode" value="<?php esc_attr_e( $postcode, 'subteach') ;?>">
        </div>
        
        <div>
            <label for="street_address">Street Address:</label>
            <input type="text" name="street_address" id="street_address" value="<?php esc_attr_e( $street_address, 'subteach') ;?>">
        </div>

        <!-- <h2 class="mt-space">Pricing</h2> -->

        <input type="submit" value="Update" name="update" id="update">

    </form>
</div>