define(["utils/poisonAutocomplete","utils/modal","app/substance/actions","utils/getElement","app/event/report"],function(poisonAutocomplete,modal,actions,element,report) {
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

        $('.user-menu a').on('click',function(event){
            $("#busy-indicator").fadeIn();
            url = event.target.href;
            $("#container").load(url,function(){
                $("#busy-indicator").fadeOut();

                dest = url.split('/').pop();
                if(dest ==="report")
                    report.init();
                history.pushState(null,null,url);
            }) ;
            event.preventDefault();
        });

    }

    return {
        init:init
    };

});

