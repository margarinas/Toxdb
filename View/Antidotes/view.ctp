<?php echo $this->Html->link("Redaguoti",array('action'=>'edit',$antidote['Antidote']['id']),array('class'=>'btn pull-right')); ?>
<h3>Priešnuodis: <?php echo $antidote['Antidote']['name'] ?></h3>


<ul class="unstyled">
 	<li>
 		Gydomoji dozė: <b><?php echo $antidote['Antidote']['dose'].' '.$antidote['Unit']['name'] ?></b>
 	</li>
 	<li>
 		<b>Aprašymas:</b> <?php echo $antidote['Antidote']['description'] ?>
 	</li>

 	<li class="antidote_agent_list">
 		<ul>
		 	<?php foreach ($antidote['AgentsAntidote'] as $key => $agent): ?>
		 	<li>
		 		Nuodingoji medžiaga <?php echo $key+1 ?>: <?php echo $agent['Agent']['name'] ?>
		 	</li>
	 	</ul>
 	<?php endforeach ?>

</li>
</ul>