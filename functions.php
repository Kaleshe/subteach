<?php
$roots_includes = array(
  '/functions/logic.php',
  '/functions/theme.php',
  '/functions/school.php',
  '/functions/components/dataCard.php',
  '/functions/components/profileCard.php',
  '/functions/login.php',
  '/functions/db-ui-lib/db-ui-lib.php',
  'functions/ajax.php'
);

foreach($roots_includes as $file){
  if(!$filepath = locate_template($file)) {
    trigger_error("Error locating `$file` for inclusion!", E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);
?>