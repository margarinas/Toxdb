define(["app/substance/actions","utils/pagination","purl"],function(actions,pagination){


	// poison_url = $.url().attr("directory");
	// poison = poison_url.split("/");
	// console.log(poison.indexOf("substances"));
	// if(poison.indexOf("substances")!==-1)
	// 	row.init(".substance_row");
	// else if (poison.indexOf("agents") !==-1)
	// 	row.init(".agent_row");
	// else if (poison.indexOf("antidotes") !==-1)
	// 	row.init(".antidote_row");
	
	
	//row.init("tr.antidote_row");
	actions.init();
	pagination.init();
});