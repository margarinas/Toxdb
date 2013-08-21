define(['jquery',"utils/autocomplete",'utils/addEditor',"utils/listGroups","common",'bootstrap'],function($,autocomplete,editor,listGroups){

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

        $('#AgentAddForm').submit(function(event) {
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
            event.preventDefault();
        });

    autocomplete.init(".autocomplete");
    }

    return {
        init:init
    };
});