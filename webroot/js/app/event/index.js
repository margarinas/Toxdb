define(["utils/tableRow","utils/pagination","utils/getElement","utils/autocomplete","utils/poisonAutocomplete"], function(row,pagination,element,autocomplete,poisonAutocomplete) {

	function init(options) {
		defaults = {container:"#container",rowCallback:null,hideControls:false};
		var settings = $.extend(defaults, options);

		row.init(".event_row",function(){
			if(typeof settings.rowCallback === "function")
				settings.rowCallback();
		});

		if(settings.hideControls === true) {
			$(settings.container+" .control-hide").hide();
		}

		pagination.init({container:settings.container,callback:init});
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
				beforeSend: function (XMLHttpRequest) {
					$("#busy-indicator").fadeIn();
				},
				complete:function(jqXHR, textStatus) {
					$("#busy-indicator").fadeOut();
				},
				success: function (data, textStatus,jqXHR ) {
					$(settings.container).html(data);
					init(settings);
					history.pushState(null,null,$(data).find('#EventCurrentUrl').val())
				},
				data:data,
				url:url
			});
			event.preventDefault();
		});
	}

	return {
		init:init
	};
	
});