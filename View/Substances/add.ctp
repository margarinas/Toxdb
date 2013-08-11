<div class="substance_create">
	<?php echo $this->element('substance/actions') ?>
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
	echo $this->Form->input('name',array('label'=>'Pavadinimas','class'=>'autocomplete'));
	echo $this->Form->input('generic_name',array('label'=>'Patikslintas pavadinimas','class'=>'autocomplete'));
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

					if(!empty($agent_poison_subgroups[$key]))
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

<script type="text/javascript">
<?php $this->start('add_script'); ?>
// function incrementInput(input, num) {
// 	optArray = new Array('id','name','for','href');
// 	console.log(num);
// 	for(i=0; i<optArray.length; i++) {
// 		if(input.attr(optArray[i])) {
// 			strArray = input.attr(optArray[i]).split('0');
// 			input.attr(optArray[i],strArray[0]+num+strArray.pop());
// 				//console.log(strArray.shift()+num+strArray);
// 			}


			
// 		}
// 		if(input.is('a')) {
// 			input.text(input.text().slice(0,-1)+(num+1));
// 		}
// 		if(input.is('select'))
// 			input.find('option:selected').prop("selected", false);
// 		//console.log(input.html());
		
// 		return input;
// 	}

	//require(["utils/incrementInput"]);
	$('.substance_create .add_agent').click(function(event) {
		var num = $('.substance_create .agent').length;
		$('.substance_create .accordion-body').collapse('hide');


		tinyMCE.execCommand('mceFocus', false, 'Agent0Description');                    
		tinyMCE.execCommand('mceRemoveEditor', false, 'Agent0Description');
	
		var clonedAgent = $('.substance_create .agent').first().clone();
		

		clonedAgent.find('input:not(.clone-with-value), textarea').val(null).end()
		.find('label, input, a.accordion-toggle, div.accordion-body, textarea, select')
		.incrementInput({num:num});
		
		$('.substance_create .agents').append(clonedAgent.find('.agent_remove').show().end());
		tinyMCE.execCommand('mceAddEditor', false, 'Agent0Description');
		tinyMCE.execCommand('mceAddEditor', false, 'Agent'+num+'Description');
		$('.substance_create .agent').last().find('.accordion-body').collapse('show');
		$('.substance_create .agent').last().find('.poison_subgroup').empty().hide();

		$('.substance_create .agent').last().find('.agent_remove').click(function(event) {
			$(this).parents('.agent').slideUp(200,function(){
				tinyMCE.execCommand('mceRemoveEditor', false, $(this).find('textarea').attr('id'));
				$(this).remove();
			});
			
		});
		$('.main_group').change(function(){
			subgroup = $(this).siblings('.poison_subgroup');
			$.post(baseUrl+'agents/findSubgroups',$(this).serialize(),function(data){
				if(data) {

					subgroup.html(data).show();
				} else {
					subgroup.empty().hide();
				}
			});
			//$('#AgentPoisonSubgroupId').load(baseUrl+'agents/findSubgroups','group_id='+$(this).val());
		});

	});

	$('.agent_remove').click(function(event) {
			$(this).parents('.agent').slideUp(200,function(){
				tinyMCE.execCommand('mceRemoveEditor', false, $(this).find('textarea').attr('id'));
				// $.post(baseUrl+'substances/deleteAssocAgents',{'id':$(this).data('assoc-id')});
				$(this).remove();
			});
			
	});
	
	$('.search_agent').click(function(event) {
		$('.agent_search_results').load(baseUrl+'agents/index/',{'term':$(this).prev().val()});
		$('#agent_to_substance').show();
		$('.substance_create .accordion-body').collapse('hide');
	});
	$('#agent_to_substance').click(function(event) {
		$('.agents_attached').append($('.select_agent:checked').next().find('input:checkbox').prop('checked','checked').end().find('.agent_dose_field, .agent-main-group').remove().end().show());
		$('.agent_search_results').empty();
		$(this).hide();
	});

	$('.substance_form_submit').click(function(event) {
		$('.agent_search_results').empty();
	});

	$('#SubstanceNoagents').change(function(event) {
		$('#agents_create').toggle();
	});
	//console.log(tinyMCE);
	//if (tinyMCE != undefined) {
		//tinyMCE.add()
	//}
	$('.main_group').change(function(){
		subgroup = $(this).siblings('.poison_subgroup');
		$.post(baseUrl+'agents/findSubgroups',$(this).serialize(),function(data){
			if(data) {

				subgroup.html(data).show();
			} else {
				subgroup.empty().hide();
			}
		});
		//$('#AgentPoisonSubgroupId').load(baseUrl+'agents/findSubgroups','group_id='+$(this).val());
	});
	<?php $this->end(); $this->Js->buffer($this->fetch('add_script')); ?>
	</script>
	<button type="button" class="btn add_agent ">Pridėti nuodingą medžiagą +</button>
	<div class="form-actions">

		<?php 
		if ($this->params['isAjax']):
			echo $this->Js->submit('Išsaugoti', array('update' => '#add_substance .modal-body','type' => 'json','class'=>'btn btn-primary substance_form_submit'));
		?>
			<script type="text/javascript">
			$(document).ready(function() {
				$('.modal-body textarea').each(function(event){                 
					tinyMCE.execCommand('mceRemoveEditor', false, this.id);
					tinyMCE.execCommand('mceAddEditor', false, this.id);
				})
			});
			
			$('.substance_form_submit').click(function(event) {
				$('.modal-body textarea').each(function(event){                 
					tinyMCE.execCommand('mceRemoveEditor', false, this.id);
					
				})
				$('.modal-body').scrollTop(0);
			});

			$('.agent-search-input').typeahead({
				minLength: 3,
				source: function (query, process) {


				input_id = $(this.$element).attr('id')
				.toDash()
				.split('-');

				input_id.shift();

				controller = input_id.shift()+'s'; //need to pluralize
				needle = input_id.join('_');

				return $.getJSON(
					baseUrl+controller+'/autocomplete/'+needle,
					{ term: query },
					function (data) {
						return process(data);
					});
				}

			});
		</script>
		<?php
		else:
			echo $this->Form->submit('Pateikti', array(
				'div' => false,
				'class' => 'btn btn-primary',
				));

    //echo $this->Html->link("Atšaukti",array('action'=>'index'),array('class'=>'btn pull-right'),'ar tikrai norite atšaukti?');

				?>
				<!-- <button class="btn">Cancel</button> -->



		<?php endif; ?>

	</div>
	<?php echo $this->Form->end(); ?>
</div>