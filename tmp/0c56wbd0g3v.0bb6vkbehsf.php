<div class="new-note">
	<form action="<?php echo $BASE; ?>/note/edit/<?php echo $item['id']; ?>" method="POST" id="note-form">
		<input autocomplete="off" type="text" name="newnote" id="newnote" value="<?php echo $item['item_text']; ?>" />
		<input type="hidden" name="user_id" value="<?php echo isset($SESSION['uid'])?($SESSION['uid']):($item['user_id']); ?>" />
		<input type="hidden" name="item_id" value="<?php echo $item['id']; ?>" />
		<p class="submit">
			<?php echo isset($error_note)?('<span class="error">'.$error_note.'</span>'):''; ?>
      		<button type="submit" value="submit" name="submit" id="submit" class="btn btn-inverse">
      			<i class="icon icon-white icon-plus-sign"></i>
      			Update Note
      		</button>
    	</p>
	</form>
</div>