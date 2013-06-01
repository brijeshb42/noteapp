<div class="span12">
<?php if (isset($view)): ?>
	
		<?php echo $this->render('note/'. $view,$this->mime,get_defined_vars()); ?>
	
<?php endif; ?>
<?php if (isset($list)): ?>
	
		<?php echo $this->render('note/list.html',$this->mime,get_defined_vars()); ?>
	
<?php endif; ?>
</div>