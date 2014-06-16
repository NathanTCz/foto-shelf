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

$pics = $current_user->get_files();
$pic = $pics[$_GET['id']];
?>

<div id="loader">
  <span id="cog1" class="icon-cog"></span>
  <span id="cog2" class="icon-cog"></span>
</div>
<img title="click to enlarge"src="<?php echo $pic->path;?>" onload="display(this);" onclick="scale(this)" style="visibility:hidden"/>
<span id="uploader">uploaded by: <?php $email = ($current_user->get_another_email($pic->owner)); echo $email[0]->email;?></span>
