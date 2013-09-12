define(function() {
  var loadElement = function (options,callback) {

    $.ajax({
      url:baseUrl+"getElement",
      data:options,
      success: function(data) {
        callback(data);
      }
    });
  };
  return {
    loadElement:loadElement
  };

});