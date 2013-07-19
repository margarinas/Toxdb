<?php 
//pr($this->data);
//pr($substances);
//pr($agents);
echo $this->element('substance/actions');
?>
<div class="row-fluid">
	<div class="span6" id="substances"></div>
	<div class="span6" id="agents"></div>
</div>

<?php 
$this->Js->buffer(
	$this->Js->request(
		array('controller'=>'substances','action' => 'index'),
		array('async' => true, 'update' => '#substances','evalScripts' => true,
			'data'=>array('term'=>$term,'attachTo'=>!empty($attachTo)?$attachTo:false),
				'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    			'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false))
    			)
	).
	$this->Js->request(
		array('controller'=>'agents','action' => 'index'),
		array('async' => true, 'data'=>array('term'=>$term,'attachTo'=>!empty($attachTo)?$attachTo:false),'update' => '#agents','evalScripts' => true)
	)
);

if($this->params['isAjax'])
	echo $this->Js->writeBuffer();
?>

	


