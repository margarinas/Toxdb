define(["jquery","tinymce"], function($) {
	
	init = function() {
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
		content_css:baseUrl+"css/bootstrap.min.css,"+baseUrl+"css/style.css"
	});

	};

	return {
		init:init
	};
});