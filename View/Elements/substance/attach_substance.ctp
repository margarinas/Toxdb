<div class="formated_substances controls-row <?php if($hide) echo 'hide'; ?>">
	<div class="span3">
		<?php
		$attachTo = !empty($attachTo)?$attachTo:'Patient.0';

		echo $this->Form->input($attachTo.'.Substance',array(
			'label'=>false,
			'multiple'=>'checkbox',
			'div'=>false,
			'hiddenField'=>false,
			'options'=>array($substance['id']=>$substance['name']),
			'selected'=>!empty($selectAll)?$substance['id']:false
			));
				// $agents = Hash::combine($substance['Agent'],'{n}.id','{n}.name');
				// echo $this->Form->input($attachTo.'.Agent',array(
				// 	'label'=>false,
				// 	'multiple'=>'checkbox',
				// 	'div'=>'formated_agents hide',
				// 	'hiddenField'=>false,
				// 	'options'=>$agents
				// ));
			?>
	</div>
	<?php if ($attachTo=='Patient.0'): ?>
		<div class="span2">
			<?php
			echo $this->Form->input($attachTo.'.poison_group_id',array(
				'label'=>false,
				'div'=>false,
				'type'=>'radio',
				'hiddenField'=>false,
				// 'required' => true,
				'options'=>array(!empty($substance['poison_subgroup_id'])?$substance['poison_subgroup_id']:$substance['poison_group_id']=>'Pagrindinis')
				));
				?>
		</div>
	<?php endif ?>
</div>