<div class="event_search_form row collapse <?php  echo $showSearch ?>">
	<?php
//pr($events);
	//pr($this->request->data);
	echo $this->Form->create('Event',array('url' => array_merge(array('action' => 'find'), $this->params['pass']),'id'=>'EventFindForm'));
	?>
	<?php echo $this->Form->hidden('current_url',array('value'=>$this->here,'name'=>false)); ?>
	<div class="span4">
		<?php
		echo $this->Form->input('id', array('label'=>'Protokolo nr.','type'=>'text'));
		echo $this->Form->input('created_from', array('label'=>'Data',
			'class'=>'datepicker input-small',
			'placeholder' => 'nuo',
			'after' => $this->Form->input('created_to', 
				array(
					'label'=>false,
					'div'=>false,
					'placeholder' => 'iki',
					'class'=>'datepicker input-small'
					))
			));
		
		echo $this->Form->input('id_from', array('label'=>'Protokolo numeriai',
			'class'=>'input-small',
			'placeholder' => 'nuo',
			'after' => $this->Form->input('id_to', 
				array(
					'label'=>false,
					'div'=>false,
					'placeholder' => 'iki',
					'class'=>'input-small'
					))
			));
		echo $this->Form->input('requester_name', array('label'=>'Kreipiasi','required'=>false,'class'=>'autocomplete'));
		echo $this->Form->input('medical_request', array('label'=>'Kreipiasi medikas?','default'=>false,'hiddenField'=>false));
		echo $this->Form->input('invalid_request', array('label'=>'Klaidingos konsultacijos', 'default'=>false,'hiddenField'=>false));
		echo $this->Form->input('feedback', array('label'=>'Užklausimas dėl apsinuodijimo baigties', 'default'=>false,'hiddenField'=>false));
		
		
		?>
	</div>
	<div class="span4">
		<?php
		echo $this->Form->input('patient_name', array('label'=>'Pacientas','id'=>'PatientName','class'=>'autocomplete')); 
		echo $this->Form->input('patient_age_group', array('label'=>'Amžiaus grupė','options'=>array('child'=>'Vaikas','adult'=>'Suaugęs'),'empty'=>'...Pasirinkite...'));
		echo $this->Form->input('username', array('label'=>'Vartotojas','id'=>'UserName','class'=>'autocomplete'));
		echo $this->Form->input('patient_request', array('label'=>'Kreipiasi pacientas?','default'=>false,'hiddenField'=>false));
		echo $this->Form->input('event_type',array('label'=>false,
                'options'=>$eventType,
                'multiple'=>'checkbox',
                'hiddenField'=>false
                ));
		
		?>
	</div>
	<div class="span4">
		<?php 
		echo $this->Form->input('poison', array('label'=>'Medžiaga','id'=>'poison_autocomplete'));
		echo $this->Form->input('poison_group', array('label'=>'Medžiagos grupė','options'=>$poison_group,'empty'=>'...Pasirinkite...'));
		echo $this->Form->input('antidotes', array('label'=>'Priešnuodis','id'=>'AntidoteName','class'=>'autocomplete'));		
		echo $this->Form->input('event_per_page', array('label'=>'Rezultatai puslapyje','options'=>array(20=>20,50=>50,100=>100,200=>200)));		
		?>
		<div class="row">
			<div class="span2">
				<button class="btn clear-search" type="button">Išvalyti paiešką</button>
			</div>
			
			<div class="span2">
				<?php 
					echo $this->Form->submit('Ieškoti', array('class' => 'btn btn-inverse'));
				?>
			</div>
		</div>

	</div>
	
	<?php echo $this->Form->end() ?>
</div>