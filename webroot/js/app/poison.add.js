define(["app/substance/add","app/agent/add","app/substance/actions","common","purl"],function(substances,agents,actions){

	poison_url = $.url().attr("directory");
	poison = poison_url.split("/");
	console.log(poison.indexOf("substances"));
	if(poison.indexOf("substances")!==-1)
		substances.init();
	else if (poison.indexOf("agents") !==-1)
		agents.init();
	// substance.init();
	// agent.init();
	actions.init();
});