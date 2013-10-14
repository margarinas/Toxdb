<?php $this->Html->scriptBlock("require(['app/common'], function (main) { require(['app/login']); });",array('inline'=>false)); ?>
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
