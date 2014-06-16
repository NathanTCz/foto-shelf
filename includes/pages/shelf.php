<?php
$pics = $current_user->get_files();
$size = count($pics);

if (isset($_GET['id']))
  $current = $_GET['id'];
else $current = 0;
echo $current;
?>

<script src="/ajax/js/display.js"></script>
<script>
  init(<?php echo $size?>,<?php echo $current?>)
</script>

<div class="widget arrow" id="arrow_left" onclick="show_curr('prev')">
  <span class="icon-arrow-left2"></span>
</div>

<div class="widget" id="picture">
</div>

<div class="widget arrow" id="arrow_right" onclick="show_curr('next')">
  <span class="icon-arrow-right2"></span>
</div>