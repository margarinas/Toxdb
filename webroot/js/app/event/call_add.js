define(['jquery',"utils/modal","utils/tableRow"], function($,modal,row) {




    var add_call_options = {
        getUrl:'calls',
        show:true,id:'add_call',
        title:"Ieškoti konsultacijos įrašo",
        footer:'<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button><button class="btn btn-primary disabled attach_call">Priskirti įrašą</button>',
        onHide:function() {
            var seen = {};
            $(".attached-call-id").each(function(){
                value = $(this).val();
                if (seen[value])
                    $(this).parent().remove();
                else
                    seen[value] = true;

                console.log($(this).val());
            });

            $(".call_fields").each(function(step, field){
                $(field).find('input').incrementInput({num:step,separator:'%'});
            });
        }
    };


    


    removeCallFunc = function() {
        $('.remove-call').unbind().click(function(event){
            removeCall = $(this);
            $.post(removeCall.attr('href'),function(data){
                if(data.success)
                    removeCall.parent().fadeOut("normal",function() { $(this).remove(); });
            });

            event.preventDefault();
        });
    };

    $('.add-call-btn').click(function(event) {

        modal.set(add_call_options, function() {
            row.init('tr.call_row','.modal', function(){
                $('.attach_call').removeClass('disabled');
            });
            $('.call_row a').click( function() {
                window.open( $(this).attr('href') );
                return false;
            });


            $('.attach_call').click( function(event) {
                if(!$(this).hasClass('disabled')) {
                    $('.calls-attached').append($(".select_call:checked").siblings('.call_fields').show());
                    if($('#EventPhone').val().length === 0)
                        $('#EventPhone').val($(".select_call:checked").parents(".call_row").find(".call_number").text());
                    removeCallFunc();
                    $('#add_call').modal('hide');
                }
                event.preventDefault();
            });
        });
        //$('#add_call').modal({show:true, backdrop:'static'});
        event.preventDefault();
    });



});