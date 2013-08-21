define(["jquery","utils/pagination","utils/tableRow"],function($,pagination,row){
	$('.search_antidote').click(function(event) {
		$('.antidote_search_results').load(baseUrl+"antidotes/index/"+$(this).prev().val(),"limit=7",function(){
			row.init(".antidote_row",".antidote_search_results");
			pagination.init({element:".antidote_search_results .pagination", container:".antidote_search_results",history:false,limit:7});
		});
		$('#antidote_to_patient').show();
	});

	$('#antidote_to_patient').click(function(event) {
		$('.antidotes_attached').append($('.select_antidote:checked').next().find('input:checkbox').prop('checked','checked').end().show());
		$('.antidote_search_results').empty();
		$(this).hide();
	});

});