define(["jquery","utils/autocomplete","utils/addEditor","utils/listGroups","bootstrap"],function(e,t,n,r){function i(s){n.init(),r.init(),defaults={container:"#container",redirectTo:"index",postCallback:null};var o=e.extend(defaults,s);typeof tinyMCE!="undefined"&&e(o.container+" textarea").each(function(e){tinyMCE.execCommand("mceRemoveEditor",!1,this.id),tinyMCE.execCommand("mceAddEditor",!1,this.id)}),e("#AgentAddForm").submit(function(t){e(".substance_create textarea").each(function(e){tinyMCE.execCommand("mceRemoveEditor",!1,this.id)}),data=e(this).serialize(),data=data+"&"+e.param({redirectTo:o.redirectTo}),url=e(this).attr("action"),e.ajax({beforeSend:function(t){e("#busy-indicator").fadeIn()},complete:function(t,n){e("#busy-indicator").fadeOut(),e(o.container).parent().scrollTop(0),i(o),typeof o.postCallback=="function"&&o.postCallback(t)},success:function(t,n){e(o.container).html(t)},method:"post",data:data,url:url}),e(".modal-body").scrollTop(0),t.preventDefault()}),t.init(".autocomplete")}return{init:i}});