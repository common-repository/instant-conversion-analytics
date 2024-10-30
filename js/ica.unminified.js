/*
Instant Conversion Analytics
Updated in Version 1.3.2
*/
function ica_go(){
	function ica_get(name) {
		return (document.cookie.match('(?:^|;)\\s*'+name.trim()+'\\s*=\\s*([^;]*?)\\s*(?:;|$)')||[])[1];
	}
	function ica_mobile() {
		try{
			document.createEvent("TouchEvent");
			if(screen.width < 1024){return 'm';}
		else{return 't';}
		}
		catch(e){return 'd';}
	}
	var ica_time = Math.round(+new Date()/1000);
	var ica_last = window.location.href.substring(window.location.origin.length);
	var ica_ssl = ('https:' == document.location.protocol ? ';secure' : '');
	//Test if cookie exists if not set it
	if(typeof ica_get("ica") === "undefined"){
		var ica_referrer = document.referrer;
		var ica_mobile = ica_mobile();
		//Set the Cookie
		document.cookie="ica=|" + ica_time + "|" + ica_referrer + "|" + ica_mobile + "|~|" + ica_last + ";path=/;samesite=strict" + ica_ssl;
		//console.log('cookie set: '+ica_get("ica"));
	}else{
		var ica = ica_get("ica");
		if(ica.length > 2500){
			//Check if cookie length is getting to long
			ica = ica.substr(0, ica.lastIndexOf('|') + 1);
		}
		ica = ica.substr(ica.indexOf('|')+1);
		//Update the Cookie
		document.cookie="ica=" + ica_time + '|' + ica + '|' + ica_last + ";path=/;samesite=strict" + ica_ssl;
		//console.log('cookie updated: ' + ica_get("ica"));
	}
}
setTimeout(ica_go, 0);