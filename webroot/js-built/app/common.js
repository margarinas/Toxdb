define(["jquery","utils/autocomplete","tinymce","bootstrap","jquery-ui","jquery-ui-timepicker","jquery-ui-datepicker-lt","jquery-ui-timepicker-lt"],function(e,t){e(".datetimepicker").datetimepicker(),e(".timepicker").timepicker(),e(".datepicker").datepicker(),e(".unknown_value").click(function(t){e(this).siblings("input").val("Nežinoma")}),e(".decimal_input").attr("step","0.001"),refreshScrollSpy=function(){e('[data-spy="scroll"]').each(function(){e(this).scrollspy("refresh")})},String.prototype.toDash=function(){return this.replace(/([A-Z])/g,function(e){return"-"+e.toLowerCase()})},t.init()});