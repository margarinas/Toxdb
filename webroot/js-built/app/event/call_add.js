define(["jquery","utils/modal","utils/tableRow"],function(e,t,n){var r={getUrl:"calls",show:!0,id:"add_call",title:"Ieškoti konsultacijos įrašo",footer:'<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button><button class="btn btn-primary disabled attach_call">Priskirti įrašą</button>',onHide:function(){var t={};e(".attached-call-id").each(function(){value=e(this).val(),t[value]?e(this).parent().remove():t[value]=!0,console.log(e(this).val())}),e(".call_fields").each(function(t,n){e(n).find("input").incrementInput({num:t,separator:"%"})})}};removeCallFunc=function(){e(".remove-call").unbind().click(function(t){removeCall=e(this),e.post(removeCall.attr("href"),function(t){t.success&&removeCall.parent().fadeOut("normal",function(){e(this).remove()})}),t.preventDefault()})},e(".add-call-btn").click(function(i){t.set(r,function(){n.init("tr.call_row",".modal",function(){e(".attach_call").removeClass("disabled")}),e(".call_row a").click(function(){return window.open(e(this).attr("href")),!1}),e(".attach_call").click(function(t){e(this).hasClass("disabled")||(e(".calls-attached").append(e(".select_call:checked").siblings(".call_fields").show()),e("#EventPhone").val().length===0&&e("#EventPhone").val(e(".select_call:checked").parents(".call_row").find(".call_number").text()),removeCallFunc(),e("#add_call").modal("hide")),t.preventDefault()})}),i.preventDefault()})});