<div class="call_fields <?php if($hide):?>hide <?php endif; ?>">
	<?php
	$key = isset($key)?$key:'%';

	echo $this->Form->hidden('Call.'.$key.'.event_id',array('value'=>empty($call['event_id'])?:$call['event_id']));
	echo $this->Form->hidden('Call.'.$key.'.id',array('class'=>'attached-call-id','value'=>$call['id']));
	echo $this->Form->hidden('Call.'.$key.'.file',array('value'=>$call['file']));
	if(!empty($call['file']))
		echo $this->Html->media(array('calls/'.$call['file']),array('controls','preload'=>'none'));

	?>
	<a class="remove-call btn pull-right" href="<?php echo $this->Html->url(array('controller'=>'calls', 'action'=>'removeEvent', $call['id'])); ?>"><i class="icon-trash"></i></a>
</div>