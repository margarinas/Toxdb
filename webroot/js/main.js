requirejs.config({
	baseUrl: baseUrl+'js',
	urlArgs: "v=1.02",
	paths: {
		'main': 'main',
		//'domReady':'lib/domReady',
		'purl':'lib/purl',
		'common' : 'app/common',
		'jquery': 'lib/jquery',
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
		'purl': ['jquery'],
		"jquery-ui-timepicker": ['jquery',"jquery-ui"],
		'jquery-ui-datepicker-lt':['jquery',"jquery-ui","jquery-ui-timepicker"],
		"jquery-ui-timepicker-lt":['jquery',"jquery-ui","jquery-ui-timepicker"]
	}
});

