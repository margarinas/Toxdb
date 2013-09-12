define(["jquery"],function($){
	init = function(options) {

		if(typeof options !== "object" && typeof options !== "undefined")
			throw new Error("Must provide options as an object");

		defaults = {main_group:".main_group",subgroup_el:".poison_subgroup"};
		var settings = $.extend(defaults, options);

		$(settings.main_group).change(function(){
			subgroup = $(this).siblings(settings.subgroup_el);
			data = $(this).serialize();
			url = baseUrl+'agents/findSubgroups';

			$.ajax({
				beforeSend:function (XMLHttpRequest) {
					$("#busy-indicator").fadeIn();
				},
				complete:function (XMLHttpRequest, textStatus) {
					$("#busy-indicator").fadeOut();
				},
				success:function (data, textStatus) {
					if(data) {
						subgroup.html(data).show();
					} else {
						subgroup.empty().hide();
					}
				},
				method:"post",
				data:data,
				url:url
			});
		});
	};
	return {
		init:init
	};
});