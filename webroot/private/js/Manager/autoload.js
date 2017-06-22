$(function(){
	setInterval(function(){
		if($("#load_switch").prop('checked')) {
			setTimeout("location.reload()",10000);
		}
	},1000);
});
