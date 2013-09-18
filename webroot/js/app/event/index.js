define(["utils/tableRow","utils/pagination","utils/getElement","utils/autocomplete","utils/poisonAutocomplete","utils/message"], function(row,pagination,element,autocomplete,poisonAutocomplete,msg) {

	var settings;

	function init(options) {
		defaults = {container:"#container",rowCallback:null,hideControls:false, search:true, callback:null, showPaginatorSummary: true, limit:20};
		settings = $.extend(defaults, options);

		row.init(".event_row",settings.container,function(){
			if(typeof settings.rowCallback === "function")
				settings.rowCallback();
		});

		if(settings.hideControls === true) {
			$(settings.container+" .control-hide").hide();
		}

		if(settings.container === "#container")
			showHistory = true;
		else
			showHistory= false;


		if(typeof settings.callback === "function") {
			firstCallback = settings.callback;
			settings.callback = function() {
				firstCallback();
				eventSearch();
			};
		} else {
			
			if(settings.search)
				settings.callback = eventSearch;
		}

		pagination.init({container:settings.container,history:showHistory,callback:settings.callback,showSummary:settings.showPaginatorSummary,limit:settings.limit});
		$('.datepicker').datepicker();
		autocomplete.init();
		poisonAutocomplete.init("#poison_autocomplete");

		events_selected = false;
		$('.event-select-all').click(function(event) {
			if(events_selected) {
				$('.event_row').removeClass('success').find('.select_event').prop('checked','');
				events_selected = false;
			}
			else {
				$('.event_row').addClass('success').find('.select_event').prop('checked','checked');
				events_selected = true;
			}
			
			event.preventDefault();
		});

		$(settings.container).on("click",'.event-delete', function(event){

			var event_row = $(this).parents("tr.event_row");

			if(confirm('Ar tikrai norite ištrinti ?')) {
				$.post($(this).attr('href'),function(data){
					console.log(data);
					if(data.result === "success") {
						event_row.fadeOut(function(){
							$(this).remove();
						});
					}
						
					msg.init(data.message);
					
					
				});
			}

			event.preventDefault();
			return false;
		});


		if(typeof settings.callback === "function")
			settings.callback();
	}


	eventSearch = function() {
				

			$('.clear-search').click(function() {
				$('#EventFindForm input').val('').prop('checked',false);
				$("#EventFindForm select").each(function(){
					$(this)[0].selectedIndex = 0;
				});
			});

			$("#EventFindForm").submit(function(event) {
				url = $(this).attr('action');
				data = $(this).serialize();

				$.ajax({
					method:"post",
					timeout:300000,
					beforeSend: function (XMLHttpRequest) {
						$("#busy-indicator").fadeIn();
					},
					complete:function(jqXHR, textStatus) {
						$("#busy-indicator").fadeOut();
					},
					success: function (data, textStatus,jqXHR ) {
						$(settings.container).html(data);
						init(settings);
						if(settings.container === "#container")
							history.pushState(null,null,$(data).find('#EventCurrentUrl').val());
					},
					data:data,
					url:url
				});
				event.preventDefault();
			});
		
	};

	return {
		init:init,
		search:eventSearch
	};
	
});