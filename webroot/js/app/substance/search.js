define(['jquery'],function($){
	init = function(query,callback) {

		function searchPoison(poison,query,callback) {

			$.ajax({
				async:true,
				beforeSend:function (XMLHttpRequest) {
					$("#busy-indicator").fadeIn();
				},
				complete:function (XMLHttpRequest, textStatus) {
					$("#busy-indicator").fadeOut();
				},
				data:query,
				dataType:"html",
				evalScripts:true,
				success:function (data, textStatus) {
					$("#"+poison).html(data);
					if(typeof callback === "function")
						callback(data);
				},
				url:baseUrl+poison
			});
		}

		searchPoison('substances',query,callback);
		searchPoison('agents',query,callback);



	};
	return {
		init:init
	};
});