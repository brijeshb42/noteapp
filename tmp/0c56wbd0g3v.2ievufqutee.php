<div class="note-list">
	<?php foreach (($list?:array()) as $item): ?>
		<div class="list-item" id="item-<?php echo $item['id']; ?>">
			<p data-val=<?php echo $item['id']; ?>><?php echo Base::instance()->decode($item['item_text']); ?></p>
			<div class="btn-toolbar controls">
				<div class="btn-group">
					<button data-val=<?php echo $item['id']; ?> data-url="<?php echo $BASE; ?>/note/edit/<?php echo $item['id']; ?>" class="item-edit btn" title="Edit"><i class="icon icon-edit"></i></button>
					<button data-val=<?php echo $item['id']; ?> data-url="<?php echo $BASE; ?>/note/delete/<?php echo $item['id']; ?>" class="item-delete btn btn-warning" title="Delete"><i class="icon icon-remove"></i></button>
					<button data-val=<?php echo $item['id']; ?> data-url="<?php echo $BASE; ?>/note/changecolor/<?php echo $item['id']; ?>" class="item-move btn" title="Reorder"><i class="icon icon-move"></i></button>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>