<div class="new-note view-note">
	<small><i class="icon icon-calendar"></i>&nbsp;Posted&nbsp;On&nbsp;<b><?php echo date('M d, Y',strtotime($item['created'])); ?></b></small>
	<div class="note" id="note-<?php echo $item['id']; ?>">
		<?php echo Base::instance()->decode($item['item_text']); ?>
	</div>
</div>