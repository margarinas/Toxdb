<h3>Naujas antidotas</h3>
<?php echo $this->Form->create('Antidote', array('class' => 'form-horizontal'));?>
	<?php
	echo $this->Form->input('id');
	echo $this->Form->input('name',array('label'=>'Pavadinimas'));
	echo $this->Form->input('dose',array(
		'label'=>'Dozavimas',
		'class'=>'span2 decimal_input',
		'min' => 0,
		//'type'=>'text',
		'div'=>'controls-row margin-bottom',
		'after'=>$this->Form->input('unit_id',array('label'=>false,'div'=>false,'class'=>'span2'))
		)
	);
	echo $this->Form->input('description', array('label'=>'Papildoma informacija'));
	//echo $this->Form->input('Treatment');
	?>
	<?php echo $this->Form->submit(__('Patvirtinti'),array('class'=>'btn btn-primary'));?>
<?php echo $this->Form->end();?>