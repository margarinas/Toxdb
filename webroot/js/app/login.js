define(['jquery'], function($) {
	$(document).ready(function() {
		$('#toxinz_login').submit();
		//$('#toxbase_login').submit();
		$('#busy-indicator').show();
		setTimeout(function(){
			window.location.replace(baseUrl+"users/dashboard");
		},1000);
	});
});