define(["jquery","utils/pagination","utils/tableRow","utils/getElement"],function($,pagination,row){
	element.loadElement({name:'event/RelatedEventInput'},function(data){
		var related_event = $(data);
		$('#add-related-event').delegate('.event_row','click', function(event) {
			new_related_event = related_event.clone();
			$('.events-related').append(new_related_event);

			$('#add-related-event .modal-body').empty();
			$('#add-related-event').modal('hide');
			new_related_event.find('.event-related-input').val($(this).attr('id'));
			new_related_event.find('.remove-related-event').click(function(event) {
				$(this).parent().remove();
				event.preventDefault();
			});
		});
		$('#add-related-event .modal-body').delegate('a','click', function() {
			window.open( $(this).attr('href') );
			return false;
		});
		$('.add-related-event-btn').click(function(event) {
			$('#add-related-event .modal-body').load( event.target.href,'asd=asd');
			$("#add-related-event").modal({show:true, backdrop:'static'});
			event.preventDefault();
		});
	});






	$('.remove-related-event').click(function(event) {
// $(this).parent().nextUntil('div').remove();
$(this).parent().next().remove();
$(this).parent().remove();

event.preventDefault();
});

})