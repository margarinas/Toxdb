define(["utils/poisonAutocomplete","utils/modal","app/substance/actions","utils/getElement","app/event/report","app/event/index","app/call/index","app/draft/index"],function(poisonAutocomplete,modal,actions,element,report,event,call,draft) {
    function init(options) {

        if(typeof options !== "object" && typeof options !== "undefined")
            throw new Error("Must provide options as an object");

        poisonAutocomplete.init("#SubstanceTerm");
        defaults = {container:"#container",history:true};
        var settings = $.extend(defaults, options);

        var add_substance_options = {
            show:true,id:'add_substance',
            title:"Ieškoti nuodingosios medžiagos",
            footer:'<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>'
        };

        var content;
        element.loadElement({name:'substance/actions'}, function(data) {

            content = data;

        });

        $('#SubstanceSearchForm').submit(function(event){
            modal.set(add_substance_options, function() {

                $('.modal-header').after($(content).addClass('margin10'));
                actions.init({
                    container:".modal-body",
                    rowLimit:7,
                    history:false,
                    searchCallback: function() {
                        $(".modal-body .actions").hide();
                    }
                });
                $('#add_substance').on('hidden', function(e) {
                    if($(e.target).hasClass("modal")) {
                        $('.modal .substance-actions').remove();
                    }
                });
            });
            event.preventDefault();
            return false;
        });
        var lastWeek = new Date();
        lastWeek.setDate(lastWeek.getDate()-7);
        lastWeek = $.datepicker.formatDate('yy-mm-dd', lastWeek);

        $('.event-list').load(baseUrl+'events/find/noSearchForm:1/event_per_page:5/current_user:1/created_from:'+lastWeek,function(){
            $('.event-select-collum, .event-user-collum').remove();
            $("#busy-indicator").fadeOut();
            event.init({
                container:".event-list",
                showPaginatorSummary:false,
                callback:function(){
                    $('.event-select-collum, .event-user-collum').remove();
                }
            });
        });

        $('.draft-list').load(baseUrl+'drafts/index/Event',function(){
            $("#busy-indicator").fadeOut();
            draft.init({
                container:".draft-list",
                showPaginatorSummary:false
            });
        });

        $('.user-menu a').on('click',function(event){
            $("#busy-indicator").fadeIn();
            $('.user-menu li').removeClass('active');
            $(this).parent().addClass('active');
            url = event.target.href;
            $("#container").load(url,function(){
                $("#busy-indicator").fadeOut();

                dest = url.split('/').pop();
                switch(dest) {
                    case "":
                        init();
                        break;
                    case "report":
                        report.init();
                        break;
                    case "calls":
                        call.init();
                }

                history.pushState(null,null,url);
            }) ;
            event.preventDefault();
        });

    }

    return {
        init:init
    };

});

