define(["jquery","bootstrap"],function($){
	
	init = function(element){

		if(typeof element === "undefined")
			element = ".autocomplete";


/*		$(element).typeahead({
			minLength: 3,
			source: function (query, process) {

				return $.getJSON(
					baseUrl+'substances/find_poison/',
					{ term: query },
					function (data) {
						return process(data);
					});
			}


		});*/

		// $.getJSON(baseUrl+'substances/find_poison/', function (poisons) {
			// console.log(data);
				$(element).typeahead({
					name:'all_poisons',
					prefetch:baseUrl+'substances/find_poison/'
				});
			// });

		
	};
	return {
		init:init
	};
});