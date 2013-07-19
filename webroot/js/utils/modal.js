define(["utils/getElement"],function(element){
	var get = function(options, callback){
		options.name = "modal";
		element.loadElement(options,function(data){
			$('body').append(data);
			$('.modal').modal('show').find('.modal-body').load(options.getUrl,callback);
		});
	};
	return {
		get:get
	};
});