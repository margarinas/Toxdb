define(["common"],function(){
	function init () {
		$('.report_date').datepicker();
		$("#EventReportForm").submit(function(event){

			url = $(this).attr('action');
			data = $(this).serialize();
			$("#busy-indicator").fadeIn();
			$.post(url,data,function(response){
				$("#container").html(response);
				$("#busy-indicator").fadeOut();
				init();
			});

			event.preventDefault();
		});
	}

	return {
		init:init
	};

});