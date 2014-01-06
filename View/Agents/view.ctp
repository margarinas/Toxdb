<?php echo $this->Html->link("Redaguoti",array('action'=>'edit',$agent['Agent']['id']),array('class'=>'btn pull-right')); ?>
<h3>Medžiaga: <?php echo $agent['Agent']['name'] ?></h3>
<?php 
echo $this->Form->postLink('Susijusios konsultacijos <i class="icon-random icon-white"></i>',array(
			'controller'=>'events','action'=>'find','agent_id'=>$agent['Agent']['id']
			),
		array('class'=>'btn btn-info pull-right','target'=>'_blank','escape'=>false)
		);


 ?>
<ul class="unstyled">
 	<li>
 		CAS numeris: <b><?php echo $agent['Agent']['cas_number'] ?></b>
 	</li>
 	<li>
 		Toksinė dozė: <b><?php echo $agent['Agent']['toxic_dose'].' '.$agent['Unit']['name'] ?></b>
 	</li>
 	<li>
 		Aprašymas: <?php echo $agent['Agent']['description']?>
 	</li>
 	<li>
 		Grupė: <b><?php echo $agent['PoisonGroup']['name'] ?></b>
 	</li>
 	<li class="agent_substance_list">
 		Įeina į šių produktų sudėtį:
 		<ul>
 			<?php foreach ($agent['Substance'] as $key => $substance): ?>
 			<li>
 				<?php echo $this->Html->link($substance['name'],array('controller'=>'substances', 'action'=>'view',$substance['id'])); ?>
 			</li>
 		<?php endforeach ?>
 	</ul>
 </li>
 <li class="agent_treatment_list">
 	<ul>
	 	<?php foreach ($agent['Treatment'] as $key => $treatment): ?>
	 	<li>
	 		Gydymas <?php echo $key+1 ?>: <b><?php echo $treatment['description'] ?></b>
	 	</li>
	 <?php endforeach ?>
 	</ul>
</li>
</ul>

