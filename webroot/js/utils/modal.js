define(["jquery"],function($){
	var set = function(options, callback){

		defaults = {content:'',show:false,id:'modal',title:'01',footer:'',data:null,onHide:null};

		if(typeof options === "string")
			options = {getUrl:options};

		var settings = $.extend(defaults, options);
		$('.modal').attr('id',settings.id);
		$('.modal-header h3').text(settings.title);
		$('.modal-footer').html(settings.footer);
		if(settings.show){
			$('.modal').modal({show:true,backdrop:'static'});
		}


		if(settings.getUrl) {
			$('#busy-indicator').fadeIn();
			$('.modal-body').load(baseUrl+settings.getUrl,settings.data,function(data){
				$('#busy-indicator').fadeOut();
				callback(data);
			});
		} else {
			if(settings.content) {
				$('.modal-body').append(settings.content);
			}
			callback();
		}
		


		$('.modal').on('hidden', function(e) {
			if($(e.target).hasClass("modal")) {
				if(typeof tinyMCE != 'undefined') {
					$('.modal-body textarea').each(function(event) {
						tinyMCE.execCommand('mceRemoveEditor', false, this.id);
					});
				}
				console.log(this);
				$(this).find('.modal-body').empty();
				$(this).find('.attach_substance').addClass('disabled');
				if(typeof settings.onHide === "function"){
					settings.onHide();
				}

			}
		});
		
	};
	return {
		set:set
	};
});