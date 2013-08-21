define(["jquery","bootstrap"],function($){
	
	init = function(element){

		if(typeof element === "undefined")
			element = ".autocomplete";
		$(element).typeahead({
			minLength: 3,
			source: function (query, process) {

				return $.getJSON(
					baseUrl+'substances/find_poison/',
					{ term: query },
					function (data) {
						return process(data);
					});
			}


		});
	};
	return {
		init:init
	};
});