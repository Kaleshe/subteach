<?php
function subteach_login_logo() { ?>
  <style type="text/css">
    #login h1 a, .login h1 a {
      background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/img/logo.png);
      height: 40px;
      width: 40px;
      background-size: contain;
      background-repeat: no-repeat;
      padding-bottom: 30px;
      color: white;
      font-family: Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif !important;
    }
    
    .login form .input, .login input[type=password], .login input[type=text] {
      font-size: 14px !important;
    }

    .acf-required {
      display: none !important;
    }

    #backtoblog {
      display: none;
    }

    .wp-core-ui .button-primary, .wp-core-ui .button-primary {
        background-color: #0076d6 !important;
        padding: .25rem 2rem !important;
    }
    
    #loginform, #registerform {
        border-radius: 10px;
        box-shadow:
    0 2.8px 2.2px rgba(0, 0, 0, 0.006),
    0 6.7px 5.3px rgba(0, 0, 0, 0.008),
    0 12.5px 10px rgba(0, 0, 0, 0.01),
    0 22.3px 17.9px rgba(0, 0, 0, 0.012),
    0 41.8px 33.4px rgba(0, 0, 0, 0.014),
    0 100px 80px rgba(0, 0, 0, 0.02)
    ;
    border: none;
    }

    #loginform .wp-submit {
        background-color: #0076d6;
    }
    
    .wp-core-ui p .button {
      font-weight: 700;
    }

    .login #nav a:hover {
      color: #0076d6 !important;
    }

    .login-action-register #login {
      max-width: 100% !important;
      width: 600px !important;
    }

    .login #nav {
      padding: 0 0 2rem !important;
    }

    .acf-tab-wrap.-top {
      margin-bottom: 1rem;
    }

    #registerform {
      display: flex;
      flex-direction: column;
    }
  </style>
<?php }
add_action( 'login_enqueue_scripts', 'subteach_login_logo' );

function subteach_login_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'subteach_login_url' );

/**
 * Add first and last name and price levels to registration form
 */
add_action( 'register_form', 'subteach_register_form' );
function subteach_register_form() {

  global $wpdb;

  $price_levels = $wpdb->get_results('SELECT teachers from price_levels');

  $first_name = ( ! empty( $_POST['first_name'] ) ) ? trim( $_POST['first_name'] ) : '';
  $last_name = ( ! empty( $_POST['last_name'] ) ) ? trim( $_POST['last_name'] ) : '';

    ?>
    <p>
        <label style="flex-grow: 1;" for="first_name"><?php _e( 'First Name', 'subteach' ) ?><br />
            <input type="text" name="first_name" id="first_name" class="input" value="<?php echo esc_attr( wp_unslash( $first_name ) ); ?>" size="25" /></label>

        <label style="margin-left: 1rem; flex-grow: 1;" for="last_name"><?php _e( 'Last Name', 'subteach' ) ?><br />
            <input type="text" name="last_name" id="last_name" class="input" value="<?php echo esc_attr( wp_unslash( $last_name ) ); ?>" size="25" /></label>
    </p>

    <p>
      <label for="price_levels" style="display: block">Teachers</label>
      <select name="pricel_levels" id="pricel_levels">
        <?php 
          foreach( $price_levels as $level ):
        ?>
        <option value=<?= $level->teachers; ?>><?= $level->teachers; ?></option>
    </p>

        <?php
          endforeach;
          ?>
      </select> 
<?php 
}

//2. Add validation. In this case, we make sure first_name is required.
add_filter( 'registration_errors', 'subteach_registration_errors', 10, 3 );
function subteach_registration_errors( $errors, $sanitized_user_login, $user_email ) {

    if ( empty( $_POST['first_name'] ) || ! empty( $_POST['first_name'] ) && trim( $_POST['first_name'] ) == '' ) {
        $errors->add( 'first_name_error', __( '<strong>ERROR</strong>: You must include a first name.', 'subteach' ) );
    }
    if ( empty( $_POST['last_name'] ) || ! empty( $_POST['last_name'] ) && trim( $_POST['last_name'] ) == '' ) {
        $errors->add( 'last_name_error', __( '<strong>ERROR</strong>: You must include a first name.', 'subteach' ) );
    }
    return $errors;
}

//3. Finally, save our extra registration user meta.
add_action( 'user_register', 'subteach_user_register' );
function subteach_user_register( $user_id ) {
    if ( ! empty( $_POST['first_name'] ) ) {
        update_user_meta( $user_id, 'first_name', trim( $_POST['first_name'] ) );
        update_user_meta( $user_id, 'last_name', trim( $_POST['last_name'] ) );
    }

    if ( ! empty( $_POST['price_levels'] ) ) {
      update_user_meta( $user_id, 'price_level', trim( $_POST['price_levels'] ) );
  }
}

 /**
 * Alter register text
 */
function register_text( $translated ) {
  $translated = str_ireplace('Register',  'Register School',  $translated);
  return $translated;
}

add_filter(  'gettext',  'register_text'  );
add_filter(  'ngettext',  'register_text'  );

