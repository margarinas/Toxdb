define(["utils/tableRow","utils/pagination","utils/message"],function(row, pagination,msg){
	init = function(options) {
		defaults = {container:"#container",showHistory:false};
		var settings = $.extend(defaults, options);
		row.init(".draft_row",settings.container);
		pagination.init({container:settings.container,history:settings.showHistory});

		// $('.draft-delete').unbind("click");
		$(settings.container).on("click",'.draft-delete', function(event){

			var draft = $(this).parents("tr.draft_row");
			console.log(draft);

			if(confirm('Ar tikrai norite ištrinti ?')) {
				$.post($(this).attr('href'),function(data){
					console.log(data);
					if(data.result === "success") {
						draft.fadeOut(function(){
							$(this).remove();
						});
					}
						
					msg.init(data.message);
					
					
				});
			}

			event.preventDefault();
			return false;
		});
	};

	return {
		init:init
	};

});