<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);
set_include_path('/var/www/foto-shelf.com');

session_start();

require_once 'classes/Session.php';
require_once 'classes/Login.php';
require_once 'classes/User.php';
require_once 'classes/File.php';

// Set default landing page
if (!isset($_GET['page'])) {
  $_GET['page'] = "shelf";
}

// GLOBAL VARIABLES
$ERRORS = array();

$session = new Session;

if (!$session->logged_in()) {
  $session->redirect("/web/login");
  exit;
}
else if ($session->logged_in()) {
$current_user = new User($_SESSION['user']['email'], $_SESSION['user_id']);
}


$fn = (isset($_SERVER['HTTP_X_FILENAME']) ? $_SERVER['HTTP_X_FILENAME'] : false);

if ($fn) {

  $type = $_SERVER['HTTP_X_FILETYPE'];
  $size = $_SERVER['HTTP_X_FILESIZE'];

  // AJAX call
  file_put_contents(
    '/var/www/foto-shelf.com/media/' . $fn,
    file_get_contents('php://input')
  );

  $new_file = new File($fn,
                       $size,
                       $type,
                       $current_user->get_uid(),
                       '/media/' . $fn
  );

  $current_user->add_file($new_file);

  echo "$fn uploaded<br>";
  exit();
  
}
/*else {
  // form submit
  $files = $_FILES['files'];

  foreach ($files['error'] as $id => $err) {
    if ($err == UPLOAD_ERR_OK) {
      $fn = $files['name'][$id];

      move_uploaded_file(
        $files['tmp_name'][$id],
        '/var/www/foto-shelf.com/media/' . $fn
      );

      $new_file = new File($files['name'][$id],
                           $files['size'][$id],
                           $files['type'][$id],
                           $current_user->get_uid(),
                           '/media/' . $fn
      );

      $current_user->add_file($new_file);

      $session->redirect('/upload');
    }
  }
}*/
?>