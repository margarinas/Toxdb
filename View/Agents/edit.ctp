<div class="agents form">
<?php echo $this->Form->create('Agent');?>
	<fieldset>
		<legend><?php echo __('Edit Agent'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('cas_number');
		echo $this->Form->input('Antidote');
		echo $this->Form->input('Substance');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Agent.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Agent.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Agents'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Agent Attributes'), array('controller' => 'agent_attributes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Agent Attribute'), array('controller' => 'agent_attributes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Treatments'), array('controller' => 'treatments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Treatment'), array('controller' => 'treatments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Antidotes'), array('controller' => 'antidotes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Antidote'), array('controller' => 'antidotes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Substances'), array('controller' => 'substances', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Substance'), array('controller' => 'substances', 'action' => 'add')); ?> </li>
	</ul>
</div>
