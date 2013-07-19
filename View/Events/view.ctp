<button type="button" class="btn btn-success noprint" onclick="window.print()">Atspausdinti</button>
<?php 
if($this->Session->read('Auth.User.id')==$event['Event']['user_id'] || $this->Session->read('Auth.User.Group.name')=='admin')
	echo $this->Html->link("Redaguoti",array('action'=>'edit',$event['Event']['id']),array('class'=>'btn pull-right noprint'));
 ?>
<?php 
if(empty($events))
	$events = array($event);
foreach ($events as $event): ?>
	

<div class="row print-event">
<h3>Konsultacijos protokolas nr. <?php echo $event['Event']['id'] ?></h3>	
<dl class="span6 collumn-print">
	<dt>1. Data</dt>
	<dd><?php echo $this->Time->format('Y-m-d H:i',$event['Event']['created']) ?></dd>

	<dt>2. Konsultantas</dt>
	<dd><?php echo $event['User']['name'] ?>&nbsp;</dd>

	<dt>3. Užklausimo būdas</dt>
	<dd>
		<ul>
			<?php 
			if(!empty($event['EventAttribute']['request_type'])) {
				foreach ($event['EventAttribute']['request_type'] as $request_type) {
					echo '<li>'.$request_type.'</li>';
				}
			}
			?>
		</ul>
		<?php
		//pr($event);

		if(!empty($event['Call'])) {
			foreach ($event['Call'] as $call) {
				echo $this->Html->media(array('calls/'.$call['file']),array('controls','preload'=>'none'));
			}
		}
				
		?>
	</dd>
	<dt>4. Atsakymo būdas</dt>
	<dd>
		<ul>
			<?php 
			if(!empty($event['EventAttribute']['answer_type'])) {
				foreach ($event['EventAttribute']['answer_type'] as $answer_type) {
					echo '<li>'.$answer_type.'</li>';
				}
			}
			?>
		</ul>
	</dd>

	<dt>5. Kreipimosi priežastis</dt>
	<dd>
		<em><?php echo $event['EventAttribute']['main']['type'] ?></em>
		<ul>
			<?php 
			if(!empty($event['EventAttribute']['type'])) {
				foreach ($event['EventAttribute']['type'] as $type) {
					if($type != $event['EventAttribute']['main']['type'])
						echo '<li>'.$type.'</li>';
				}
			}
			?>
		</ul>
		&nbsp;
	</dd>
	<dt>6. Kreipiasi</dt>
	<dd>
		<?php echo $event['Event']['requester_name'] ?>
		<ul>
			<li>Miestas: <?php echo $event['Event']['city'] ?></li>
			<li>Adresas: <?php echo $event['Event']['address'] ?></li>
			<li>Telefonas: <?php echo $event['Event']['phone'] ?></li>
			<li>Įstaiga: <?php echo $event['Event']['institution'] ?></li>
		</ul>
		&nbsp;
	</dd>
	<?php if (!empty($event['Patient'])): ?>
		

	<dt>7. Pacientas</dt>
	<dd>
		
		<ul>
			<?php if ($event['Patient'][0]['name']): ?>
				<li>Vardas: <?php echo $event['Patient'][0]['name'] ?></li>
			<?php endif ?>
			<li><?php echo $event['Patient'][0]['type'] ?>.</li>
			<?php if ($event['Patient'][0]['age_year']): ?>
				<li>Amžius: <?php echo $event['Patient'][0]['age_year'] ?></li>
			<?php endif ?>
			<?php if ($event['Patient'][0]['age_group']): ?>
				<li>Amžiaus grupė: <?php echo $event['Patient'][0]['age_group']=='adult'?'suaugęs':'vaikas' ?></li>
			<?php endif ?>
			<?php if ($event['Patient'][0]['height']): ?>
				<li>Ūgis: <?php echo $event['Patient'][0]['height'] ?> cm</li>
			<?php endif ?>
			<?php if ($event['Patient'][0]['weight']): ?>
				<li>Svoris: <?php echo $event['Patient'][0]['weight'] ?> kg</li>
			<?php endif ?>
			<?php if ($event['Patient'][0]['address']): ?>
				<li>Adresas: <?php echo $event['Patient'][0]['address'] ?></li>
			<?php endif ?>
			<?php if ($event['Patient'][0]['phone']): ?>
				<li>Telefonas: <?php echo $event['Patient'][0]['phone'] ?></li>
			<?php endif ?>
			<?php if ($event['Patient'][0]['pid']): ?>
				<li>Asmens kodas: <?php echo $event['Patient'][0]['pid'] ?></li>
			<?php endif ?>
			<?php if ($event['Patient'][0]['study_number']): ?>
				<li>Ligos istorijos numeris: <?php echo $event['Patient'][0]['study_number'] ?></li>
			<?php endif ?>
		</ul>
		<em>Gyvenimo anamnezė:</em>
		<ul>
			<?php 
			if(!empty($event['Patient'][0]['PatientAttributeValue'])) {
				foreach ($event['Patient'][0]['PatientAttributeValue'] as $attr) {
					echo '<li>'.$attr['PatientAttribute']['name'].'</li>';
				}
			}
			?>
			
		</ul>
	
		<?php echo $event['Patient'][0]['history'] ?>
		&nbsp;
	</dd>

	<dt>8. Nuodingosios medžiagos</dt>
	<dd>
		Pagrindinės medžiagos grupė: <?php echo $event['Patient'][0]['PoisonGroup']['name'] ?><br>
		<?php if (!empty($event['Patient'][0]['Substance'])): ?>	
			Produktai:
			<ul>
				<?php foreach ($event['Patient'][0]['Substance'] as $substance): ?>
					<li>
						<?php echo $substance['name'] ?>
						<ul>
							<li>Patikslintas pavadinimas: <?php echo $substance['generic_name'] ?></li>
							<li>Gamintojas: <?php echo $substance['manufacturer'] ?></li>
						</ul>
					</li>
				<?php endforeach ?>
			</ul>
		<?php endif ?>

		<?php if (!empty($event['Patient'][0]['AgentsPatient'])): ?>	
			Nuodingos medžiagos:
			<ul>
				<?php foreach ($event['Patient'][0]['AgentsPatient'] as $agent): ?>
					<li>
						<?php echo $agent['Agent']['name'] ?>
						<?php if (!empty($agent['dose'])): ?>
							<br>Kiekis: <?php echo $agent['dose'].' '.$agent['Unit']['name'] ?>
						<?php endif ?>
						
					</li>
				<?php endforeach ?>
			</ul>
		<?php endif ?>
		Ekpozicija: <?php echo $event['Patient'][0]['exposition'] ?><br>
		Apsinuodijimo laikas: <?php echo $event['Patient'][0]['time_of_exposure'] ?>
		&nbsp;
	</dd>

	<dt>9. Laboratorinis patvirtinimas</dt>
	<dd><?php echo $event['Patient'][0]['verified']?'Taip':'Ne' ?>&nbsp;</dd>

	<dt>10. Anamnezė, apsinuodijimo eiga</dt>
	<dd><?php echo $event['Patient'][0]['poisoning_info'] ?>&nbsp;</dd>

	<dt>11. Apsinuodijimo pobūdis</dt>
	<dd>
		<?php 
		if(!empty($event['Patient'][0]['PoisoningAttribute']['p_type']))
			echo array_shift($event['Patient'][0]['PoisoningAttribute']['p_type']).'<br>';

		if(!empty($event['Patient'][0]['PoisoningAttribute']['p_cause'])) {
			foreach ($event['Patient'][0]['PoisoningAttribute']['p_cause'] as $cause) {
				echo $cause.'<br>';
			}
		}
		
		 ?>
		 <?php if (!empty($event['Patient'][0]['PoisoningAttribute']['p_route'])): ?>
			 <em>Apsinuodijimo kelias:</em>
			 <?php 
			 foreach ($event['Patient'][0]['PoisoningAttribute']['p_route'] as $route) {
			 	echo $route;
			 }
			 ?>
		 <?php endif ?>
		&nbsp;
	</dd>
</dl>
<dl class="span6 collumn-print">
	<dt>12. Pradinis situacijos vetinimas</dt>
	<dd>
		<ul>
			<?php if (!empty($event['Patient'][0]['Evaluation']['symptoms'])): ?>
				<li>Simptomai: <?php echo array_shift($event['Patient'][0]['Evaluation']['symptoms']) ?></li>
			<?php endif ?>
			<?php if (!empty($event['Patient'][0]['Evaluation']['risk'])): ?>
				<li>Rizikos įvertinimas: <?php echo array_shift($event['Patient'][0]['Evaluation']['risk']) ?></li>
			<?php endif ?>
			<?php if (!empty($event['Patient'][0]['Evaluation']['grade'])): ?>
				<li>Apsinuodijimo sunkumo skalė: <?php echo array_shift($event['Patient'][0]['Evaluation']['grade']) ?></li>
			<?php endif ?>
			<?php if (!empty($event['Patient'][0]['Evaluation']['dose'])): ?>
				<li>Nuodingosios medžiagos kiekis: <?php echo array_shift($event['Patient'][0]['Evaluation']['dose']) ?></li>
			<?php endif ?>
		</ul>
		<?php echo $event['Patient'][0]['extra'] ?>
		&nbsp;
	</dd>

	<dt>13. Gydymas</dt>
	<dd>
		Iki kreipimosi:
		<ul>
			<?php foreach ($event['Patient'][0]['TreatmentBefore'] as $treatment): ?>
				<li><?php echo $treatment ?></li>
			<?php endforeach ?>
		</ul>

		Rekomenduota:
		<ul>
			<?php foreach ($event['Patient'][0]['TreatmentRecommended'] as $treatment): ?>
				<li><?php echo $treatment ?></li>
			<?php endforeach ?>
		</ul>
		
		
		&nbsp;
	</dd>

	<dt>14. Gydymo vieta</dt>
	<dd>
		Iki kreipimosi:
		<ul>
			<?php foreach ($event['Patient'][0]['TreatmentPlaceBefore'] as $treatment): ?>
				<li><?php echo $treatment ?></li>
			<?php endforeach ?>
		</ul>

		Rekomenduota:
		<ul>
			<?php foreach ($event['Patient'][0]['TreatmentPlaceRecommended'] as $treatment): ?>
				<li><?php echo $treatment ?></li>
			<?php endforeach ?>
		</ul>
		
		
		&nbsp;
	</dd>

	<dt>15. Apsinuodijimo vieta</dt>
	<dd><?php echo array_shift($event['Patient'][0]['PoisoningAttribute']['p_place']); ?>&nbsp;</dd>

	<dt>16. Gydymas priešnuodžiais ir dozės</dt>
	<dd>

		<ul>
			<?php foreach ($event['Patient'][0]['AntidotesPatient'] as $antidote): ?>
				<li>
					<?php echo $antidote['Antidote']['name'] ?>
					Dozė iki kreipimosi: <?php echo $antidote['dose_before'].' '.$antidote['Unit']['name'] ?>,
					rekomenduota: <?php echo $antidote['dose_recommended'].' '.$antidote['Unit']['name'] ?>
				</li>
			<?php endforeach ?>
		</ul>


		&nbsp;
	</dd>

	<dt>17. Rekomenduotas medikamentinis gydymas/ kita klinikinė informacija</dt>
	<dd><?php echo $event['Patient'][0]['additional_treatment'] ?>&nbsp;</dd>

	<dt>18. Užklausimas dėl apsinuodijimo baigties?</dt>
	<dd><?php echo $event['Event']['feedback']?'Taip':'Ne' ?>&nbsp;</dd>

	<dt>19. Galutinis apsinuodijimo sunkumo įvertinimas</dt>
	<dd><?php echo array_shift($event['Patient'][0]['Evaluation']['final_grade']) ?>&nbsp;</dd>

	<?php elseif(!empty($event['Substance']) || !empty($event['Agent'])): ?>
		<dt>7. Užklausimas dėl nuodingos medžiagos ar produkto:</dt>
			<dd>
				<?php if (!empty($event['Substance'])): ?>	
				Produktai:
				<ul>
					<?php foreach ($event['Substance'] as $substance): ?>
						<li>
							<?php echo $substance['name'] ?>
						</li>
					<?php endforeach ?>
				</ul>
			<?php endif ?>

			<?php if (!empty($event['Agent'])): ?>	
				Nuodingos medžiagos:
				<ul>
					<?php foreach ($event['Agent'] as $agent): ?>
						<li>
							<?php echo $agent['name'] ?>
						</li>
					<?php endforeach ?>
				</ul>
			<?php endif ?>
		</dd>
	<?php endif; ?>
	<dt>20. Pastabos</dt>
	<dd><?php echo $event['Event']['extra'] ?>&nbsp;</dd>

	<?php if (!empty($event['RelatedEvent'])): ?>
		<dt>21. Susijusių konsultacijų numeriai</dt>
		<dd>
			<?php echo implode(', ',$event['RelatedEvent']) ?>
		</dd>
	<?php endif ?>
	


</dl>
</div>
<div class="page-break"></div>
<?php endforeach ?>
<button type="button" class="btn btn-success noprint" onclick="window.print()">Atspausdinti</button>
