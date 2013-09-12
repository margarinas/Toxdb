<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<?php echo $this->Html->link(__('Tox DB'), Configure::read('Route.default'),array('class'=>'brand'));?>
			<div class="nav-collapse collapse">
				<ul class="nav">
					<!-- <?php $url = $this->params->url;?>
					<?php if($this->Session->read('Auth.User')): ?>
						<li <?php if($url=='events/add') echo 'class="active"';?> ><?php echo $this->Html->link(__('Naujas Atvejis'), array('controller'=>'events','action' => 'add','plugin'=>false)); ?></li>
						<li <?php if($url=='events') echo 'class="active"';?>><?php echo $this->Html->link(__('Atvejai'), array('controller'=>'events','action' => 'index','plugin'=>false));?></li>
						
						<li <?php if($url=='substances' || $url=='substances/add') echo 'class="active"';?>><?php echo $this->Html->link(__('Produktai'), array('controller'=>'substances','action' => 'index','plugin'=>false)); ?></li>
						<li <?php if($url=='agents' || $url=='agents/add') echo 'class="active"';?>><?php echo $this->Html->link(__('Nuodingos medžiagos'), array('controller'=>'agents','action' => 'index','plugin'=>false)); ?></li>
					
						<li <?php if($url=='antidotes' || $url=='antidotes/add') echo 'class="active"';?>><?php echo $this->Html->link(__('Antidotai'), array('controller'=>'antidotes','action' => 'index','plugin'=>false)); ?></li>
						<li <?php if($url=='events/report') echo 'class="active"';?>><?php echo $this->Html->link(__('Ataskaita'), array('controller'=>'events','action' => 'report','plugin'=>false)); ?></li>
						<?php if($this->Session->read('Auth.User.Group.name')=='admin'): ?>
							<li <?php if($url=='calls') echo 'class="active"';?>><?php echo $this->Html->link(__('Skambučiai'), array('controller'=>'calls','action' => 'index','plugin'=>false)); ?></li>
						<?php endif ?>
					<?php endif ?> -->

					<?php
					if($this->Session->read('Auth.User'))
						echo $this->Menu->menuList(array(
							'/events/add' => array('title'=>__('Naujas Atvejis'),'exact'=>true),
							'/events' => array('title'=>__('Atvejai'),'exact'=>true),
							'/substances' => array('title'=>__('Produktai')),
							'/agents' => array('title'=>__('Nuodingos medžiagos')),
							'/antidotes' => array('title'=>__('Priešnuodžiai'))
							)
					);
					?>
					
				</ul>
				<?php if($this->Session->check('Auth.User.id')): ?>
				<ul class="nav pull-right">
					<li class="divider-vertical"></li>
					<li><?php echo $this->Html->link($this->Session->read('Auth.User.username'),array('controller'=>'Users', 'action'=>'dashboard')); ?></li>
					<li><?php echo $this->Html->link("Atsijungti",array('controller'=>'Users', 'action'=>'logout')); ?></li>
				</ul>
			<?php endif; ?>
		</div>
	</div>
</div>
</div>