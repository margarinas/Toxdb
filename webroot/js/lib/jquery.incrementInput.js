define( ["jquery"], function( $ ){

	var methods = {
		init : function( options ) {

			var settings = $.extend({
				attributes:['id','name','for','href'],
				separator:'0',
				incrementStart:1
			},options);

			return this.each(function(index, value){
				var el = this;
				if(settings.num !== '')
					increment = settings.num;
				else
					increment = index+settings.incrementStart;
				$.each(settings.attributes, function(index,elValue){
					if($(el).attr(elValue)) {
						strArray = $(el).attr(elValue).split(settings.separator);

						if(strArray.length==2)
							$(el).attr(elValue,strArray[0]+increment+strArray.pop());
						else if(strArray.length>2) {
							if(settings.incrementPlace) {
								var newStr = '';
								$(strArray).each(function(index,value){

									if(index+1<strArray.length) {
										if(settings.incrementPlace-1 == index)
											current_separator = increment;
										else
											current_separator = settings.separator;
									}
									else
										current_separator = '';
									newStr = newStr+value+current_separator;
								});
								$(el).attr(elValue,newStr);
							} else {
								$(el).attr(elValue,strArray.join(settings.separator)+increment+strArray.pop());
							}
						}
					}
					if($(el).is("a"))
						$(el).text($(el).text().slice(0,-1)+(increment+1));
					if($(el).is('select'))
						$(el).find('option:selected').prop("selected", false);
					if($(el).is("input[type='checkbox'], input[type='radio']"))
						$(el).prop("checked", false);
					//console.log(increment);
				});
				//console.log(settings);
			});
		}
	};

	$.fn.incrementInput = function( method ) {

    // Method calling logic
    if ( methods[method] ) {
		return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
    } else if ( typeof method === 'object' || ! method ) {
		return methods.init.apply( this, arguments );
    } else {
		$.error( 'Method ' +  method + ' does not exist on jQuery.incrementInput' );
    }

};

});
