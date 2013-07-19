<?php if (!$this->params['isAjax']): ?>
	<h3>Produktai</h3>
	<?php echo $this->element('substance/actions') ?>
<?php else: ?>

	<h4>Produktai</h4>
<?php endif; ?>
<?php 
if ($this->params['isAjax']) {
	$this->Paginator->options(array(
		'update' => '#substances',
		'evalScripts' => true,
		'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    	'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false))
		));
}

?>
<?php 
if(!$this->params['isAjax'])
	echo $this->Html->link("Pridėti naują produktą",array('controller'=>'substances', 'action'=>'add'),array('class'=>'btn btn-success margin-bottom')); 
?>
<table class="table" cellpadding="0" cellspacing="0">
	<tr>
		<th><?php echo $this->Paginator->sort('name','Pavadinimas');?></th>
		<th><?php echo $this->Paginator->sort('generic_name','Patikslintas pavadinimas');?></th>
		<?php if (!$this->params['isAjax']): ?>
			<th>Sudėtis</th>
		<?php endif; ?>
		<th><?php echo $this->Paginator->sort('PoisonGroup.name','Grupė');?></th>
		<th class="actions"><?php echo __('Actions');?></th>
		<th><i class="icon-check"></i></th>
	</tr>
	<?php
	foreach ($substances as $substance): ?>
	<tr class="substance_row <?php echo $substance['Substance']['default']?:'error' ?>">
		<td><?php echo $this->Html->link($substance['Substance']['name'], array('action' => 'view', $substance['Substance']['id'])); ?>&nbsp;</td>
		<td><?php echo $this->Html->link($substance['Substance']['generic_name'], array('action' => 'view', $substance['Substance']['id'])); ?>&nbsp;</td>
		<?php if (!$this->params['isAjax']): ?>
			<td>
				<?php 
				$agent_links = array();
				foreach ($substance['Agent'] as $key => $agent) {
					$agent_links[] = $this->Html->link($agent['name'], array('controller'=>'agents','action' => 'view', $agent['id']));
				}
				echo implode(', ', $agent_links);
				?>
				&nbsp;
			</td>
		<?php endif; ?>
		<td><?php echo $substance['PoisonGroup']['name'] ?></td>
	
		<td class="actions">
			<div class="btn-group">
				<?php 
				echo $this->Html->link('<i class="icon-zoom-in"></i>', array('action' => 'view', $substance['Substance']['id']),array('class'=>'btn btn-mini','escape'=>false));
				echo $this->Html->link('<i class="icon-pencil"></i>', array('action' => 'edit',$substance['Substance']['id']),array('class'=>'btn btn-mini','escape'=>false ));
				if($this->Session->read('Auth.User.Group.name')=='admin' || $this->Session->read('Auth.User.id')==$substance['Substance']['user_id'])
					echo $this->Form->postLink('<i class="icon-trash icon-white"></i>', array('action' => 'delete', $substance['Substance']['id']), array('class'=>'btn btn-mini btn-danger','escape'=>false), __('Ar tikrai norite ištrinti # %s?', $substance['Substance']['id']));

				echo $this->Form->postLink('<i class="icon-random icon-white"></i>',array(
					'controller'=>'events','action'=>'find','substance_id'=>$substance['Substance']['id']
					),
				array('class'=>'btn btn-info btn-mini','target'=>'_blank','escape'=>false)
				);

				?>
			</div>
		</td>

		<td>
			<?php 
			echo $this->OldForm->input('Substance.',array('value'=>$substance['Substance']['id'],'type'=>'checkbox','div'=>false,'label'=>false, 'class'=>'select_substance select-element'));
			echo $this->element('substance/attach_substance',array('substance'=>$substance['Substance'],'hide'=>true,'attachTo'=>!empty($this->request->query['attachTo'])?$this->request->query['attachTo']:false));
			foreach ($substance['Agent'] as $key => $agent) {
				echo $this->element('agent/attach_agent',array('agent'=>$agent,'units'=>$units,'hide'=>true,'attachTo'=>!empty($this->request->query['attachTo'])?$this->request->query['attachTo']:false));
			}
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
<?php endif; ?>
		<?php echo $this->Paginator->pagination(array('modulus'=>'6')); ?>
<?php //echo $this->Html->script(array('utils/tableRow')); ?>
<script type="text/javascript">
	require(['utils/tableRow'],function(row){
		row.init('.substance_row',function(){
				$('.attach_substance').removeClass('disabled');
			});
	});
	// $('.select_substance').change(function(event) {
	// 	$('.attach_substance').removeClass('disabled');
	// });

<?php if($this->params['isAjax']): ?>
	$('.substance_row a').click( function() {
		window.open( $(this).attr('href') );
		return false;
	});
	$('.modal-body .actions').hide();
	

		
<?php endif; ?>

	// $('.substance_row').click(function(event) {
	// 	var checkbox = $(this).find('.select_substance');
	// 	if(checkbox.prop('checked') && $(this).hasClass('success'))
	// 		checkbox.prop('checked',false);
	// 	else if(!$(this).hasClass('success'))
	// 		checkbox.prop('checked','checked');


	// 	$(this).toggleClass('success');
	// 	$('.attach_substance').removeClass('disabled');
	// });
	// $('.attach_substance').unbind();
	
	
</script>


