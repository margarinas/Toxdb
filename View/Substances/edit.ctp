<div class="substances form">
<?php echo $this->Form->create('Substance');?>
	<fieldset>
		<legend><?php echo __('Edit Substance'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('generic_name');
		echo $this->Form->input('manufacturer');
		echo $this->Form->input('cas_number');
		echo $this->Form->input('group');
		echo $this->Form->input('Agent');
		echo $this->Form->input('Patient');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Substance.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Substance.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Substances'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Agents'), array('controller' => 'agents', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Agent'), array('controller' => 'agents', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Patients'), array('controller' => 'patients', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Patient'), array('controller' => 'patients', 'action' => 'add')); ?> </li>
	</ul>
</div>
