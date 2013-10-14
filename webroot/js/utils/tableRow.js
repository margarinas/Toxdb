define(["jquery"],function($) {
		// Stuff to do as soon as the DOM is ready;
	init = function (element,parentElement,passedFunction) {
		// body...
		console.log(element,parentElement);

		//$(parentElement).off('click',element);
		// $(parentElement).off('click');

		if(typeof parentElement === "function")
			passedFunction = parentElement;
		if(typeof parentElement !== "string")
			parentElement = "#container";

		if(parentElement !== "#container") {

			$(parentElement).on('click',element+" a:not(.post-link)",function(event) {
				
				window.open($(this).attr('href'));

				return false;
			});
		}
		
		$(parentElement).on('click', element, function(event) {
			var checkbox = $(this).find('.select-element');
			console.log(parentElement);
			if(checkbox.prop('checked') && $(this).hasClass('success'))
				checkbox.prop('checked',false);
			else if(!$(this).hasClass('success'))
				checkbox.prop('checked','checked');
			$(this).toggleClass('success');
			if(typeof passedFunction === "function")
				passedFunction(this);
		});
	};

	return {
		init:init
	};

});