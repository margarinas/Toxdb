define(["jquery"],function($){


	function init (options) {
		
		if(typeof options !== "object" && typeof options !== "undefined")
			throw new Error("Must provide options as an object");

		defaults = {element:".pagination a",container:"#container",limit:null,history:true,callback:null,scrollTo:false,showSummary:true};
		var settings = $.extend(defaults, options);


		if(!settings.showSummary) {
			$(".paginator-summary").hide();
		}

		$(settings.container).off('click',settings.element);
		$(settings.container).on("click", settings.element, function (event) {

			url = $(this).attr('href');
			data = {};
			if(settings.limit !== null)
				data.limit= settings.limit;
			if(url !== "#") {
				$.ajax({
					beforeSend:function (XMLHttpRequest) {
						$("#busy-indicator").fadeIn();
					},
					complete:function (XMLHttpRequest, textStatus) {
						$("#busy-indicator").fadeOut();
						if(!settings.showSummary) {
							$(".paginator-summary").hide();
						}
						if(settings.scrollTo === false)
							$(settings.container).parent().scrollTop(0);
						
						if(settings.history)
							history.pushState(null, null, url);

						if(typeof settings.callback === "function"){
							settings.callback(XMLHttpRequest);
						}
					},
					success:function (data, textStatus) {
						$(settings.container).html(data);
						// init(settings);
					},
					data:data,
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