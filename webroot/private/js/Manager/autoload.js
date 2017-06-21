$(function(){
	setInterval(function(){
		if($("#load_switch").prop('checked')) {
			setTimeout("location.reload()",30000);
		}
	},1000);
});
