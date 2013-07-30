requirejs.config({
	baseUrl: baseUrl+'js',
	paths: {
		'main': 'main',
		//'jquery': 'lib/jquery-1.9.1.min',
		'jquery-ui':'lib/jquery-ui.min',
		'jquery-ui-timepicker':'lib/jquery-ui-timepicker-addon',
		'jquery-ui-datepicker-lt':'lib/jquery.ui.datepicker-lt',
		'jquery-ui-timepicker-lt':'lib/jquery-ui-timepicker-lt',
		'bootstrap':'lib/bootstrap.min',
		'tinymce':'lib/tinymce/jquery.tinymce.min'
	},
	shim: {
		'bootstrap':['jquery'],
		'jquery-ui': ['jquery'],
		'tinymce': ['jquery'],
		"jquery-ui-timepicker": ['jquery',"jquery-ui"],
		'jquery-ui-datepicker-lt':['jquery',"jquery-ui","jquery-ui-timepicker"],
		"jquery-ui-timepicker-lt":['jquery',"jquery-ui","jquery-ui-timepicker"]
	}
});

define(["jquery","tinymce","bootstrap","jquery-ui","jquery-ui-timepicker","jquery-ui-datepicker-lt","jquery-ui-timepicker-lt"], function($) {

	 $('textarea').tinymce({
		//mode : "textareas",
		script_url : baseUrl+'js/lib/tinymce/tinymce.min.js',
		theme : "modern",
		// theme_advanced_toolbar_location : "top",
		// theme_advanced_buttons1 : "bold,italic,underline,bullist,numlist,undo,redo",
		toolbar : "bold italic underline | bullist numlist | undo redo",
		menubar:false,
		plugins: 'paste',
		fix_list_elements : true,
		//extended_valid_elements : "img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name]"
		// paste_auto_cleanup_on_paste : true,
		// paste_remove_styles: true,
		// paste_remove_styles_if_webkit: true,
		// paste_strip_class_attributes: true,
		// theme_advanced_resizing : true,
		// language : "lt",
		height:'200',
		width:'80%',
		content_css:baseUrl+"css/bootstrap.css,"+baseUrl+"css/style.css"
	});

	//$('#EventCreated').datetimepicker();
	//$('.checkbox input').buttonset();
	//$('.patient_attribute .checkbox').buttonset();
	//$('.radio').buttonset();
	//$('.button').button();
	//$("#EventCity").combobox();
	$('.datetimepicker').datetimepicker();
    $('.timepicker').timepicker();
    $('.datepicker').datepicker();

	$('.unknown_value').click(function(event) {
		$(this).siblings('input').val('Nežinoma');
	});

	$('.decimal_input').attr('step','0.001');


	String.prototype.toDash = function(){
		return this.replace(/([A-Z])/g, function($1){return "-"+$1.toLowerCase();});
	};

	$('.autocomplete').typeahead({
		minLength: 3,
		source: function (query, process) {


			input_id = $(this.$element).attr('id')
						.toDash()
						.split('-');

			input_id.shift();

			controller = input_id.shift()+'s'; //need to pluralize
			needle = input_id.join('_');


			return $.getJSON(
				baseUrl+controller+'/autocomplete/'+needle,
				{ term: query },
				function (data) {
					return process(data);
				});
		}

	});


});
