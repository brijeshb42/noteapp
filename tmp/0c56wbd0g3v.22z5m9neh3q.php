<?php if ($loggedin): ?>
<?php else: ?>
<div class="jumbotron">
	<h1><?php echo $site; ?></h1>
        <a class="btn btn-large btn-success" href="<?php echo $BASE; ?>/signup">Sign Up Now</a>
</div>
<hr>

<?php endif; ?>
<div class="row-fluid note-app">
	<?php if ($loggedin): ?>
		
		<?php echo $this->render('note/show.html',$this->mime,get_defined_vars()); ?>
		
	<?php endif; ?>
</div>