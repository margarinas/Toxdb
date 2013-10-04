define(["jquery","utils/autocomplete","bootstrap","jquery-ui","jquery-ui-timepicker","jquery-ui-datepicker-lt","jquery-ui-timepicker-lt"], function($,autocomplete) {


	//$('#EventCreated').datetimepicker();
	//$('.checkbox input').buttonset();
	//$('.patient_attribute .checkbox').buttonset();
	//$('.radio').buttonset();
	//$('.button').button();
	//$("#EventCity").combobox();,

	$('.datetimepicker').datetimepicker();
	$('.timepicker').timepicker();
	$('.datepicker').datepicker();

	$('.unknown_value').click(function(event) {
		$(this).siblings('input').val('Nežinoma');
	});

	$('.decimal_input').attr('step','0.001');

	refreshScrollSpy = function() {
		$('[data-spy="scroll"]').each(function () {
			$(this).scrollspy('refresh');
		});
	};
	

	String.prototype.toDash = function(){
		return this.replace(/([A-Z])/g, function($1){return "-"+$1.toLowerCase();});
	};

	autocomplete.init();




});
