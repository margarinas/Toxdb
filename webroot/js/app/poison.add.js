define(["app/substance/add","app/agent/add","app/substance/actions","common","purl"],function(substances,agents,actions){

	poison = $.url().segment(-2);
	eval(poison).init();
	// substance.init();
	// agent.init();
	actions.init();
});