jQuery(document).ready(function($) {

function tabpdu1(argument) {
	$.ajax({
		type: "POST",
		url: url_ajax_load1,
		data:{},
		dataType: 'json',
		beforeSend: function () {
			$(".loaderpdu").show();
		},
		success: function (response) {
			$(".loaderpdu").hide();
		$.each(response, function(k, v) {
			if(v == 0){
				$("#"+k).hide();
			}else{
				$("#"+k+" strong").text(v);
			}
		});

		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr);
			console.log(thrownError);
		}
		});
};
tabpdu1();

$(".reload_tabpdu1").click(function(event) {
	tabpdu1();
});
setInterval(function(){
	tabpdu1();
},60000)
});