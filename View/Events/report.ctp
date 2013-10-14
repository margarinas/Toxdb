<?php $this->Html->scriptBlock("require(['app/common'], function (main) { require(['app/event/report'], function(report) {report.init()}); });",array('inline'=>false)); ?>
<?php
echo $this->Form->create('Event',array('action'=>'report'));
echo $this->Form->input('begin_date', array('label'=>'Laikotarpis',
	'placeholder'=>'pradžia',
	'class'=>'report_date',
	'after' => $this->Form->input('end_date', array('label'=>false,'div'=>false,'placeholder'=>'pabaiga','class'=>'report_date'))
	));
echo $this->Form->submit('Generuoti ataskaitą',array('class'=>'btn btn-primary'));
echo $this->Form->end();
// pr($report);
?>


<?php if (!empty($report)): ?>
	Laikotarpyje nuo <?php echo $this->data['Event']['begin_date'] ?> iki <?php echo $this->data['Event']['end_date'] ?> buvo užregistruota <?php echo $report['events'] ?> telefoninės konsultacijos: <br>

	<?php echo $report['type_request'] ?> užklausimų.<br>
	<?php echo $report['type_event'] ?> atvejų.<br>
	<?php echo $report['type_incident'] ?> incidentų.
	<hr>
	<?php echo $report['poison']['adult'] ?> konsultacijų dėl suaugusių asmenų apsinuodijimų:
	<ul>
		<?php foreach ($report['poison_groups']['adult'] as $name => $count): ?>
			<?php if (is_array($count)): ?>
				<li><?php echo $name.' ('.$count['main'].')' ?>
					<ul>
					<?php unset($count['main']);
						foreach ($count as $subgroup => $subcount): ?>
						<li><?php echo $subgroup.' ('.$subcount.')' ?>
					<?php endforeach ?>
					</ul>
				</li>
			<?php else: ?>
				<li><?php echo $name.' ('.$count.')'?></li>
			<?php endif ?>
		<?php endforeach ?>
	</ul>
	<hr>
	<?php echo $report['poison']['child'] ?> konsultacijų dėl vaikų apsinuodijimų:
	<ul>
		<?php foreach ($report['poison_groups']['child'] as $name => $count): ?>
			<?php if (is_array($count)): ?>
				<li><?php echo $name.' ('.$count['main'].')' ?>
					<ul>
					<?php unset($count['main']); 
						foreach ($count as $subgroup => $subcount): ?>
						<li><?php echo $subgroup.' ('.$subcount.')' ?>
					<?php endforeach ?>
					</ul>
				</li>
			<?php else: ?>
				<li><?php echo $name.' ('.$count.')'?></li>
			<?php endif ?>
		<?php endforeach ?>
	</ul>
	<?php echo $report['medical_requests'] ?> kartų konsultuoti ASP specialistai.<br>
	<?php echo $report['patients_requests'] ?> kartų kreipėsi patys pacientai.<br>
	<?php echo $report['events']-$report['patients_requests']-$report['medical_requests'] ?> kartų kreipėsi pacientų artimieji.<br>
	<?php echo $report['invalid_requests'] ?> klaidingi skambučiai.<br>
	<?php echo $report['not_poisoning'] ?> skambučiai dėl gydymo konsultacijos nesusijusios su apsinuodijimu.<br>
<?php endif ?>
