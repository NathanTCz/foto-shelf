<?php
  if (isset($_GET['page'])) {
    if ($_GET['page'] === "shelf") {
      $shelfClassName = "active";
    }

    else if ($_GET['page'] === "upload") {
      $uploadClassName = "active";
    }

  }
  else {
    $_GET['page'] = "shelf";
    $shelfClassName = "active";
  }
?>

<div class="nav">
  <span class="title">FS</span>
  <div class="nav_menu">
    <ul>
      <a href="/shelf">
        <li class="<?php echo $shelfClassName;?>">
          <span class="nav_icon icon-screen"></span>
          <br>
          <span>Shelf</span>
          <div class="triangle"></div>
        </li>
      </a>
      <a href="/upload">
        <li class="<?php echo $uploadClassName;?>">
          <span class="nav_icon icon-cloud-upload"></span>
          <br>
          <span>Upload</span>
          <div class="triangle"></div>
        </li>
      </a>
    </ul>
  </div>
</div>
