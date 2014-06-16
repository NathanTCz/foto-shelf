<?php
$pics = $current_user->get_files();
$size = count($pics);
?>

<script>
function loadImage(counter) {
    var i = document.getElementById("img"+counter);
    if(counter==imgAddresses.length) { return; }
    i.onload = function(){
        loadImage(counter+1)
    }; 
    i.src = imgAddresses[counter];
} 
document.getElementById('shelf').onload=loadImage(0);
</script>

<div class="widget" id="shelf">
<?php
for ($i = 0; $i < $size; ++$i) {
$pic = $pics[$i];

?>
  <div class="preview_pic">
    <img id="<?php echo 'img'.$i;?>" src="<?php echo $pic->path;?>" />
  </div>
<?php
}
?>
</div>