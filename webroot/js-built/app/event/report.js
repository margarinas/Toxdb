define(["common"],function(){function e(){$(".report_date").datepicker(),$("#EventReportForm").submit(function(t){url=$(this).attr("action"),data=$(this).serialize(),$("#busy-indicator").fadeIn(),$.post(url,data,function(t){$("#container").html(t),$("#busy-indicator").fadeOut(),e()}),t.preventDefault()})}return{init:e}});