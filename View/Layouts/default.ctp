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
	
	echo $this->Html->script(array(
		'lib/jquery-1.9.1.min',
		'lib/bootstrap.min',
		'lib/jquery-ui.min',
		'lib/jquery-ui-timepicker-addon',
		'lib/jquery-ui-timepicker-lt',
		'lib/jquery.ui.datepicker-lt',
		'lib/tiny_mce/tiny_mce',
		'lib/jquery.incrementInput',
		// 'main'
		));


	
		?>

	<script>
		var baseUrl = "<?php echo $this->Html->url('/') ?>";
		// tinyMCE.init({
		// 	mode : "textareas",
		// 	theme : "advanced",
		// 	theme_advanced_toolbar_location : "top",
		// 	theme_advanced_buttons1 : "bold,italic,underline,bullist,numlist,undo,redo",
		// 	plugins: 'paste',
		// 	paste_auto_cleanup_on_paste : true,
		// 	paste_remove_styles: true,
		// 	paste_remove_styles_if_webkit: true,
		// 	paste_strip_class_attributes: true,
		// 	theme_advanced_resizing : true,
		// 	   language : "lt",
		// 	   height:'200',
		// 	 //content_css:baseUrl+"css/bootstrap.css"


		// });
	</script>


	<?php 
	echo $this->Html->script('require.js',array('data-main'=>$this->Html->url('/')."js/main.js"));
	echo $this->fetch('script');
	 ?>


</head>
<body data-spy="scroll" data-target="#sidebar_nav" data-offset="60">
	<?php echo $this->element('menu') ?>
	<header></header>
	<div class="container">
		
		<?php echo $this->Session->flash(); ?>

		<?php echo $this->fetch('content'); ?>

		<footer class="footer">

		</footer>
	</div>

	<?php //echo $this->element('sql_dump'); ?>
	<?php echo $this->fetch('scriptBottom'); ?>
	<?php echo $this->Js->writeBuffer(); ?>
	<div id="busy-indicator"></div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
