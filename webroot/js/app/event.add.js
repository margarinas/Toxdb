define(['utils/addEditor',"common","utils/stopReload","lib/jquery.incrementInput",'app/event/substance_add','app/event/call_add',"app/event/antidote_add","app/event/related_event_add"], function(editor){


    editor.init();
    refreshScrollSpy();

    //row.init('tr.event_row');

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
        event_attr_section_link.insertAfter('.patient_section_link:last');
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




// *** SAVE DRAFT

$('.save-draft').click(function(event) {
    $.post(baseUrl+'events/draft', $('#EventAddForm').serialize(), function(data, textStatus, xhr) {
         console.log(xhr);
        if(textStatus === "success") {

            console.log(data);
        }
    });
    

});
});
