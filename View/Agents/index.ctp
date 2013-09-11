<?php $this->Html->scriptBlock("require(['main'], function (main) { require(['app/poison.index']); });",array('inline'=>false)); ?>
<?php 
//if (!$this->params['isAjax'])
	// echo $this->element('substance/actions');
?>

<?php 
// if(!$this->params['isAjax'])
// 	echo $this->Html->link("Pridėti naują medžiaga",array('controller'=>'agents', 'action'=>'add'),array('class'=>'btn btn-success margin-bottom')); 
?>
<table class="table" cellpadding="0" cellspacing="0">
	<tr class="pagination">
		<th><?php echo $this->Paginator->sort('name','Pavadinimas');?></th>
		<th><?php echo $this->Paginator->sort('PoisonGroup','Grupė');?></th>
		<?php if (!$this->params['isAjax']): ?>
			<th>Produktai</th>
		<?php endif ?>
		<th class="actions"><?php echo __('Actions');?></th>
		<th><i class="icon-check"></i></th>
		
	</tr>
	<?php
	foreach ($agents as $key => $agent): ?>
	<tr class="agent_row <?php echo $agent['Agent']['default']?'':'error'; ?>">
		<td><?php echo $this->Html->link($agent['Agent']['name'], array('action' => 'view', $agent['Agent']['id'])) ?>&nbsp;</td>
		<td><?php echo $agent['PoisonGroup']['name']; ?>&nbsp;</td>
		<?php if (!$this->params['isAjax']): ?>
			<td>
				<?php 
				$substance_links = array();
				foreach ($agent['Substance'] as $key => $substance) {
					$substance_links[] = $this->Html->link($substance['name'], array('controller'=>'substances','action' => 'view', $substance['id']));
				}

				echo implode(', ', $substance_links);
				//pr($agent['Agent']['poison_subgroup_id'])
				?>
				&nbsp;

			</td>
		<?php endif; ?>
		<td class="actions">
			<div class="btn-group">
				<?php 
				echo $this->Html->link('<i class="icon-zoom-in"></i>', array('action' => 'view', $agent['Agent']['id']),array('class'=>'btn btn-mini','escape'=>false));
				echo $this->Html->link('<i class="icon-pencil"></i>', array('action' => 'edit',$agent['Agent']['id']),array('class'=>'btn btn-mini','escape'=>false ));
				if($this->Session->read('Auth.User.Group.name')=='admin' || $this->Session->read('Auth.User.id')==$agent['Agent']['user_id'])
					echo $this->Form->postLink('<i class="icon-trash icon-white"></i>', array('action' => 'delete', $agent['Agent']['id']), array('class'=>'btn btn-mini btn-danger','escape'=>false), __('Ar tikrai norite ištrinti # %s?', $agent['Agent']['id']));
				
				echo $this->Form->postLink('<i class="icon-random icon-white"></i>',array(
					'controller'=>'events','action'=>'find','agent_id'=>$agent['Agent']['id']
					),
				array('class'=>'btn btn-info btn-mini','target'=>'_blank','escape'=>false)
				);

				?>
			</div>
		</td>
		<td>
			<?php 
			echo $this->OldForm->input('Agent.',array('value'=>$agent['Agent']['id'],'type'=>'checkbox','div'=>false,'label'=>false, 'class'=>'select_agent select-element'));
			echo $this->element('agent/attach_agent',array('agent'=>$agent['Agent'],'units'=>$units,'hide'=>true,'showMainGroup'=>true,'attachTo'=>!empty($this->request->query['attachTo'])?$this->request->query['attachTo']:false));
			?>
			
		</td>
	</tr>
<?php endforeach; ?>
</table>
<?php if (!$this->params['isAjax']): ?>
	

	<p>
	<?php
	echo $this->Paginator->counter(array(
		'format' => __('Puslapis {:page} / {:pages}')
		));
		?>	
	</p>
<?php endif ?>
<?php echo $this->Paginator->pagination(array('modulus'=>'6')); ?>

<script type="text/javascript">
	// require(['utils/tableRow'],function(row){
	// 	row.init('.agent_row',function(){
	// 		$('.attach_substance').removeClass('disabled');
	// 	});
	// });
	// $('.select_agent').change(function(event) {
	// 	$('.attach_substance').removeClass('disabled');
	// });

	<?php if($this->params['isAjax']): ?>
		// $('.agent_row a').click( function() {
		// 	window.open( $(this).attr('href') );
		// 	return false;
		// });
		// $('.modal-body .actions').hide();
	<?php endif; ?>

	// $('.agent_row').click(function(event) {
	// 	var checkbox = $(this).find('.select_agent');
	// 	if(checkbox.prop('checked') && $(this).hasClass('success'))
	// 		checkbox.prop('checked',false);
	// 	else if(!$(this).hasClass('success'))
	// 		checkbox.prop('checked','checked');
	// 	$(this).toggleClass('success');
	// 	$('.attach_substance').removeClass('disabled');
	// });


	// $('.attach_substance').click(function(event) {
	// 	if(!$(this).hasClass('disabled')) {
	// 		$('.agents').append($('.select_agent:checked').next().find('input:checkbox').prop('checked','checked').parents('.agent_fields'));

	// 		//console.log($('.select_agent').next().find('input:checkbox').parents('.agent_fields'));
	// 	}
	// });
	//console.log($('.select_agent').next().find('.controls input:checkbox').prop('checked','checked').parent());
</script>