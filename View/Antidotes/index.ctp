<?php $this->Html->scriptBlock("require(['main'], function (main) { require(['app/poison.index']); });",array('inline'=>false)); ?>
<?php 
 //echo $this->element('substance/actions') ?>

<?php 
if(!$this->params['isAjax'])
	echo $this->Html->link("Pridėti naują priešnuodį",array('controller'=>'antidotes', 'action'=>'add'),array('class'=>'btn btn-success margin-bottom')); 
?>
<table class="table">
	<tr>
		<th><?php echo $this->Paginator->sort('name','Pavadinimas');?></th>
		<th class="actions"><?php echo __('Actions');?></th>
		<th><i class="icon-check"></i></th>
	</tr>
	<?php $this->Form->create(null); //note NO ECHO! ?>
	<?php foreach ($antidotes as $key => $antidote): ?>
	<tr class="antidote_row">
		<td><?php echo $this->Html->link($antidote['Antidote']['name'], array('action' => 'view', $antidote['Antidote']['id']));?>&nbsp;</td>
		<td class="actions">
			<div class="btn-group">
				<?php 
				echo $this->Html->link('<i class="icon-zoom-in"></i>', array('action' => 'view', $antidote['Antidote']['id']),array('class'=>'btn btn-mini','escape'=>false));
				echo $this->Html->link('<i class="icon-pencil"></i>', array('action' => 'edit',$antidote['Antidote']['id']),array('class'=>'btn btn-mini','escape'=>false ));
				if($this->Session->read('Auth.User.Group.name')=='admin')
					echo $this->Form->postLink('<i class="icon-trash icon-white"></i>', array('action' => 'delete', $antidote['Antidote']['id']), array('class'=>'btn btn-mini btn-danger','escape'=>false), __('Ar tikrai norite ištrinti # %s?', $antidote['Antidote']['id']));

				?>
			</div>
		</td>
		<td>
			
			<?php 
			echo $this->OldForm->input('Antidote.',array('value'=>$antidote['Antidote']['id'],'type'=>'checkbox','div'=>false,'label'=>false, 'class'=>'select_antidote select-element'));
			
			echo $this->element('antidote/attach_antidote',array('key'=>$key,'antidote'=>$antidote['Antidote'],'units'=>$units,'hide'=>true));
			?>
			
		</td>
	</tr>
	<?php $this->Form->end();  //note NO ECHO!?>
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
