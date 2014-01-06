define(['jquery',"utils/modal","utils/getElement","app/substance/actions"], function($,modal,element,actions) {



    var add_substance_options = {
        show:true,id:'add_substance',
        title:"Ieškoti nuodingosios medžiagos",
        footer:'<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button><button class="btn btn-primary disabled attach_substance">Priskirti medžiagą pacientui</button> ',
        onHide: function(){
            $('.modal .substance-actions').remove();
                var substance_count = $('.formated_substances').length;
                if( substance_count > 0)
                    $('.agent-main-group').remove();
               
                if(substance_count == 1)
                    $('.formated_substances input:radio').prop('checked',true);

                $(".agent_fields").each(function(step, field){
                 $(field).find('input:not(:checkbox), select').incrementInput({num:step,separator:'%'});
             });

                $('input.agent_dose_field').keyup(function(event) {
                    var toxic_dose = $(this).siblings('.agent_toxic_dose').val();
                    var dose_units = $(this).siblings('select.agent_dose_field').val();
                    var dose = $(this).val();
                    var patient_weight = $('#Patient0Weight').val();

                    if(dose_units == 'mg/kg') {
                    //PRAILGINTI PRADŽIĄ ir ĮDĖTI GALĄ VISĄ TOKĮ PATĮ KAIP PRADŽIĄ
                }
            });
        }
    };


    var content;
    element.loadElement({name:'substance/actions'}, function(data) {
        // add_substance_options.content = data;
        content = data;

    });

    $('.add_substance').click(function(event) {
        //console.log(add_substance_options);

        if($(this).hasClass('add-event-substance'))
            attachTo = 'Event';
        else
            attachTo = 'Patient.0';

        modal.set(add_substance_options, function() {

            $('.modal-header').after($(content).addClass('margin10'));
            actions.init({
                container:".modal-body",
                rowLimit:7,
                history:false,
                attachTo:attachTo,
                searchCallback: function() {
                    $(".modal-body .actions").hide();
                },
                rowClickCallback: function(){
                    $('.attach_substance').removeClass('disabled');
                    console.log('vlaio');
                }
            });
           // onHide();
            $('.attach_substance').click( function(event) {
                if(!$(this).hasClass('disabled')) {
                    $('.substances').append($('.select_substance:checked').next().find('input:checkbox').prop('checked','checked').parents('.formated_substances').removeClass('hide'));

                    $('#container .agents').append($('.select_substance:checked').siblings('.agent_fields').find('input:checkbox').prop('checked','checked').end().show());
                    $('#container .agents').append($('.select_agent:checked').next().find('input:checkbox').prop('checked','checked').parents('.agent_fields').show());
                    $('.attach_substance').addClass('disabled');
                    $('#add_substance').modal('hide');
                }
            });
        });

        event.preventDefault();

    });

    
});