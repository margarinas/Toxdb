<div class="row-fluid">
	<div class="span9">
		<?php echo $this->BootstrapForm->create('Antidote', array('class' => 'form-horizontal'));?>
			<fieldset>
				<legend><?php echo __('Edit %s', __('Antidote')); ?></legend>
				<?php
				echo $this->BootstrapForm->input('name');
				echo $this->BootstrapForm->input('dose');
				echo $this->BootstrapForm->input('unit_id', array(
					'required' => 'required',
					'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
				);
				echo $this->BootstrapForm->hidden('id');
				echo $this->BootstrapForm->input('Treatment');
				?>
				<?php echo $this->BootstrapForm->submit(__('Submit'));?>
			</fieldset>
		<?php echo $this->BootstrapForm->end();?>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Antidote.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Antidote.id'))); ?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Antidotes')), array('action' => 'index'));?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Antidote Attributes')), array('controller' => 'antidote_attributes', 'action' => 'index')); ?></li>
			<li><?php echo $this->Html->link(__('New %s', __('Antidote Attribute')), array('controller' => 'antidote_attributes', 'action' => 'add')); ?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Agents Antidotes')), array('controller' => 'agents_antidotes', 'action' => 'index')); ?></li>
			<li><?php echo $this->Html->link(__('New %s', __('Agents Antidote')), array('controller' => 'agents_antidotes', 'action' => 'add')); ?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Antidotes Patients')), array('controller' => 'antidotes_patients', 'action' => 'index')); ?></li>
			<li><?php echo $this->Html->link(__('New %s', __('Antidotes Patient')), array('controller' => 'antidotes_patients', 'action' => 'add')); ?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Treatments')), array('controller' => 'treatments', 'action' => 'index')); ?></li>
			<li><?php echo $this->Html->link(__('New %s', __('Treatment')), array('controller' => 'treatments', 'action' => 'add')); ?></li>
		</ul>
		</div>
	</div>
</div>