<?php $this->Html->scriptBlock("require(['app/common'], function (main) { require(['app/event.index']); });",array('inline'=>false)); ?>

<?php 
if (!$this->params['isAjax'] && $this->action=='index'):
?>
<h4><?php echo __('Atvejai').' nuo '.date('Y-m-d',strtotime('-1 week')); ?></h4>
<?php endif; ?>

<?php 
if(empty($noSearchForm))
	echo $this->element('event/search');
 ?>
<?php 

if(!empty($events)):
echo $this->Form->create('Event',array('action'=>'multiplePrint','target'=>'_blank')); ?>
<table class="table">
	<tr class="pagination">
		<th><?php echo $this->Paginator->sort('id','Nr.');?></th>
		<th><?php echo $this->Paginator->sort('created','data');?></th>
		<th>Medžiaga</th>
		<th class="event-user-collum"><?php echo $this->Paginator->sort('user_id','Vartotojas');?></th>
		<th class="actions"><?php echo __('Veiksmai');?></th>
		<th class="event-select-collum"><a href="#" class="event-select-all"><i class="icon-check"></i></a></th>
	</tr>
	<?php
	foreach ($events as $event): ?>
	<tr class="event_row" id="<?php echo $event['Event']['id'] ?>">
		<td><?php echo $event['Event']['id']; ?>&nbsp;</td>
		<td><?php echo $this->Time->format('Y-m-d',$event['Event']['created']) ?>&nbsp;</td>
		
		<td>
			<?php 

			if(!empty($event['Patient'][0]['Substance'])) {
				$substance_links = array();
				foreach ($event['Patient'][0]['Substance'] as $substance) {
					$substance_links[] = $this->Html->link($substance['name'], array('controller' => 'substances', 'action' => 'view', $substance['id']));
				}
				echo implode(', ', $substance_links);

			} else	if(!empty($event['Patient'][0]['AgentsPatient'])) {
				$agent_links = array();
				foreach ($event['Patient'][0]['AgentsPatient'] as $agent) {
					$agent_links[] = $this->Html->link($agent['Agent']['name'], array('controller' => 'agents', 'action' => 'view', $agent['Agent']['id']));
				}
				echo implode(', ', $agent_links);
			} else if(!empty($event['Substance'])) {
				$event_substance_links = array();
				foreach ($event['Substance'] as $event_substance) {
					$event_substance_links[] = $this->Html->link($event_substance['name'], array('controller' => 'substances', 'action' => 'view', $event_substance['id']));
				}
				echo implode(', ', $event_substance_links);

			} else	if(!empty($event['Agent'])) {
				$event_agent_links = array();
				foreach ($event['Agent'] as $event_agent) {
					$event_agent_links[] = $this->Html->link($event_agent['name'], array('controller' => 'agents', 'action' => 'view', $event_agent['id']));
				}
				echo implode(', ', $event_agent_links);
			}
			?>

		</td>
		<td class="event-user-collum">
			<?php echo $this->Html->link($event['User']['name'], array('controller' => 'users', 'action' => 'view', $event['User']['id'])); ?>
		</td>
		<td class="actions">
			<div class="btn-group">
				<?php 
				echo $this->Html->link('<i class="icon-zoom-in"></i>', array('action' => 'view', $event['Event']['id']),array('class'=>'btn btn-mini','escape'=>false));
				
					if($this->Session->read('Auth.User.id')==$event['User']['id'] || $this->Session->read('Auth.User.Group.name')=='admin')
						echo $this->Html->link('<i class="icon-pencil"></i>', array('action' => 'edit',$event['Event']['id']),array('class'=>'btn btn-mini control-hide','escape'=>false ));
					if($this->Session->read('Auth.User.Group.name')=='admin')
						echo $this->Html->link('<i class="icon-trash icon-white"></i>', array('action' => 'delete', 'ext'=>'json','?'=>array('id'=>$event['Event']['id'])),
							array('class'=>'btn btn-mini btn-danger control-hide event-delete post-link','escape'=>false));
				
				?>
			</div>
		</td>
		<td class="event-select-collum">
		<?php	echo $this->OldForm->input('Event.',array('value'=>$event['Event']['id'],'type'=>'checkbox','div'=>false,'label'=>false, 'class'=>'select_event select-element','hiddenField'=>false)); ?>
		</td>
	</tr>
<?php endforeach;?>
</table>

<p class="paginator-summary">
<?php
echo $this->Paginator->counter(array(
	'format' => __('Puslapis {:page} / {:pages}')
	));
	?>
	<span class="pull-right"><?php echo $this->Paginator->counter(array('format' =>'Viso: {:count}')) ?></span>
</p>

<?php 
if(!$this->params['isAjax'])
	echo $this->Form->end(array('label'=>'Spausdinti','class'=>'btn pull-right','div'=>false)); 
?>
<?php echo $this->Paginator->pagination(); ?>

<?php endif; ?>
<script>
// require(['lib/bootstrap.min','utils/tableRow'],function(require,row) {
// 	row.init('.event_row')


// $('#poison_autocomplete').typeahead({
// 	minLength: 3,
// 	source: function (query, process) {

// 			return $.getJSON(
// 				baseUrl+'substances/find_poison/',
// 				{ term: query },
// 				function (data) {
// 					console.log(data);
// 					return process(data);
// 				});
// 		}

// 	});

// 	$('.clear-search').click(function() {
// 		$('#EventFindForm input').val('').prop('checked',false);;
// 		$('#EventFindForm select').val([0]);	
// 	});

// 	// $('.event_row').click(function(event) {
// 	// 	var checkbox = $(this).find('.select_event');
// 	// 	if(checkbox.prop('checked') && $(this).hasClass('success'))
// 	// 		checkbox.prop('checked',false);
// 	// 	else if(!$(this).hasClass('success'))
// 	// 		checkbox.prop('checked','checked');
// 	// 	$(this).toggleClass('success');

// 	// });
// 	var events_selected = false;
// 	$('.event-select-all').click(function(event) {
// 		if(events_selected) {
// 			$('.event_row').removeClass('success').find('.select_event').prop('checked','');
// 			events_selected = false;
// 		}
// 		else {
// 			$('.event_row').addClass('success').find('.select_event').prop('checked','checked');
// 			events_selected = true;
// 		}
// 		return false;
// 	});

// });
</script>