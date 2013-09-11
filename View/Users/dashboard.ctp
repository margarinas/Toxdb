<?php $this->Html->scriptBlock("require(['main'], function (main) { require(['app/index']); });",array('inline'=>false)); ?>
<div class="row">
	<div class="span5">
		<h4><?php echo __('Naujienos') ?></h4>
		<hr>
		<?php 
		if(!empty($posts)):
			foreach ($posts as $post):
				?>
			<div class="post post-<?php echo $post['Post']['id'] ?>">
				<h4 class="post-title"><?php echo $post['Post']['title'] ?></h4>
				<div class="post-content">
					<?php echo $post['Post']['content'] ?>
				</div>
				<hr>
			</div>

			<?php
			endforeach;
			endif ?>
	</div>
	<div class="span5">
		<h4><?php echo __('Paskutinę savaitę pildyti protokolai') ?></h4>
		<hr>
		<div class="event-list"></div>
		<h4><?php echo __('Išsaugoti juodraščiai') ?></h4>
		<div class="draft-list"></div>
	</div>
</div>

</div>