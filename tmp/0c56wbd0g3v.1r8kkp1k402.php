<div class="signup-class">
  <h2>Login</h2>
  <form action="<?php echo $BASE; ?>/login" id="signup" method="POST">
    <p>
      <label for="username">
      Username<br>
      <input type="text" name="username" id="username" class="input" <?php echo isset($POST['username'])?('value="'.$POST['username'].'"'):''; ?>>
      <?php echo isset($error_username)?('<span class="error">'.$error_username.'</span>'):''; ?>
      </label>
    </p>
    <p>
      <label for="password">
      Password<br>
      <input type="password" name="password" id="password" class="input" value="">
      <?php echo isset($error_password)?('<span class="error">'.$error_password.'</span>'):''; ?>
      </label>
    </p>
    <p class="forgetmenot">
     <label for="rememberme">
     <input name="rememberme" <?php echo isset($POST['rememberme'])?('checked'):''; ?> type="checkbox" id="rememberme" value="1">&nbsp;Remember&nbsp;Me</label>
    </p>
    <p class="submit">
      <input type="submit" name="submit" id="submit" class="btn btn-inverse" value="Log Me In">
    </p>
    <?php echo isset($SESSION['route'])?('<input name="route" type="hidden" value="'.$SESSION['route'].'">'):''; ?>
  </form>
</div>