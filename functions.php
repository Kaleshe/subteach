<?php
$roots_includes = array(
  '/functions/theme.php',
  '/functions/admin.php',
  '/functions/school.php',
  '/functions/users.php',
  '/functions/components/card.php'
);

foreach($roots_includes as $file){
  if(!$filepath = locate_template($file)) {
    trigger_error("Error locating `$file` for inclusion!", E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);
?>