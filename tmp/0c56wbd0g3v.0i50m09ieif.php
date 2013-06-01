<div class="new-note">
	<form action="<?php echo $BASE; ?>/note/add" method="POST" id="note-form">
		<input autocomplete="off" type="text" name="newnote" id="newnote" />
		<input type="hidden" id="user_id" name="user_id" value="<?php echo isset($SESSION['uid'])?($SESSION['uid']):(''); ?>" />
		<p class="submit">
			<?php echo isset($error_note)?('<span class="error">'.$error_note.'</span>'):''; ?>
      		<button type="submit" value="submit" name="submit" id="submit" class="btn btn-inverse">
      			<i class="icon icon-white icon-plus-sign"></i>
      			Add Note
      		</button>
    	</p>
	</form>
</div>