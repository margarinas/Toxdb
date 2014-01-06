<?php echo $this->Html->link("Redaguoti",array('action'=>'edit',$substance['Substance']['id']),array('class'=>'btn pull-right')); ?>
<h3>Produktas: <?php echo $substance['Substance']['name'] ?></h3>
<?php 
echo $this->Form->postLink('Susijusios konsultacijos <i class="icon-random icon-white"></i>',array(
			'controller'=>'events','action'=>'find','substance_id'=>$substance['Substance']['id']
			),
		array('class'=>'btn btn-info pull-right','target'=>'_blank','escape'=>false)
		);
 ?>
 <ul class="unstyled">
 	<li>
 		Generinis pavadinimas: <b><?php echo $substance['Substance']['generic_name'] ?></b>
 	</li>
 	<li>
 		Grupė: <b><?php echo $substance['PoisonGroup']['name'] ?></b>
 	</li>
 	<li>
 		Gamintojas: <b><?php echo $substance['Substance']['manufacturer'] ?></b>
 	</li>
 	<li>
 		Aprašymas: <?php echo $substance['Substance']['description'] ?>
 	</li>
 	<li class="substance_agent_list">
 		Sudedamosios medžiagos:
 		<ul>
 			<?php foreach ($substance['Agent'] as $key => $agent): ?>
 			<li><?php echo $this->Html->link($agent['name'],'/agents/view/'.$agent['id']); ?>
 				<ul>
 					<li><?php echo $agent['PoisonGroup']['name'] ?></li>
 					<li>CAS Nr.: <?php echo $agent['cas_number'] ?></li>
 					<li>Papildoma info: <?php echo $agent['description'] ?></li>
 				</ul>

 			</li>
 		<?php endforeach ?>
 	</ul>
 </li>
</ul>