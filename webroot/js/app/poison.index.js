define(["app/substance/actions","utils/tableRow","utils/pagination","common"],function(actions,row,pagination){
	row.init("tr.agent_row");
	row.init("tr.substance_row");
	row.init("tr.antidote_row");
	actions.init();
	pagination.init();
});