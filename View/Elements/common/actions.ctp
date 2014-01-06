	<h3><?php echo __('Actions'); ?></h3>
	<?php echo $this->Html->link(__('Naujas Atvejis'), array('controller'=>'events','action' => 'add'),array('class'=>'btn')); ?>
	<?php echo $this->Html->link(__('Atvejų sąrašas'), array('controller'=>'events','action' => 'index'),array('class'=>'btn')); ?>
	<?php echo $this->Html->link(__('Naujas produktas'), array('controller'=>'substances','action' => 'add'),array('class'=>'btn')); ?>
	<?php echo $this->Html->link(__('Produktų sąrašas'), array('controller'=>'substances','action' => 'index'),array('class'=>'btn')); ?>
	<?php echo $this->Html->link(__('Nuodingų medžiagų sąrašas'), array('controller'=>'agents','action' => 'index'),array('class'=>'btn')); ?>
	<?php echo $this->Html->link(__('Nauja nuodinga medžiaga'), array('controller'=>'agents','action' => 'add'),array('class'=>'btn')); ?>
	