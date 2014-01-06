define(['jquery'],function($){
	if($('.alert-error').length) {
		window.onbeforeunload = function(){
			return "Ar tikrai norite pereiti į kitą puslapį?";
		};
	}

	$('input, textarea, select, checkbox, radio').change(function() {
		if( ($(this).val() !== "")) {
			window.onbeforeunload = function(){
				return "Ar tikrai norite pereiti į kitą puslapį?";
			};
		}
	});
});