window.onload = resizeall;
window.onresize = resizeall;

var url = location.href;
var decoupe = url.match(/\/([^\/]*)(?=\.php)/);

function resizeindex(){
	var menu = document.getElementById('menu');
	var photoarea = document.getElementById('photoarea');
	var largeur = window.innerWidth;

	if (largeur < 1024){
		menu.style.display = "none";
		// photoarea.style.display = "block";
		// photoarea.style.marginLeft = "15%";
		// photoarea.style.position = "absolute";
	}
	else{
		// photoarea.style.position = "fixed";
		// photoarea.style.display = " inline-block";
		// photoarea.style.marginLeft = " 2%";
		menu.style.display = "inline-block";
	}
}

function resizeall(){
	if (decoupe[1] == "index")
		resizeindex();
	// if (decoupe[1] == "cam")
	// {
	// 	cam();
	// }
	var menuicon = document.getElementById('menuicon');
	var homeicon = document.getElementById('homeicon');
	var faqicon = document.getElementById('faqicon');
	var loginicon = document.getElementById('loginicon');
	var searchicon = document.getElementById('searchicon');
	var largeur = window.innerWidth;

	if (largeur < 1024){
		homeicon.style.display="none";
		faqicon.style.display="none";
		searchicon.style.display="none";
		loginicon.style.display="none";
		menuicon.style.display="inline-block";
	}
	else{
		menuicon.style.display="none";
		homeicon.style.display="inline-block";
		faqicon.style.display="inline-block";
		searchicon.style.display="inline-block";
		loginicon.style.display="inline-block";
	}
}
