define(function() {
    var loadElement = function (props,callback) {
       $.ajax({
        url:baseUrl+"events/getElement",
        data:props,
        success: function(data) {
            callback(data);
        }
        });
   };
   return {
        loadElement:loadElement
   };

});