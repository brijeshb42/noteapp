<div class="signup-class">
  <h2>Sign Up</h2>
  <form action="<?php echo $BASE; ?>/signup" id="signup" method="POST">
    <p>
    <label for="username">
      Username<br>
      <input type="text" name="username" id="username" class="input" <?php echo isset($POST['username'])?('value="'.$POST['username'].'"'):''; ?> size="20">
      <?php echo isset($error_username)?('<span class="error">'.$error_username.'</span>'):''; ?>
    </label>
    </p>
    <p>
    <label for="email">
      Email<br>
      <input type="text" name="email" id="email" class="input" <?php echo isset($POST['email'])?('value="'.$POST['email'].'"'):''; ?>>
      <?php echo isset($error_email)?('<span class="error">'.$error_email.'</span>'):''; ?>
    </label>
    </p>
    <p>
    <label for="password">
      Password<br>
      <input type="password" name="password" id="password" class="input" value="" size="20">
      <?php echo isset($error_password)?('<span class="error">'.$error_password.'</span>'):''; ?>
    </label>
    </p>
    <p>
    <label for="cpassword">
      Confirm Password<br>
      <input type="password" name="cpassword" id="cpassword" class="input" value="" size="20">
      <?php echo isset($error_password)?('<span class="error">'.$error_password.'</span>'):''; ?>
    </label>
    </p>
    <p class="submit">
    <input type="submit" name="submit" id="submit" class="btn btn-inverse" value="Sign Up">
  </p>
  </form>
</div>