<?php if(count($err)): ?>
	<?php foreach($err as $idx => $error): ?>
		<div class="alert alert-danger" role="alert">
			<?= $error ?>
		</div>
	<?php endforeach ?>
<?php endif ?>