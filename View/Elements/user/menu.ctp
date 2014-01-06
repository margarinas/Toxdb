<?php 
echo $this->Form->create('Substance',array('action'=>'search','class'=>'form-inline','type'=>'get', 'target'=>'_blank'));
echo $this->Form->input('term',array('label'=>false,'class'=>'search_input input-medium','placeholder'=>__('Greita paieška...')));
		//echo $this->Form->submit('Ieškoti');

echo $this->Form->end();
?>
<hr>
<ul class="nav nav-tabs nav-stacked user-menu">
	<?php 
	if($this->Session->read('Auth.User.Group.name') == 'admin')
		echo $this->Menu->menuList(array(
			'/'=>array('title'=>__('Pagrindinis')),
			// '/drafts/index'=>array('title'=>__('Pagrindinis')),
			'/calls' => array('title'=>__('Skambučiai')),
			'/events/report' => array('title'=>__('Ataskaita')),
			'/cms/posts' => array('title'=>__('Naujienos'))
			)
		);
	else
		echo $this->Menu->menuList(array(
			'/'=>array('title'=>__('Pagrindinis')),
			// '/drafts/index'=>array('title'=>__('Pagrindinis')),
			'/calls' => array('title'=>__('Skambučiai'))
			)
		);
	?>
</ul>
