define(["jquery","tinymce"],function(e){return init=function(){e("textarea").tinymce({script_url:baseUrl+"js/lib/tinymce/tinymce.min.js",theme:"modern",toolbar:"bold italic underline | bullist numlist | undo redo",menubar:!1,plugins:"paste",fix_list_elements:!0,height:"200",width:"80%",content_css:baseUrl+"css/bootstrap.css,"+baseUrl+"css/style.css"})},{init:init}});