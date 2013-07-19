require(["utils/stopReload","utils/getElement","lib/jquery.incrementInput"], function(require,element){

    $(document).ready(function() {

        $('#Patient0Name').keyup(function(){
            if($('#EventPatientRequest').is(':checked'))
                $('#EventRequesterName').val($('#Patient0Name').val());
        });
        $('#EventRequesterName').keyup(function(){
            if($('#EventPatientRequest').is(':checked'))
                $('#Patient0Name').val($('#EventRequesterName').val());
        });

        $('#EventPatientRequest').change(function(){
            if($('#EventPatientRequest').is(':checked')) {
                $('#Patient0Name').val($('#EventRequesterName').val());
                $('#Patient0Address').val($('#EventAddress').val());
                $('#Patient0Phone').val($('#EventPhone').val());
            }
        });


        $('.p_type_main').click(function(e) {
            var main = $(e.target);
            $('.p_cause').each(function() {
                if($(this).children('label:first').text() == main.parent().text()) {
                    $(this).slideDown();
                } else {
                    $(this).find('input:radio').attr('checked',false);
                    $(this).hide();
                //console.log($(this).find('input'));
            }
        });

        });

        $('.p_type_main').each(function() {
            var main = $(this);
            if(main.is(':checked')) {
                $('.p_cause').each(function() {
                    if($(this).children('label:first').text() == main.parent().text())
                        $(this).show();

                });
            }

        });


        refreshScrollSpy = function() {
            $('[data-spy="scroll"]').each(function () {
              $(this).scrollspy('refresh');
          });
        };

        var patient_links;
        var event_attr_section_link;
        var event_substances;
        var event_agents;
        var patient_substances;
        var patient_agents;
        $('.event_toggle_patient').change(function(event) {
            if($(this).is(":checked")) {
                patient_links = $('.patient_section_link').detach();
                $('.patient').hide();
                $('.add-event-substance').show();

                patient_substances = $('.substances .formated_substances').detach();
                patient_agents = $('.agents .agent_fields').detach();

                $('.substances, .substances + hr, .agents, .agents + hr').appendTo('.event-substances');
                if(event_substances)
                    event_substances.appendTo('.substances');
                if(event_agents)
                    event_agents.appendTo('.agents');

                $('#EventNoPatient').prop('checked','checked');
            } else {

                patient_links.insertAfter('.event_main_section_link');
                patient_links = null;
                $('.patient').show();
                $('.add-event-substance').hide();
                event_substances = $('.substances .formated_substances').detach();
                event_agents = $('.agents .agent_fields').detach();
                $('.substances, .substances + hr, .agents, .agents + hr').insertAfter($('#poison_attach_button').parent());
                if(patient_substances)
                    patient_substances.appendTo('.substances');
                if(patient_agents)
                    patient_agents.appendTo('.agents');

                $('#EventNoPatient').prop('checked','');
            }
            refreshScrollSpy();
        });

$('.event_invalid_request').change(function(event) {
    if($(this).is(":checked")) {
        event_attr_section_link  = $('.event_attr_section_link').detach();
        $('.event_attributes').hide();
    } else {
        $('.event_attr_section_link').show();
        $('.event_attributes').show();
        $('.event_attr_section_link').appendTo('.sidebar-nav');
        event_attr_section_link  = null;
    }
    refreshScrollSpy();
});


if($('.event_toggle_patient').is(':checked')) {
    patient_links = $('.patient_section_link').detach();
    refreshScrollSpy();
}

if($('.event_invalid_request').is(':checked')) {
    event_attr_section_link  = $('.event_attr_section_link').detach();
    refreshScrollSpy();
}

$('.search_antidote').click(function(event) {
    $('.antidote_search_results').load(baseUrl+"antidotes/index/"+$(this).prev().val());
    $('#antidote_to_patient').show();
});

$('#antidote_to_patient').click(function(event) {
    $('.antidotes_attached').append($('.select_antidote:checked').next().find('input:checkbox').prop('checked','checked').end().show());
    $('.antidote_search_results').empty();
    $(this).hide();
});

$('#EventEditForm, #EventAddForm').submit(function () {
 var allow_reload = confirm('Ar tikrai norite išsaugoti?');
 window.onbeforeunload = null;
 return allow_reload;
});


$('.patient-age-input').change(function(event) {

    if ($('#Patient0AgeYear').val() === '' && $('#Patient0AgeMonth').val() === '' && $('#Patient0AgeDay').val() === '')
        $(".patient_age_group option[value='unknown']").prop("selected","selected");
    else if($('#Patient0AgeYear').val()>=18)
        $(".patient_age_group option[value='adult']").prop("selected","selected");
    else if($('#Patient0AgeYear').val()<18)
        $(".patient_age_group option[value='child']").prop("selected","selected");

});


$('.related-events-toggle').click(function(event) {
    $('.events-related').toggle();
});


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


$('.add_substance').click(function(event) {
    console.log(event.target.href);
    $("#add_substance").modal({show:true,backdrop:'static'});
    $('#add_substance .modal-body').load( event.target.href, function() {
        $('.attach_substance').click( function(event) {
            if(!$(this).hasClass('disabled')) {
                $('.substances').append($('.select_substance:checked').next().find('input:checkbox').prop('checked','checked').parents('.formated_substances').removeClass('hide'));
                //console.log($('.select_substance:checked').find('.controls input:checkbox'));
                //$('.agents').append($('.select_substance:checked').siblings('.formated_agents').find('.controls input:checkbox').prop('checked','checked').parent());
                $('.agents').append($('.select_substance:checked').siblings('.agent_fields').find('input:checkbox').prop('checked','checked').end().show());
                $('.agents').append($('.select_agent:checked').next().find('input:checkbox').prop('checked','checked').parents('.agent_fields').show());
                $('.attach_substance').addClass('disabled');
                $('#add_substance').modal('hide');
            }
        });
    });

event.preventDefault();
});

removeCallFunc = function() {
    $('.remove-call').unbind().click(function(event){
        removeCall = $(this);
        $.post(removeCall.attr('href'),function(data){
            if(data.success)
                removeCall.parent().fadeOut("normal",function() { $(this).remove(); });
        });

        event.preventDefault();
    });
}

$('.add-call-btn').click(function(event) {

    $('#add_call .modal-body').load( event.target.href, function() {
        $('.call_row a').click( function() {
            window.open( $(this).attr('href') );
            return false;
        });


        $('.attach_call').click( function(event) {
            if(!$(this).hasClass('disabled')) {
                $('.calls-attached').append($(".select_call:checked").siblings('.call_fields').show());
                if($('#EventPhone').val().length == 0)
                    $('#EventPhone').val($(".select_call:checked").parents(".call_row").find(".call_number").text());
                removeCallFunc();
                $('#add_call').modal('hide');
            }
            event.preventDefault();
        });
    });
    $('#add_call').modal({show:true, backdrop:'static'});
    event.preventDefault();
});



$('#add_call').on('hidden', function(e) {
    if($(e.target).hasClass("modal")) {
        $(this).find('.modal-body').empty();
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

});

$('#add_substance').on('hidden', function(e) {
    if($(e.target).hasClass("modal")) {

        $('#add_substance textarea').each(function(event) {
            tinyMCE.execCommand('mceRemoveControl', false, this.id);
        });

        $(this).find('.modal-body').empty();
        $(this).find('.attach_substance').addClass('disabled');

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
            console.log(patient_weight);
            if(dose_units == 'mg/kg') {
                    //PRAILGINTI PRADŽIĄ ir ĮDĖTI GALĄ VISĄ TOKĮ PATĮ KAIP PRADŽIĄ
                }
            });
    }
});

    // *** SAVE DRAFT

    $('.save-draft').click(function(event) {
        $.post(baseUrl+'events/draft', $('#EventAddForm').serialize(), function(data, textStatus, xhr) {
            if(data.success) {
                console.log($('#EventAddForm').serialize());
            }
        });
        
       
    });
});
});
