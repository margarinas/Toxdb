define(["utils/tableRow","utils/pagination"],function(row, pagination){
	init = function(options) {
		defaults = {container:"#container",updateButton:false};
		var settings = $.extend(defaults, options);
		row.init(" .call_row",settings.container);
		pagination.init({container:settings.container});
		if(settings.updateButton)
			("#calls-get").show();
	};

	return {
		init:init
	};
	
});