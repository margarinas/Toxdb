<div class="substance-actions">
	<?php 
	echo $this->Form->create('Substance',array('action'=>'search','class'=>'form-inline','type'=>'get'));
	echo $this->Form->input('term',array('label'=>false,'class'=>'search_input'));
	?>
	<button type="button" id="search_db" class="btn btn-inverse pull-right">Ieškoti kitose DB</button>



	<?php

	// if ($this->params['isAjax']) {
		// if(!empty($this->request->query['attachTo']))
		// 	echo $this->Form->hidden('attachTo',array('value'=>$this->request->query['attachTo']));

	// echo $this->Js->submit('Ieškoti', array(
	// 	'update' => '#add_substance .modal-body', 
	// 	'class'=>'btn btn-primary',
	// 	'method'=>'get',
	// 	'evalScripts'=>true,
	// 	'async'=>true,
	// 	'url'=>'/substances/search'
	// 	));

		echo $this->Form->button('Ieškoti',array('class'=>'btn btn-primary','id'=>'substances-actions-search', 'type'=>'submit'));

		echo $this->Html->link('Įvesti naują produktą',
			array('controller'=>'substances','action'=>'add'), array('class'=>'btn margin-left','id'=>'add-new-substance'));
		
		echo $this->Html->link('Įvesti naują medžiagą',
			array('controller'=>'agents','action'=>'add'), array('class'=>'btn margin-left','id'=>'add-new-agent'));
		
	// if(empty($simple_form)) {
	// 	echo $this->Js->link('Įvesti naują produktą',
	// 		array('controller'=>'substances','action'=>'add','','?'=>array('attachTo'=>!empty($this->request->query['attachTo'])?$this->request->query['attachTo']:false)),
	// 		array('class'=>'btn margin-left','update'=>'#add_substance .modal-body'));

	// 	echo $this->Js->link('Įvesti naują medžiagą',
	// 		array('controller'=>'agents','action'=>'add','','?'=>array('attachTo'=>!empty($this->request->query['attachTo'])?$this->request->query['attachTo']:false)),
	// 		array('class'=>'btn margin-left','update'=>'#add_substance .modal-body'));
	// }


	// }	
	//echo $this->Js->link('Ieškoti', array('controller'=>'substances','action'=>'search'),array('update' => '.modal-body','class'=>'btn btn-primary','data'=>'$(".search_input").val()','type'=>'get'));
	// else
		// echo $this->Form->submit('Ieškoti');

	echo $this->Form->end();
	?>

	<form action="http://www.toxinz.com/Search" method="post" id="toxinz_form" target="_blank">
		<input id="toxinz_term" name="SearchText" type="hidden" value="">                              
	</form>
</div>