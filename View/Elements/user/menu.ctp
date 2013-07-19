<?php 
echo $this->Form->create('Substance',array('action'=>'search','class'=>'form-inline','type'=>'get', 'target'=>'_blank'));
echo $this->Form->input('term',array('label'=>false,'class'=>'search_input input-medium','placeholder'=>__('Greita paieška...')));
		//echo $this->Form->submit('Ieškoti');

echo $this->Form->end();
?>
<hr>
<ul class="nav nav-tabs nav-stacked">
	<?php 
	if($this->Session->read('Auth.User.Group.name') == 'admin')
		echo $this->Menu->menuList(array(
			'/calls' => array('title'=>__('Skambučiai')),
			'/events/report' => array('title'=>__('Ataskaita')),
			'/cms/posts' => array('title'=>__('Naujienos'))
			)
	);
	?>
</ul>
