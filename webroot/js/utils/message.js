define(["jquery","bootstrap"],function($){
	init = function(message,options) {

		defaults = {container:"#container", position:"fixed", addClass:null, autoHide:true};
		var settings = $.extend(defaults, options);

		msgContainer = $('<div class="alert alert-block"><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
		if(settings.position === "fixed")
			msgContainer.addClass('message-fixed');

		if(settings.addClass !== null)
			msgContainer.addClass(addClass);

		msgContainer.append(message).prependTo(settings.container).hide().fadeIn();
		// $(settings.container).prepend(msgContainer);

		if(settings.autoHide) {
			
			msgContainer.delay(4000).fadeOut('fast',function(){
				$(this).remove();
			});

		}
	};

	return {
		init:init
	};
});