chrome.runtime.onMessage.addListener(function(msg, sender) {
    if(msg.method == "noti"){
		chrome.notifications.create('notification', msg.options, function() {});
	}
});