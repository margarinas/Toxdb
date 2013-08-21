<?php $this->Html->scriptBlock("require(['main'], function (main) { require(['app/poison.add']); });",array('inline'=>false)); ?>
<div class="substance_create">
	<h3>Produktas</h3>
	<?php
	
	if($this->params['action'] == 'edit')
		echo $this->Form->postLink('Susijusios konsultacijos <i class="icon-random icon-white"></i>',array(
			'controller'=>'events','action'=>'find','substance_id'=>$this->data['Substance']['id']
			),
		array('class'=>'btn btn-info pull-right','target'=>'_blank','escape'=>false)
	);

	echo $this->Form->create('Substance');
	echo $this->Form->input('id');
	echo $this->Form->input('name',array('label'=>'Pavadinimas'));
	echo $this->Form->input('generic_name',array('label'=>'Patikslintas pavadinimas'));
	echo $this->Form->input('manufacturer',array('label'=>'Gamintojas/importuotojas','class'=>'autocomplete'));

	
	$substance_subgroups_options = array(
		'class'=>'poison_subgroup'
		);
	if(empty($substance_poison_subgroups))
		$substance_subgroups_options['class'] .= ' hide';

	if(!empty($substance_poison_subgroups))
		$substance_subgroups_options['empty'] = 'Pasirinkite...';

	echo $this->Form->input('Substance.poison_group_id',array(
		'label'=>'Medžiagos grupė',
		'options'=>$poison_groups,
		'empty'=>'Pasirinkite...',
		'class'=>'main_group',
		'after' => $this->Form->select('Substance.poison_subgroup_id',
			!empty($substance_poison_subgroups)?$substance_poison_subgroups:'',
			$substance_subgroups_options
			)
		)
	);

	echo $this->Form->input('description',array('label'=>'Papildoma informacija','class'=>'input-xxlarge'));
	echo $this->Form->input('noagents',array('label'=>'Produktas be aiškių sudedamųjų ar nuodingų medžiagų?','type'=>'checkbox'));
	if($this->Session->read('Auth.User.Group.name') == 'admin')
		echo $this->Form->input('default', array('label'=>'Rodyti pagrindiniame sąraše'));

	if(!empty($this->request->query)){
		foreach ($this->request->query as $key => $var) {
			echo $this->Form->hidden('query.'.$key, array('value'=>$var));
		}
	}
	?>

	<div id="substance-add-agents">
	<legend>Pagrindinės sudedamosios medžiagos</legend>

	
	<div class="row-fluid">

		<div class="span4">
			<div class="agents_attached">
				<?php
				if(!empty($this->data['Patient'])){
					echo $this->Form->input('Patient.0.Agent', array(
						'label'=>false,
						'div'=>false,
						'options'=> $attached_agents,
						'multiple'=>'checkbox',
						));
				}
				?> 
			</div>
			<hr>
		</div>
		<div class="span8">
			<div class="input-append">
				<input type="text" id="AgentName" class="autocomplete agent-search-input">
				<button class="btn search_agent" type="button">Ieškoti medžiagos</button>
				<button id="agent_to_substance" class="btn btn-primary hide" type="button">Susieti medžiagą su produktu</button>
			</div>
			
			<div class="agent_search_results" id="agents"></div>
			
		</div>
		
	</div>
	
	
	<?php $agents = !empty($this->data['Agent'])?$this->data['Agent']:array(1); ?>
	<div class="agents accordion <?php echo !empty($this->data['Substance']['noagents'])?'hide':''; ?>" id="agents_create">
		<?php foreach ($agents as $key => $value): ?>
		<div class="agent accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#agents_create" href="#agent<?php echo $key ?>agent">Medžiaga #<?php echo $key+1 ?></a>
				<a class="close agent_remove <?php if($key==0)echo 'hide'?>">×</a>
			</div>
			<div id="agent<?php echo $key ?>agent" class="accordion-body collapse <?php if(empty($attached_agents) || Hash::check(Hash::filter($this->data['Agent']),'{n}.name')): ?>in<?php endif; ?>">
				<div class="accordion-inner">
					<?php
					echo $this->Form->input('Agent.'.$key.'.name',array('label'=>'Sudedamoji (toksinė) medžiaga','required' => false));
					echo $this->Form->input('Agent.'.$key.'.id');
					echo $this->OldForm->input('Agent.'.$key.'.toxic_dose',array(
						'label'=>'Toksinė dozė',
						'class'=>'span2 decimal_input',
						'div'=>'controls-row',
						'after'=>$this->Form->input('Agent.'.$key.'.unit_id',array('label'=>false,'options'=>$units,'div'=>false,'class'=>'span1'))
						)
					);
					echo $this->Form->input('Agent.'.$key.'.cas_number',array('label'=>'CAS nr.'));
					//echo $this->Form->input('Agent.'.$key.'.group',array('label'=>'Medžiagos grupė'));

					$agent_subgroups_options = array(
						'class'=>'poison_subgroup'
						);

					if(empty($agent_poison_subgroups[$key]))
						$agent_subgroups_options['class'] .= ' hide';
					elseif (!empty($agent_poison_subgroups[$key]))
						$agent_subgroups_options['empty'] = 'Pasirinkite...';

					echo $this->Form->input('Agent.'.$key.'.poison_group_id',array(
						'label'=>'Medžiagos grupė',
						'options'=>$poison_groups,
						'empty'=>'Pasirinkite...',
						'class'=>'main_group',
						'after' => $this->Form->select('Agent.'.$key.'.poison_subgroup_id',
							!empty($agent_poison_subgroups[$key])?$agent_poison_subgroups[$key]:'',
							$agent_subgroups_options
							)
						)
					);
					echo $this->Form->input('Agent.'.$key.'.description',array('label'=>'Papildoma informacija','class'=>'input-xxlarge'));
					if($this->Session->read('Auth.User.Group.name') == 'admin')
						echo $this->Form->input('Agent.'.$key.'.default', array('label'=>'Rodyti pagrindiniame sąraše'));

					if(!empty($this->data['Substance']['id']))
						echo $this->Form->input('Agent.'.$key.'.Substance.id',array('value'=>$this->data['Substance']['id'],'class'=>'clone-with-value'));
					?>
				</div>

			</div>
		</div>
	<?php endforeach; ?>
</div>

	<button type="button" class="btn add_agent ">Pridėti nuodingą medžiagą +</button>
	</div>
	<div class="form-actions">

		
		<?php
			echo $this->Form->submit('Pateikti', array(
				'div' => false,
				'class' => 'btn btn-primary substance_form_submit',
				));
		?>

	</div>
	<?php echo $this->Form->end(); ?>
</div>