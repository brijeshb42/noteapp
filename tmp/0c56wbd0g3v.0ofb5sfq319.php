<div class="row-fluid details">
  <div class="span6">
  <h4>Update Email</h4>
  <form action="<?php echo $BASE; ?>/account" style="margin-bottom:25px;" class="details-form" method="POST">
    <input type="text" name="email" />
    <button type="submit" name="submit" value="submit" class="btn btn-inverse">
      <i class="icon icon-white icon-pencil"></i>
      Update Email
    </button>
  </form>
  </div>
  <div class="span6">
  <h4>Change Password</h4>
  <form action="<?php echo $BASE; ?>/account" class="details-form" method="POST">
    <label for="oldpass">
      Old Password<br>
      <input type="text" name="oldpass" id="oldpass" class="input"/>
      <?php echo isset($error_username)?('<span class="error">'.$error_username.'</span>'):''; ?>
      </label>
      <label for="newpass">
      New Password<br>
      <input type="text" name="newpass" id="newpass" class="input"/>
      <?php echo isset($error_username)?('<span class="error">'.$error_username.'</span>'):''; ?>
      </label>
      <label for="cnewpass">
      Confirm Password<br>
      <input type="text" name="cnewpass" id="cnewpass" class="input"/>
      <?php echo isset($error_username)?('<span class="error">'.$error_username.'</span>'):''; ?>
      </label>
    <button type="submit" name="submit" value="submit" class="btn btn-inverse">
      <i class="icon icon-white icon-pencil"></i>
      Update Password
    </button>
  </form>
  </div>
</div>