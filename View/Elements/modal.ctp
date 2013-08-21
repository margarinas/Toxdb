<?php
$this->assign('modalId', !empty($id)?$id:'');
$this->assign('modalTitle', !empty($title)?$title:'');
$this->assign('modalFooter', !empty($footer)?$footer:'');
echo $this->element('modal', array(), array('plugin' => 'TwitterBootstrap')); 
?>