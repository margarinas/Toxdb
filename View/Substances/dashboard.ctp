<?php
// echo $this->element('substance/actions');

if ($this->params['isAjax'] && (!empty($this->data['Substance']) || !empty($this->data['Agent']))): ?>
	
	<?php echo $this->Session->flash();
	echo $this->Form->create();
	 ?>
	<p>Ar norite įterpti šią medžiagą į apsinuodijimo atvejį:</p>
	<p class="lead">
		<?php 
		if(!empty($this->data['Substance']))
			echo $this->data['Substance']['name'];
		elseif(!empty($this->data['Agent']))
			echo $this->data['Agent']['name'];
		?>
	</p>
	<?php if(!empty($this->data['Substance'])): ?>
		<p>ir joje esančias nuodingąsias medžiagas:</p>
	<?php endif ?>
	<div class="agents_results <?php if (!empty($this->data['Agent']) && empty($this->data['Substance'])): ?>hide<?php endif ?>">

		<?php 
		
		// echo $this->Form->input('Patient.0.Agent',array(
		// 	'label'=>false,
		// 	'multiple'=>'checkbox',

		// 	'options'=>$savedAgents,
		// 	'selected'=>array_keys($savedAgents)
		// 	));

		if (!empty($savedAgents)) {
			foreach ($savedAgents as $key => $agent) {
				echo $this->element('agent/attach_agent',array(
					'key'=>$key,
					'agent'=>$agent['Agent'],
					'units'=>$units,
					'hide'=>false,
					'hideDose'=>true,
					'selectAll'=>true,
					'showMainGroup'=>empty($this->data['Substance']),
					'attachTo'=>!empty($this->request->query['attachTo'])?$this->request->query['attachTo']:false));
			}
		}

		?>
	</div>

	<div class="substance_results hide">
	<?php 
		// if(!empty($this->data['Substance']))
		// 	echo $this->Form->input('Patient.0.Substance',array(
		// 		'label'=>false,
		// 		'multiple'=>'checkbox',
		// 		'div'=>false,
		// 		'hiddenField'=>false,
		// 		'options'=>array($this->data['Substance']['id']=>$this->data['Substance']['name']),
		// 		'selected'=>$this->data['Substance']['id']
		// 		));
	if(!empty($this->data['Substance']))
		echo $this->element('substance/attach_substance',array(
			'substance'=>$this->data['Substance'],
			'hide'=>false,
			'hideDose'=>true,
			'selectAll'=>true,
			'attachTo'=>!empty($this->request->query['attachTo'])?$this->request->query['attachTo']:false
			));
	?>
	</div>
	<?php echo $this->Form->end() ?>
	<script type="text/javascript">

		$('.attach_substance').removeClass('disabled');
		$('.attach_substance').unbind();
		$('.attach_substance').click(function(event) {
		if(!$(this).hasClass('disabled')) {
			$('.substances').append($('#add_substance .substance_results').html());
			$('#add_substance .agents_results input:checkbox').not(':checked').parents('.agent_fields').remove();
			//console.log($('#add_substance .agents_results').find('input:checkbox'));
			$('.agents').append($('#add_substance .agents_results').find('.agent_dose_field, .agent-main-group').show().end().html());
			$('.attach_substance').addClass('disabled');
			$('#add_substance').modal('hide');
		}
	});
	</script>
<?php endif; ?>
