<div class="antidote_fields row margin-bottom border-bottom<?php if($hide):?> hide<?php endif; ?>">

	<div class="span3">
		<?php



		echo $this->Form->input('Patient.0.Antidote',array(
			'label'=>false,
			'multiple'=>'checkbox',
			'hiddenField'=>false,
			'div'=>false,
			'options'=>array($antidote['id']=>$antidote['name']),
			'selected'=>!empty($selectAll)?$antidote['id']:false
			));
			?>
	</div>
		<?php
		$hideDose = !empty($hideDose)?' hide':'';
		echo $this->Form->input('Patient.0.AntidotesPatient.'.$key.'.id');

		echo $this->Form->hidden('Patient.0.AntidotesPatient.'.$key.'.antidote_id',array('value'=>$antidote['id']));
		?>
	<div class="span3 <?php echo $hideDose ?>">
		<?php
		echo $this->Form->input('Patient.0.AntidotesPatient.'.$key.'.dose_before',array(
			'label'=>'Iki kreipimosi',
			'class'=>'antidote_dose_field input-small decimal_input',
			'step'=>'0.001'
			));
		?>
	</div>
	<div class="span3 <?php echo $hideDose ?>">
		<?php 
		$dose_recommended_opt = array(
			'label'=>'Rekomenduota',
			'class'=>'antidote_dose_field input-small decimal_input',
			'step'=>'0.001'
		);
		if(empty($this->data['Patient'][0]['AntidotesPatient']))
			$dose_recommended_opt['value'] = $antidote['dose'];
		echo $this->Form->input('Patient.0.AntidotesPatient.'.$key.'.dose_recommended',$dose_recommended_opt);
		?>
	</div>

	<div class="span1 <?php echo $hideDose ?>">
	<?php 
	$unit_options = array(
		'label'=>false,
		'options'=>$units,
		'div'=>false,
		'class'=>'antidote_dose_field input-small'
		);
	if(empty($this->data['Patient'][0]['AntidotesPatient']))
		$unit_options['selected'] = $antidote['unit_id'];

	echo $this->Form->input('Patient.0.AntidotesPatient.'.$key.'.unit_id',$unit_options);
	?>
	</div>
		
</div>
