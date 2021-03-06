<div class="row-fluid">
	<div class="span9">
		<?php echo $this->BootstrapForm->create('Call', array('class' => 'form-horizontal'));?>
			<fieldset>
				<legend><?php echo __('Add %s', __('Call')); ?></legend>
				<?php
				echo $this->BootstrapForm->input('number');
				echo $this->BootstrapForm->input('file');
				echo $this->BootstrapForm->input('duration');
				echo $this->BootstrapForm->input('event_id', array(
					'required' => 'required',
					'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
				);
				?>
				<?php echo $this->BootstrapForm->submit(__('Submit'));?>
			</fieldset>
		<?php echo $this->BootstrapForm->end();?>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Calls')), array('action' => 'index'));?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Events')), array('controller' => 'events', 'action' => 'index')); ?></li>
			<li><?php echo $this->Html->link(__('New %s', __('Event')), array('controller' => 'events', 'action' => 'add')); ?></li>
		</ul>
		</div>
	</div>
</div>