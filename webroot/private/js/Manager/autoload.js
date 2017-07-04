$(function(){
	var url = location.href;
	setInterval(function(){
		if($("#load_switch").prop('checked')) {
			if (!(url.indexOf('autoload=') != -1)) {
				if (url.indexOf('?') != -1) {
					location = url + '&autoload=1';
				} else {
					location = url + '?autoload=1';
				}
			}
			setTimeout("location.reload()",10000);
		} else {
			if (url.indexOf('autoload') != -1) {
				if (url.indexOf('&') != -1) {
					url = url.replace('autoload=1', '');
					location = url.replace('&', '');
				} else {
					location = url.replace('?autoload=1', '');
				}
			}
		}
	},1000);
});
