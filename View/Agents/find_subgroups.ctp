<?php if (!empty($subgroups)): ?>
	<option value="">Pasirinkite...</option>
<?php endif ?>
<?php foreach ($subgroups as $key => $value): ?>
<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
<?php endforeach; ?>