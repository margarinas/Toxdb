<div class="events form">
<?php echo $this->Form->create('Event');?>
	<fieldset>
		<legend><?php echo __('Edit Event'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('requester_name');
		echo $this->Form->input('address');
		echo $this->Form->input('city');
		echo $this->Form->input('feedback');
		echo $this->Form->input('extra');
		echo $this->Form->input('request_type');
		echo $this->Form->input('user_id');
		echo $this->Form->input('treatment_id');
		echo $this->Form->input('request_route_id');
		echo $this->Form->input('EventType');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Event.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Event.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Events'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Treatments'), array('controller' => 'treatments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Treatment'), array('controller' => 'treatments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Request Routes'), array('controller' => 'request_routes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Request Route'), array('controller' => 'request_routes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Patients'), array('controller' => 'patients', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Patient'), array('controller' => 'patients', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Substances'), array('controller' => 'substances', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Substance'), array('controller' => 'substances', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Event Types'), array('controller' => 'event_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event Type'), array('controller' => 'event_types', 'action' => 'add')); ?> </li>
	</ul>
</div>
