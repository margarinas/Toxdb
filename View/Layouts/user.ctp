<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html>
<html lang="lt">
<head>
	<meta charset="UTF-8">
	<title>
		
		<?php echo $title_for_layout; ?>
		<?php echo __(':: AKIB duomenų bazė'); ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php
	echo $this->Html->meta('icon');



	echo $this->Html->css(array(
		'ui/jquery-ui-1.9.2.custom',
		'bootstrap.min', 
		'bootstrap-responsive.min',
		'style'
		));


	echo $this->fetch('meta');
	echo $this->fetch('css');
	

	?>
	<script>
		var jsVersion = "<?php echo Configure::read('JsVersion') ?>"
		var baseUrl = "<?php echo $this->Html->url('/') ?>";
	</script>

	<?php 
	echo $this->Html->script('require.js',array('data-main'=>$this->Html->url('/')."js/main.js?v=".Configure::read('JsVersion')));
	echo $this->fetch('script');
	?>


</head>
<body data-spy="scroll" data-target="#sidebar_nav" data-offset="60">
	<?php echo $this->element('menu') ?>
	<header></header>
	<div class="container">
		<div class="row">
			<div class="span2">
				<?php echo $this->element('user/menu') ?>
			</div>
			<div class="span10" id="container">
				<?php echo $this->Session->flash(); ?>

				<?php echo $this->fetch('content'); ?>
			</div>
		</div>
		<footer class="footer">

		</footer>
	</div>
	<?php
	$this->assign('modalId', '');
	$this->assign('modalTitle', '');
	$this->assign('modalFooter', '');
	$this->start('modalFooter');?>
	<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	<?php
	$this->end();
	echo $this->element('modal', array(), array('plugin' => 'TwitterBootstrap')); 
	?>
	
	<div id="busy-indicator"></div>
	<?php //echo $this->element('sql_dump'); ?>
</body>
</html>
