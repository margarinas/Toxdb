define(function() {
		// Stuff to do as soon as the DOM is ready;
	init = function (element,passedFunction) {
		// body...

		$(element).click(function(event) {
			//console.log(event);
			var checkbox = $(this).find('.select-element');

			if(checkbox.prop('checked') && $(this).hasClass('success'))
				checkbox.prop('checked',false);
			else if(!$(this).hasClass('success'))
				checkbox.prop('checked','checked');
			$(this).toggleClass('success');
			if(passedFunction)
				passedFunction();
		});
	};

	return {
		init:init
	};

});