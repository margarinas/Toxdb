 <?php 
echo $this->Form->create(null,array('url'=>'http://www.toxinz.com/Login','target'=>'_blank','id'=>'toxinz_login'));
?>
<input id="LoginUserName" name="LoginUserName" type="hidden" value="lithuaniapcc" />
<input id="LoginPassword" name="LoginPassword" type="hidden" value="vilnius" />
<input id="logOnReturnUrl" name="returnUrl" type="hidden" value="/" />
<?php
echo $this->Form->end();
?>
<?php 
echo $this->Form->create(null,array('url'=>'http://www.toxbase.org/Util/login.aspx','target'=>'_blank','id'=>'toxbase_login','name'=>'aspnetForm'));
?>
<input name="ctl00$FullRegion$LoginControl$UserName" type="hidden" value="EEC11">
<input name="ctl00$FullRegion$LoginControl$Password" type="hidden" value="VILNOCT5">
<input type="hidden" name="ctl00$FullRegion$LoginControl$Button1" value="Log In">
<?php
echo $this->Form->end();
?>
  <script type="text/javascript">
  $(document).ready(function() {
		$('#toxinz_login').submit();
		//$('#toxbase_login').submit();
		$('#busy-indicator').show();
		setTimeout(function(){window.location.replace("<?php echo $this->Html->url('/users/dashboard') ?>")},1000);

	});
 </script>
