<?php $this->Html->scriptBlock("require(['main'], function (main) { require(['app/call.index']); });",array('inline'=>false)); ?>
<?php 


if (!$this->params['isAjax']):
	echo $this->Html->link("Atnaujinti",array('action'=>'getCalls'),array('class'=>'btn btn-info pull-right', 'id'=>'calls-get'));
?>
	<h3><?php echo __('Skambučių sąrašas');?></h3>
<?php endif; ?>
<?php echo $this->Html->link("Atnaujinti",array('action'=>'getCalls'),array('class'=>'btn btn-info pull-right hide', 'id'=>'calls-get')); ?>
<table class="table">
	<tr>
		<th><?php echo $this->Paginator->sort('number', 'Tel. nr.');?></th>
		<th><?php echo $this->Paginator->sort('duration', 'Trukmė');?></th>
		<th><?php echo $this->Paginator->sort('created', 'Data');?></th>
		<th><?php echo __('Įrašas');?></th>
		<th><?php echo $this->Paginator->sort('event_id', 'Protokolo nr.');?></th>
		<th class="actions"><?php echo __('Actions');?></th>
		<th><i class="icon-check"></i></th>
	</tr>
	<?php foreach ($calls as $call): ?>
	<tr class="call_row" id="<?php echo $call['Call']['id'] ?>">
		<td class="call_number"><?php echo h($call['Call']['number']); ?></td>
		<td><?php echo date('i:s',$call['Call']['duration']); ?>&nbsp;</td>
		<td><?php echo $this->Time->format('Y-m-d H:i',$call['Call']['created']); ?>&nbsp;</td>
		<td>
			<?php  echo $this->Html->media(array('calls/'.$call['Call']['file']),array('controls','preload'=>'none')); ?>
		</td>
		<td>
			<?php echo $this->Html->link($call['Event']['id'], array('controller' => 'events', 'action' => 'view', $call['Event']['id'])); ?>
		</td>
		<td class="actions">
			<div class="btn-group">
				<?php 
				if(!empty($call['Event']['id']))
					echo $this->Html->link('<i class="icon-zoom-in"></i>', array('controller'=>'events','action' => 'view',$call['Event']['id']),array('class'=>'btn btn-mini','escape'=>false ));
				else
					echo $this->Html->link('<i class="icon-edit"></i>', array(
						'controller'=>'events','action' => 'add','','?'=>array(
							'Event$created'=>$call['Call']['created'],
							'Event$phone'=>$call['Call']['number'],
							'Call$0$id'=>$call['Call']['id'],
							'Call$0$file'=>$call['Call']['file']
							)),
				array('class'=>'btn btn-mini','escape'=>false));

				if($this->Session->read('Auth.User.Group.name')=='admin' || $this->Session->read('Auth.User.id')==$call['Call']['user_id'])
					echo $this->Form->postLink('<i class="icon-trash icon-white"></i>', array('action' => 'delete', $call['Call']['id']), array('class'=>'btn btn-mini btn-danger','escape'=>false), __('Ar tikrai norite ištrinti # %s?', $call['Call']['id']));

				?>
			</div>
		</td>
		<td>
			<?php
			echo $this->OldForm->input('Call.',array('value'=>$call['Call']['id'],'type'=>'checkbox','div'=>false,'label'=>false, 'class'=>'select_call select-element','hiddenField'=>false));
			echo $this->element('call/attach_call',array('call'=>$call['Call'],'hide'=>true));
			?>
		</td>

	</tr>
<?php endforeach; ?>
</table>


	<p>
		<?php
		echo $this->Paginator->counter(array(
			'format' => __('Puslapis {:page} / {:pages}')
			));
			?>	
		</p>

	<?php echo $this->Paginator->pagination(); ?>

