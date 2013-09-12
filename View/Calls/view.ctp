<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('Call');?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($call['Call']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Number'); ?></dt>
			<dd>
				<?php echo h($call['Call']['number']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('File'); ?></dt>
			<dd>
				<?php echo h($call['Call']['file']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Duration'); ?></dt>
			<dd>
				<?php echo h($call['Call']['duration']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Created'); ?></dt>
			<dd>
				<?php echo h($call['Call']['created']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Event'); ?></dt>
			<dd>
				<?php echo $this->Html->link($call['Event']['id'], array('controller' => 'events', 'action' => 'view', $call['Event']['id'])); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('Edit %s', __('Call')), array('action' => 'edit', $call['Call']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Delete %s', __('Call')), array('action' => 'delete', $call['Call']['id']), null, __('Are you sure you want to delete # %s?', $call['Call']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Calls')), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Call')), array('action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Events')), array('controller' => 'events', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Event')), array('controller' => 'events', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>

