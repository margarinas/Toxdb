define(["jquery"],function($) {
		// Stuff to do as soon as the DOM is ready;
	init = function (element,parentElement,passedFunction) {
		// body...

		if(typeof parentElement === "function")
			passedFunction = parentElement;
		if(typeof parentElement !== "string")
			parentElement = "#container";
		$(parentElement).off('click',element);
		$(parentElement).on('click', element, function(event) {
			var checkbox = $(this).find('.select-element');

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