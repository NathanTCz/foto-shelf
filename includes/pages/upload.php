<?php
/*if (!empty($_FILES)) {

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

      echo "<p>File $fn uploaded.</p>";
    }
  }

}*/

$fn = (isset($_SERVER['HTTP_X_FILENAME']) ? $_SERVER['HTTP_X_FILENAME'] : false);

if ($fn) {
?>
<script>
alert('it ran');
</script>
<?
  // AJAX call
  file_put_contents(
    '/var/www/foto-shelf.com/media/' . $fn,
    file_get_contents('php://input')
  );
  echo "$fn uploaded";
  exit();
  
}
?>

<script>
function choose_files() {
  document.getElementById('files').click();
}
</script>


<div class="widget" id="upload">
  <form id="upload" action="/ajax/php/upload.php" method="POST" enctype="multipart/form-data">
    <span class="form_box">
      <span class="icon-file4" onclick="choose_files()"> <u>Choose Files</u></span>
      <input id="files" type="file" name="files[]" multiple="multiple" style="visibility:hidden" />
    </span>
    <div id="dragndrop" class="dragndrop">
      <span id="placeholder">Or drag files here</span>
    </div>
    <button id="submit" class="upload_submit" type="submit" name="submit" style="visibility:hidden;">
      <span>UPLOAD</span>
      <span class="icon-arrow-up-right2"></span>
    </button>

    <progress id="uploadprogress" min="0" max="100" value="0">0</progress>

    <span id="errors" class="errors">
    <?php
    if (!empty($ERRORS)) {
      foreach ($ERRORS as $error) {
        echo $error;
      }
    }
    ?>
    </span>
  </form>
</div>

<script src="/js/dragndrop.js"></script>
