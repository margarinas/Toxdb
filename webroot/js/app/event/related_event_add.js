define(["jquery","utils/pagination","utils/tableRow","utils/getElement","utils/modal","app/event/index"],function($,pagination,row,element,modal,events){


	var options = {
        show:true,id:'add-related-event',
        title:"Ieškoti atvejo",
        getUrl:"events",
        footer:""
    };


	element.loadElement({name:'event/RelatedEventInput'},function(data){
		var related_event = $(data);
		// $('#add-related-event').delegate('.event_row','click', function(event) {
			
		// });
		$('.add-related-event-btn').click(function(event) {
			modal.set(options, function() {
				events.init({container:".modal-body"});
				row.init(".event_row",".modal-body", function(target) {
					new_related_event = related_event.clone();
					$('.events-related').append(new_related_event);

					// $('#add-related-event .modal-body').empty();
					$('#add-related-event').modal('hide');
					console.log(target);
					new_related_event.find('.event-related-input').val($(target).attr('id'));
					new_related_event.find('.remove-related-event').click(function(event) {
						$(this).parent().remove();
						event.preventDefault();
					});
				});

			});
			event.preventDefault();
		});

	});






	$('.remove-related-event').click(function(event) {
// $(this).parent().nextUntil('div').remove();
$(this).parent().next().remove();
$(this).parent().remove();

event.preventDefault();
});

});