({
   baseUrl: '.',
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
	appDir:".",
	dir: "../js-built",
	optimizeCss:'none',
	// mainConfigFile: 'main.js',
    // name: "main",
    // out: "main-built.js",
    modules: [
		{name:'app/index'},
		{name:'app/call.index'},
		{name:'app/event.add'},
		{name:'app/event.index'},
		{name:'app/login'},
		{name:'app/poison.add'},
		{name:'app/poison.index'},
		{name:'app/substance.search'}
    ]
})