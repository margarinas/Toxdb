<div class="row">
	<div class="span5">
		<h4><?php echo __('Naujienos') ?></h4>
		<hr>
		<?php 
		if(!empty($posts)):
			foreach ($posts as $post):
				?>
			<div class="post post-<?php echo $post['Post']['id'] ?>">
				<h4 class="post-title"><?php echo $post['Post']['title'] ?></h4>
				<div class="post-content">
					<?php echo $post['Post']['content'] ?>
				</div>
				<hr>
			</div>

			<?php
			endforeach;
			endif ?>
	</div>
	<div class="span5">
		<h4><?php echo __('Paskutinę savaitę pildyti protokolai') ?></h4>
		<hr>
		<?php if(!empty($events)): ?>
		<table class="table">
			<tr>
				<th><?php echo $this->Paginator->sort('id','Nr.');?></th>
				<th><?php echo $this->Paginator->sort('created','data');?></th>
				<th>Medžiaga</th>
				<th class="actions"><?php echo __('Veiksmai');?></th>
			</tr>
			<?php
			foreach ($events as $event): ?>
			<tr class="event_row" id="<?php echo $event['Event']['id'] ?>">
				<td><?php echo $event['Event']['id']; ?>&nbsp;</td>
				<td><?php echo $this->Time->format('Y-m-d',$event['Event']['created']) ?>&nbsp;</td>

				<td>
					<?php 

					if(!empty($event['Patient'][0]['Substance'])) {
						$substance_links = array();
						foreach ($event['Patient'][0]['Substance'] as $substance) {
							$substance_links[] = $this->Html->link($substance['name'], array('controller' => 'substances', 'action' => 'view', $substance['id']));
						}
						echo implode(', ', $substance_links);

					} else	if(!empty($event['Patient'][0]['AgentsPatient'])) {
						$agent_links = array();
						foreach ($event['Patient'][0]['AgentsPatient'] as $agent) {
							$agent_links[] = $this->Html->link($agent['Agent']['name'], array('controller' => 'agents', 'action' => 'view', $agent['Agent']['id']));
						}
						echo implode(', ', $agent_links);
					}
					?>
				</td>

				<td class="actions">
					<div class="btn-group">
						<?php 
						echo $this->Html->link('<i class="icon-zoom-in"></i>', array('controller'=>'events','action' => 'view', $event['Event']['id']),array('class'=>'btn btn-mini','escape'=>false));
						if(!$this->params['isAjax']) {
							echo $this->Html->link('<i class="icon-pencil"></i>', array('controller'=>'events','action' => 'edit',$event['Event']['id']),array('class'=>'btn btn-mini','escape'=>false ));
							if($this->Session->read('Auth.User.Group.name')=='admin')
								echo $this->Form->postLink('<i class="icon-trash icon-white"></i>', array('controller'=>'events','action' => 'delete', $event['Event']['id']), array('class'=>'btn btn-mini btn-danger','escape'=>false), __('Ar tikrai norite ištrinti # %s?', $event['Event']['id']));
						}
						?>
					</div>
				</td>
			</tr>
		<?php endforeach;?>
		</table>

		<p>
			<?php
			echo $this->Paginator->counter(array(
				'format' => __('Puslapis {:page} / {:pages}')
				));
				?>
				<span class="pull-right"><?php echo $this->Paginator->counter(array('format' =>'Viso: {:count}')) ?></span>
			</p>

			<?php echo $this->Paginator->pagination(); ?>

		<?php endif; ?>
	</div>

</div>