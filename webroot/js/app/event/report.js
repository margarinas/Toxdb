define(function(){
	function init () {
		$('.report_date').datepicker();
		$("#EventReportForm").submit(function(event){

			url = $(this).attr('action');
			data = $(this).serialize();
			$("#busy-indicator").fadeIn();

			$.ajax({
				type:"POST",
				url:url,
				data:data,
				timemout:600000,
				success:function(response){
					$("#container").html(response);
					$("#busy-indicator").fadeOut();
					init();
				}
			});

			event.preventDefault();
		});
	}

	return {
		init:init
	};

});
