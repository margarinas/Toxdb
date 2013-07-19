$(document).ready(function() {      // body...


    $('.substance_create .add_agent').click(function(event) {
        var num = $('.substance_create .agent').length;
        $('.substance_create .accordion-body').collapse('hide');


        tinyMCE.execCommand('mceFocus', false, 'Agent0Description');
        tinyMCE.execCommand('mceRemoveControl', false, 'Agent0Description');

        var clonedAgent = $('.substance_create .agent').first().clone();

        clonedAgent.find('input:not(.clone-with-value), textarea').val(null).end()
        .find('label, input, a.accordion-toggle, div.accordion-body, textarea, select')
        .each(function(event) {
            incrementInput($(this),num);
        });

        $('.substance_create .agents').append(clonedAgent.find('.agent_remove').show().end());
        tinyMCE.execCommand('mceAddControl', false, 'Agent0Description');
        tinyMCE.execCommand('mceAddControl', false, 'Agent'+num+'Description');
        $('.substance_create .agent').last().find('.accordion-body').collapse('show');
        $('.substance_create .agent').last().find('.poison_subgroup').empty().hide();

        $('.substance_create .agent').last().find('.agent_remove').click(function(event) {
            $(this).parents('.agent').slideUp(200,function(){
                tinyMCE.execCommand('mceRemoveControl', false, $(this).find('textarea').attr('id'));
                $(this).remove();
            });

        });
        $('.main_group').change(function(){
            subgroup = $(this).siblings('.poison_subgroup');
            $.post(baseUrl+'agents/findSubgroups',$(this).serialize(),function(data){
                if(data) {

                    subgroup.html(data).show();
                } else {
                    subgroup.empty().hide();
                }
            });
        //$('#AgentPoisonSubgroupId').load(baseUrl+'agents/findSubgroups','group_id='+$(this).val());
    });

    });

$('.agent_remove').click(function(event) {
    $(this).parents('.agent').slideUp(200,function(){
        tinyMCE.execCommand('mceRemoveControl', false, $(this).find('textarea').attr('id'));
                // $.post(baseUrl+'substances/deleteAssocAgents',{'id':$(this).data('assoc-id')});
                $(this).remove();
            });
});

$('.search_agent').click(function(event) {
    $('.agent_search_results').load(baseUrl+'agents/index/',{'term':$(this).prev().val()});
    $('#agent_to_substance').show();
    $('.substance_create .accordion-body').collapse('hide');
});
$('#agent_to_substance').click(function(event) {
    $('.agents_attached').append($('.select_agent:checked').next().find('input:checkbox').prop('checked','checked').end().find('.agent_dose_field, .agent-main-group').remove().end().show());
    $('.agent_search_results').empty();
    $(this).hide();
});

$('.substance_form_submit').click(function(event) {
    $('.agent_search_results').empty();
});

$('#SubstanceNoagents').change(function(event) {
    $('#agents_create').toggle();
});
    //console.log(tinyMCE);
    //if (tinyMCE != undefined) {
        //tinyMCE.add()
    //}
    $('.main_group').change(function(){
        subgroup = $(this).siblings('.poison_subgroup');
        $.post(baseUrl+'agents/findSubgroups',$(this).serialize(),function(data){
            if(data) {

                subgroup.html(data).show();
            } else {
                subgroup.empty().hide();
            }
        });
        //$('#AgentPoisonSubgroupId').load(baseUrl+'agents/findSubgroups','group_id='+$(this).val());
    });

});
