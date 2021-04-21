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

    #backtoblog {
      display: none;
    }

    .wp-core-ui .button-primary, .wp-core-ui .button-primary {
        background-color: #0076d6 !important;
        padding: .25rem 2rem !important;
    }
    
    #loginform {
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
  </style>
<?php }
add_action( 'login_enqueue_scripts', 'subteach_login_logo' );

function subteach_login_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'subteach_login_url' );