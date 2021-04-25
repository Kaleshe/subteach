<?php
$roots_includes = array(
  '/functions/logic.php',
  '/functions/theme.php',
  '/functions/school.php',
  '/functions/components/dataCard.php',
  '/functions/components/profileCard.php',
  '/functions/components/profileDataCard.php',
  '/functions/login.php',
  '/functions/db-ui-lib/db-ui-lib.php',
  '/functions/subteach-post.php',
  '/functions/ajax.php'
);

/**
 * Echoes print_r data within pre tags for easier viewing
 */
function dump($data) {
  echo '<pre>';
  print_r($data);
  echo '</pre>';
}

/**
 * Returns a response to the substeach API
 */
function subteach_api_access($endpoint, $sendingVars = []) {
	$sendingVarsString = '';
	if ( $sendingVars ) {
		$sendingVarsString = '&';
		foreach( $sendingVars as $var ) {
			$sendingVarsString .= $var;
		}
	}

	$base = 'https://substeach.ch/app/php/v1/';
	$response  = file_get_contents( $base . $endpoint . '.php?serverPass=3xmu5jyJppVmTKLX' . $sendingVarsString );
	
	return $response;
}

foreach($roots_includes as $file){
  if(!$filepath = locate_template($file)) {
    trigger_error("Error locating `$file` for inclusion!", E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);
?>