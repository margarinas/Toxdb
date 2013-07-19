// requirejs.config({
//     //By default load any module IDs from js/lib
//     baseUrl: baseUrl+'js',
//     //except, if the module ID starts with "app",
//     //load it from the js/app directory. paths
//     //config is relative to the baseUrl, and
//     //never includes a ".js" extension since
//     //the paths config could be for a directory.
//     paths: {
//        'jquery': 'lib/jquery-1.9.1.min',
//         'jquery-ui':'lib/jquery-ui.min',
//         'jquery-ui-timepicker':'lib/jquery-ui-timepicker-addon',
//         'jquery-ui-datepicker-lt':'lib/jquery.ui.datepicker-lt',
//         'jquery-ui-timepicker-lt':'lib/jquery-ui-timepicker-lt',
//         'bootstrap':'lib/bootstrap.min',
//         'tinymce':'lib/tiny_mce/tiny_mce'
//         // domReady:'lib/domReady'
//     },
//     shim: {
// 		// 'jquery':{
// 		// 	exports:'$'
// 		// },
//         'bootstrap':['jquery'],
//         'jquery-ui': ['jquery'],
//         'tiny_mce': ['jquery'],
//         "jquery-ui-timepicker": ['jquery',"jquery-ui"],
// 		'jquery-ui-datepicker-lt':['jquery',"jquery-ui","jquery-ui-timepicker"],
// 		"jquery-ui-timepicker-lt":['jquery',"jquery-ui","jquery-ui-timepicker"]
//     }
// });

// require(["jquery","tinymce","bootstrap","jquery-ui","jquery-ui-timepicker","jquery-ui-datepicker-lt","jquery-ui-timepicker-lt"], function($) {
  $(document).ready(function() {
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		theme_advanced_toolbar_location : "top",
		theme_advanced_buttons1 : "bold,italic,underline,bullist,numlist,undo,redo",
		plugins: 'paste',
		paste_auto_cleanup_on_paste : true,
		paste_remove_styles: true,
		paste_remove_styles_if_webkit: true,
		paste_strip_class_attributes: true,
		theme_advanced_resizing : true,
		language : "lt",
		height:'200'
		//content_css:baseUrl+"css/bootstrap.css"
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

//});

