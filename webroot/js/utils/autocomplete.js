define(["jquery","bootstrap","typeahead"],function($){

	init = function(element) {

		function scrollHeight()	{
			return $('.modal-body').scrollTop();
		}

/*		$.fn.typeahead.Constructor.prototype.show = function () {
			var pos = $.extend({}, this.$element.position(), {
				height: this.$element[0].offsetHeight
			});

			this.$menu
			.insertAfter(this.$element)
			.css({
				top: (pos.top + pos.height + scrollHeight.call()),
				left: pos.left
			})
			.show();

			this.shown = true;
			return this;

		};*/

		if(typeof element === "undefined")
			element = ".autocomplete";

/*		$(element).each(function(index,current){
			console.log(current);
			input_id = $(current).attr('id').toDash().split('-');
			input_id.shift();
			controller = input_id.shift()+'s'; //need to pluralize
			needle = input_id.join('_');
			$.getJSON(baseUrl+controller+'/autocomplete/'+needle, function (data) {
					$(current).typeahead({
					minLength: 1,
					source:data
				});
				});
			});*/
		$(element).each(function(index,current){
			input_id = $(current).attr('id').toDash().split('-');
			input_id.shift();
			controller = input_id.shift()+'s'; //need to pluralize
			needle = input_id.join('_');
			$(current).typeahead({
				name:controller+'_'+needle,
				prefetch:baseUrl+controller+'/autocomplete/'+needle,
				ttl:604800000
			});

		});
		
/*		$(element).typeahead({
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
		});*/

		
	};
	return {
		init:init
	};
});