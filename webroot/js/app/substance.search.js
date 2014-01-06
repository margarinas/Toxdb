define(["app/substance/search","app/substance/actions","purl"],function(search,actions){
	actions.init();
	var term = $.url().attr('query');
	search.init(term);
});