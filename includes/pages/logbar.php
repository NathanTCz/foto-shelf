<div class="user_bar">
  <form name="logout" method="POST" action="/logout.php">
    <span><?php echo $current_user->get_email();?></span>
    <button type="submit" name="logout">
      <span class="icon-switch"> LOG OUT</span>
    </button>
  </form>
</div>
