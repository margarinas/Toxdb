<?php if (!empty($drafts)): ?>
<table class="table">
	<tr class="pagination">
		<th><?php echo $this->Paginator->sort('created','sukurtas');?></th>
		<th><?php echo __('Konsultacijos data'); ?></th>
		<th><?php echo __('Protokolo nr.'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>

		
	
	<?php foreach ($drafts as $draft): ?>
		<tr class="draft_row">
			<td>
			<?php echo $this->Time->format('Y-m-d',$draft['Draft']['created']) ?>&nbsp;
			</td>
			
			<td><?php echo $this->Time->format('Y-m-d H:i',$draft['Draft']['content']['Event']['created']); ?>&nbsp;</td>
			<td>
			<?php 
			if(!empty($draft['Draft']['content']['Event']['id']))
				echo $this->Html->link($draft['Draft']['content']['Event']['id'],array('controller'=>'events','action'=>'view',$draft['Draft']['content']['Event']['id']));
			else 
				echo "";
			?>
			</td>
			<td class="actions">
				<div class="btn-group">
					<?php 
						echo $this->Html->link('<i class="icon-pencil"></i>', array('controller'=>Inflector::pluralize($draft['Draft']['model']),'action' => 'restoreDraft',$draft['Draft']['id']),
							array('class'=>'btn btn-mini control-hide','escape'=>false ));

						echo $this->Html->link('<i class="icon-trash icon-white"></i>', array('action' => 'delete', 'ext'=>'json','?'=>array('id'=>$draft['Draft']['id'])),
								array('class'=>'btn btn-mini btn-danger control-hide draft-delete post-link','escape'=>false));
					?>
				</div>
			</td>
		</tr>
	<?php endforeach; ?>
</table>

<?php echo $this->Paginator->pagination(); ?>

<?php else: ?>
<p class="alert"><?php echo __('Juodraščių nerasta'); ?></p>
<?php endif; ?>