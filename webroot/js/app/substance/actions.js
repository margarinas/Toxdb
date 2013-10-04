define(["utils/poisonAutocomplete","app/substance/add","app/agent/add","utils/pagination","app/substance/search","utils/tableRow"],function(autocomplete,substance,agent,pagination,search,row){

	init = function (options) {

		if(typeof options !== "object" && typeof options !== "undefined")
			throw new Error("Must provide options as an object");
		defaults = {
			container:"#container",
			rowLimit:20,
			history:true,
			attachTo:null,
			searchCallback:function(){},
			rowClickCallback:function(){}
		};
		var settings = $.extend(defaults, options);

		autocomplete.init('#SubstanceTerm');
		
		$("#search_db").click(function(event) {
			$("#toxinz_term").val($("#SubstanceTerm").val());
			$("#toxinz_form").submit();
			window.open('http://www.toxbase.org/Basic-search/?quicksearchquery='+$("#SubstanceTerm").val(), '_blank');

		});

		$("#SubstanceSearchForm").submit(function (e) {
			
			$(settings.container).html('<div class="row-fluid"><div class="span6"><h4>Produktai</h4><div id="substances"></div></div><div class="span6"><h4>Medžiagos</h4><div id="agents"></div></div></div>');
			row.init('.agent_row',settings.container,settings.rowClickCallback);
			row.init('.substance_row',settings.container,settings.rowClickCallback);
			data = $(this).serialize();

			query = {limit:settings.rowLimit,attachTo:settings.attachTo};
			data = data + "&" + $.param(query);
			url = $(this).attr('action')+"?"+data;

			search.init(data,function(){
				settings.searchCallback();
				pagination.init({
					container:"#substances",
					history:settings.history,
					limit:settings.rowLimit,
					callback:settings.searchCallback
					
				});

				pagination.init({
					container:"#agents",
					history:settings.history,
					limit:settings.rowLimit,
					callback:settings.searchCallback

				});
			});
			if(settings.history)
				history.pushState(null, null, url);

			e.preventDefault();
			
		});

		$("#add-new-substance").click(function (e) {
			url = e.target.href;
			$("#busy-indicator").fadeIn();
			$(settings.container).load(url,$.param({attachTo:settings.attachTo}), function() {

				substance.init({container:settings.container,redirectTo:"dashboard"});
				$("#busy-indicator").fadeOut();
				if(settings.history)
					history.pushState(null, null, url);
			});
			e.preventDefault();
		});

		$("#add-new-agent").click(function (e) {
			url = e.target.href;
			$("#busy-indicator").fadeIn();
			$(settings.container).load(url,$.param({attachTo:settings.attachTo}), function(){
				agent.init({container:settings.container,redirectTo:"dashboard"});
				$("#busy-indicator").fadeOut();
				if(settings.history)
					history.pushState(null, null, url);
			});
			e.preventDefault();
		});


	};

	return {init:init};
	

});