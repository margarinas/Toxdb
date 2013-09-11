define(["utils/tableRow","utils/pagination"],function(row, pagination){
	init = function(options) {
		defaults = {container:"#container"};
		var settings = $.extend(defaults, options);
		row.init(" .call_row",settings.container);
		pagination.init({container:settings.container});
	};

	return {
		init:init
	};
	
});