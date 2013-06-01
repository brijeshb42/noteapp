<!DOCTYPE html>
<html lang="en">
	<head>
        <base href="<?php echo $SCHEME.'://'.$HOST.$BASE.'/'.$UI; ?>" />
		<meta charset="<?php echo $ENCODING; ?>" />
		<title><?php echo $site.' | '.$title; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<meta name="description" content="">
    	<meta name="author" content="<?php echo isset($SESSION['username'])?($SESSION['username']):('GUEST'); ?>">
        <meta name="generator" content="Customised Blog">
		<link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
		<link rel="stylesheet" href="css/theme.css" type="text/css" />
		<link rel="stylesheet" href="css/bootstrap-responsive.css" type="text/css" />
	</head>
	<body>
	  <div class="container-narrow">

      <?php echo $this->render('menu.html',$this->mime,get_defined_vars()); ?>
      <?php echo $this->render($inc,$this->mime,get_defined_vars()); ?>
      <?php echo $this->render('footer.html',$this->mime,get_defined_vars()); ?>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
    	baseUrl = <?php echo $BASE; ?>/;
    </script>
    <?php if ($loggedin): ?>
		
			<script type="text/javascript" src="js/loggedin.js"></script>
		
    <?php endif; ?>
    <?php echo isset($script)?('<script type="text/javascript" src="js/'.$script.'"></script>'):(''); ?>
	</body>
</html>