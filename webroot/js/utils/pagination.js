define(["jquery"],function($){


	function init (options) {

		if(typeof options !== "object" && typeof options !== "undefined")
			throw new Error("Must provide options as an object");

		defaults = {element:".pagination",container:"#container",limit:20,history:true,callback:null,scrollTo:false};
		var settings = $.extend(defaults, options);

		
		$(settings.element).on("click", 'a', function (event) {
			url = $(this).attr('href');
			console.log(url);
			if(url !== "#") {
				$.ajax({
					beforeSend:function (XMLHttpRequest) {
						$("#busy-indicator").fadeIn();
					},
					complete:function (XMLHttpRequest, textStatus) {
						$("#busy-indicator").fadeOut();

						if(settings.scrollTo === false)
							$(settings.container).parent().scrollTop(0);
						
						if(settings.history === true)
							history.pushState(null, null, url);

						if(typeof settings.callback === "function")
							settings.callback(XMLHttpRequest);
					},
					success:function (data, textStatus) {
						$(settings.container).html(data);
						init(settings);
					},
					data:{limit:settings.limit},
					url:url
				});
			}
			event.preventDefault();
				//return false;
			});

	}

	return {
		init:init
	};
});