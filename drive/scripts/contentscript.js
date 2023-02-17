var link = document.createElement("link");
    link.href = chrome.extension.getURL('css/style.css');
    link.type = "text/css";
    link.rel = "stylesheet";
    (document.head||document.documentElement).appendChild(link);
	
var script = document.createElement('script');
script.type = 'text/javascript';
script.src = chrome.extension.getURL("scripts/jquery.js");
document.head.appendChild(script);

var script = document.createElement('script');
script.type = 'text/javascript';
script.src = chrome.extension.getURL("scripts/localstoragedb.min.js");
document.head.appendChild(script);

var script = document.createElement('script');
script.type = 'text/javascript';
script.src = chrome.extension.getURL("scripts/a.js");
document.head.appendChild(script);