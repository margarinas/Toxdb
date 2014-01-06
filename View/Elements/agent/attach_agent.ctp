<div class="agent_fields controls-row <?php if($hide):?>hide <?php endif; ?>">
	
	<div class="span3">
		<?php
		$attachTo = !empty($attachTo)?$attachTo:'Patient.0';

		echo $this->Form->input($attachTo.'.Agent',array(
			'label'=>false,
			'multiple'=>'checkbox',
			'hiddenField'=>false,
			'div'=>false,
			'options'=>array($agent['id']=>$agent['name']),
			'selected'=>!empty($selectAll)?$agent['id']:false
			));
			?>
	</div>

	<?php
	if ($attachTo=='Patient.0'):
	//echo $this->Form->hidden('Patient.0.Agent.'.$key.'.toxic_dose', array('value'=>$agent['toxic_dose'],'class'=>'agent_toxic_dose'));
	//echo $this->Form->hidden('Patient.0.Agent.'.$key.'.unit_id', array('value'=>$agent['toxic_dose'],'class'=>'agent_toxic_dose'));
		$key = isset($key)?$key:'%';
		
		$hideDose = !empty($hideDose)?' hide':'';

			echo $this->Form->input($attachTo.'.AgentsPatient.'.$key.'.id');
			echo $this->Form->input($attachTo.'.AgentsPatient.'.$key.'.dose', array('label'=>false,'class'=>'span2 agent_dose_field decimal_input'.$hideDose,'div'=>false,'placeholder'=>'Dozė','type'=>'number','step'=>'0.001'));
			echo $this->Form->hidden($attachTo.'.AgentsPatient.'.$key.'.agent_id',array('value'=>$agent['id']));
			echo $this->Form->input($attachTo.'.AgentsPatient.'.$key.'.unit_id',array('label'=>false,'options'=>$units,'div'=>false,'class'=>'span1 agent_dose_field'.$hideDose));

		?>
		<?php if (!empty($showMainGroup)): ?>
			<div class="span2 agent-main-group<?php echo $hideDose ?>">
				<?php echo $this->Form->input($attachTo.'.poison_group_id',array(
				'label'=>false,
				'div'=>false,
				'hiddenField'=>false,
				'type'=>'radio',
				'options'=>array(!empty($agent['poison_subgroup_id'])?$agent['poison_subgroup_id']:$agent['poison_group_id']=>'Pagrindinis')
				)); ?>
			</div>
		<?php endif ?>
	<?php endif; ?>
</div>