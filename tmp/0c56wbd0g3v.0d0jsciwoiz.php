<div class="masthead">
<ul id="main-menu" class="nav nav-pills pull-right">
  <?php if ($URI==$BASE.'/'): ?>
      
      <li class="active"><a href="<?php echo $BASE; ?>/"><i class="icon icon-home"></i>&nbsp;Home</a></li>
      
      <?php else: ?>
      <li><a href="<?php echo $BASE; ?>/"><i class="icon icon-home"></i>&nbsp;Home</a></li>
      
  <?php endif; ?>
  <?php if ($loggedin): ?>
  
    <?php if ($URI==$BASE.'/account'): ?>
      
      <li class="active"><a href="<?php echo $BASE; ?>/account"><i class="icon icon-user"></i>&nbsp;<?php echo isset($SESSION['username'])?($SESSION['username']):(''); ?></a></a></li>
      
      <?php else: ?>
      <li><a href="<?php echo $BASE; ?>/account"><i class="icon icon-user"></i>&nbsp;<?php echo isset($SESSION['username'])?($SESSION['username']):(''); ?></a></li>
      
    <?php endif; ?>
    <li><a href="<?php echo $BASE; ?>/logout">Logout</a></li>
  
  <?php else: ?>
    <?php if ($URI==$BASE.'/login'): ?>
      
      <li class="active"><a href="<?php echo $BASE; ?>/login">Login</a></li>
      
      <?php else: ?>
      <li><a href="<?php echo $BASE; ?>/login">Login</a></li>
      
    <?php endif; ?>
    <?php if ($URI==$BASE.'/signup'): ?>
      
      <li class="active"><a href="<?php echo $BASE; ?>/signup">Sign Up</a></li>
      
      <?php else: ?>
      <li><a href="<?php echo $BASE; ?>/signup">Sign Up</a></li>
      
    <?php endif; ?>
    <?php endif; ?>
  
  
</ul>
<h3 class="muted"><a href="<?php echo $BASE; ?>/"><?php echo $site; ?></a></h3>
</div>
<hr>
<?php echo isset($SESSION['message'])?('<div id="session-message" class="alert alert-'.$SESSION['messagetype'].'">'.$SESSION['message'].'<button type="button" class="close" data-dismiss="alert">×</button></div>'):''; ?>