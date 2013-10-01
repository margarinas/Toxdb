define(['jquery',"utils/autocomplete",'utils/addEditor',"utils/listGroups","utils/tableRow",'utils/pagination',"common",'bootstrap','utils/incrementInput'],function($,autocomplete,editor,listGroups,row,pagination){

    function init(options) {

        editor.init();
        listGroups.init();

        defaults = {container:"#container",redirectTo:"index",postCallback:null};
        var settings = $.extend(defaults, options);
        if(typeof tinyMCE !== "undefined") {
           $(settings.container +' textarea').each(function(event){
            tinyMCE.execCommand('mceRemoveEditor', false, this.id);
            tinyMCE.execCommand('mceAddEditor', false, this.id);
        });
       }

        $('#SubstanceAddForm').submit(function(event) {
            $('.substance_create textarea').each(function(event){
            tinyMCE.execCommand('mceRemoveEditor', false, this.id);

            });

            data = $(this).serialize();
            data = data + "&" + $.param({redirectTo:settings.redirectTo});
            url = $(this).attr('action');

            $.ajax({
                beforeSend:function (XMLHttpRequest) {
                    $("#busy-indicator").fadeIn();
                },
                complete:function (XMLHttpRequest, textStatus) {
                    $("#busy-indicator").fadeOut();
                    $(settings.container).parent().scrollTop(0);
                    init(settings);
                    if(typeof settings.postCallback === "function")
                        settings.postCallback(XMLHttpRequest);
                },
                success:function (data, textStatus) {
                    $(settings.container).html(data);

                },
                method:"post",
                data:data,
                url:url
            });

            $('.modal-body').scrollTop(0);
            $('.agent_search_results').empty();
            event.preventDefault();
        });

        autocomplete.init(".autocomplete");


        $('.substance_create .add_agent').click(function(event) {
            var num = $('.substance_create .agent').length;
            $('.substance_create .accordion-body').collapse('hide');


            tinyMCE.execCommand('mceFocus', false, 'Agent0Description');
            tinyMCE.execCommand('mceRemoveEditor', false, 'Agent0Description');

            var clonedAgent = $('.substance_create .agent').first().clone();

            clonedAgent.find('input:not(.clone-with-value), textarea').val(null).end()
            .find('label, input, a.accordion-toggle, div.accordion-body, textarea, select')
            .each(function(event) {
                incrementInput($(this),num);
            });

            $('.substance_create .agents').append(clonedAgent.find('.agent_remove').show().end());
            tinyMCE.execCommand('mceAddEditor', false, 'Agent0Description');
            tinyMCE.execCommand('mceAddEditor', false, 'Agent'+num+'Description');
            $('.substance_create .agent').last().find('.accordion-body').collapse('show');
            $('.substance_create .agent').last().find('.poison_subgroup').empty().hide();

            $('.substance_create .agent').last().find('.agent_remove').click(function(event) {
                $(this).parents('.agent').slideUp(200,function(){
                    tinyMCE.execCommand('mceRemoveEditor', false, $(this).find('textarea').attr('id'));
                    $(this).remove();
                });

            });
            listGroups.init();

        });

        $('.agent_remove').click(function(event) {
            $(this).parents('.agent').slideUp(200,function(){
                tinyMCE.execCommand('mceRemoveEditor', false, $(this).find('textarea').attr('id'));
                        // $.post(baseUrl+'substances/deleteAssocAgents',{'id':$(this).data('assoc-id')});
                        $(this).remove();
                    });
        });


        pagination.init({container:".agent_search_results",limit:10,history:false});
        $('.search_agent').click(function(event) {
            $('.agent_search_results').load(baseUrl+'agents/index/',{'term':$(this).prev().val(),'limit':10},function(){
                // if(settings.container !== ".modal-body")
                    row.init('.agent_row',".agent_search_results");
            });
            $('#agent_to_substance').show();
            $('.substance_create .accordion-body').collapse('hide');
        });
        $('#agent_to_substance').click(function(event) {
            $('.agents_attached').append($('.select_agent:checked').next().find('input:checkbox').prop('checked','checked').end().find('.agent_dose_field, .agent-main-group').remove().end().show());
            $('.agent_search_results').empty();
            $(this).hide();
        });

        var substance_agent_req_fields = $('#substance-add-agents [required="required"]');
        if($('#SubstanceNoagents').is(":checked")){
            substance_agent_req_fields.removeAttr('required');
        }
        $('#SubstanceNoagents').change(function(event) {
            $('#substance-add-agents').toggle();
            if($(this).is(":checked")) {
                substance_agent_req_fields.removeAttr('required');
            } else {
                substance_agent_req_fields.attr('required','required');
            }
        });


    }

    return {
        init:init
    };
});