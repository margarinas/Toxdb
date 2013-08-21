<?php $this->Html->scriptBlock("require(['main'], function (main) { require(['app/poison.add']); });",array('inline'=>false)); ?>
<div class="agent_create">
	<h3>Medžiaga</h3>
	
	<?php
	
	if($this->params['action'] == 'edit')
		echo $this->Form->postLink('Susijusios konsultacijos <i class="icon-random icon-white"></i>',array(
			'controller'=>'events','action'=>'find','agent_id'=>$this->data['Agent']['id']
			),
		array('class'=>'btn btn-info pull-right','target'=>'_blank','escape'=>false)
	);

	echo $this->Form->create('Agent');
	echo $this->Form->input('name',array('label'=>'Sudedamoji (toksinė) medžiaga'));
	echo $this->Form->input('id');
	echo $this->OldForm->input('Agent.toxic_dose',array(
		'label'=>'Toksinė dozė',
		'class'=>'span2 decimal_input',
		'div'=>'controls-row',
		'after'=>$this->Form->input('unit_id',array('label'=>false,'div'=>false,'class'=>'span1'))
		)
	);
	echo $this->Form->input('cas_number',array('label'=>'CAS nr.'));
	//echo $this->Form->input('group',array('label'=>'Medžiagos grupė','class'=>'autocomplete'));


	$subgroups_options = array(
		'class'=>'poison_subgroup'
		);

	if(empty($poison_subgroups))
		$subgroups_options['class'] .= ' hide';
	elseif(!empty($poison_subgroups))
		$subgroups_options['empty'] = 'Pasirinkite...';

	echo $this->Form->input('poison_group_id',array(
		'label'=>'Medžiagos grupė',
		'options'=>$poison_groups,
		'empty'=>'Pasirinkite...',
		'class'=>'main_group',
		'after' => $this->Form->select('poison_subgroup_id',
			!empty($poison_subgroups)?$poison_subgroups:'',
			$subgroups_options
			
			)
		)
	);
	//echo $this->Form->select('poison_subgroup_id',array('label'=>false));

	echo $this->Form->input('description',array('label'=>'Papildoma informacija','class'=>'input-xxlarge'));
	if($this->Session->read('Auth.User.Group.name') == 'admin')
		echo $this->Form->input('default', array('label'=>'Rodyti pagrindiniame sąraše'));

	if(!empty($this->request->query)){
		foreach ($this->request->query as $key => $var) {
			echo $this->Form->hidden('query.'.$key, array('value'=>$var));
		}
	}
		
	?>
	<div class="form-actions">
		<?php 
			echo $this->Form->submit('Pateikti', array(
					'class' => 'btn btn-primary',
					));

		?>
	</div>
	<?php echo $this->Form->end();?>
</div>
