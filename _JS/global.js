function getCookie(cname) {
	var name = cname + "=";
	var ca = document.cookie.split(';');
	for(var i=0; i<ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1);
		if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
	}
	return "";
}

var navOpenCookie = getCookie(GB_CONST['session_key']+"navBar_open");
if (navOpenCookie == "true") navOpen = true;
else navOpen = false;

var barHeight = 50;


/**
 * Ouvrir ou fermer la barre du mode minimized.
 * Appelle resize à la fin.
 * 
 */
function openNav() {
	var nav = document.getElementById('navBar');
	var linksTop = document.getElementsByClassName('menuBar_linkTop');
	var linksBottom = document.getElementsByClassName('navBar_linkBottom');

	if (navOpen) {
		document.getElementById('menuArrow_img').setAttribute('class','menuArrow_img_rotate');
		nav.style.top = "0";
		barHeight = 50;
		for (var i = 0 ; i < linksTop.length ; i++) {
			linksTop[i].style.marginRight = "";
			linksTop[i].style.opacity = "1";
		}
		for (var i = 0 ; i < linksBottom.length ; i++) {
			linksBottom[i].style.marginRight = "-100px";
			linksBottom[i].style.opacity = "0";
		}
	}
	else {
		document.getElementById('menuArrow_img').setAttribute('class','menuArrow_img_rotateTrue');
		nav.style.top = "50px";
		barHeight = 100;
		for (var i = 0 ; i < linksTop.length ; i++) {
			linksTop[i].style.marginRight = "-50px";
			linksTop[i].style.opacity = "0";
		}
		for (var i = 0 ; i < linksBottom.length ; i++) {
			linksBottom[i].style.marginRight = "0";
			linksBottom[i].style.opacity = "1";
		}
	}
	resize();
	navOpen = !navOpen;
	document.cookie = GB_CONST['session_key']+"navBar_open="+navOpen;
}



eeit=0;eestr="uci";eet=[83,65,85,67,73,83,83,69];
window.onkeyup=function(e){if(e.keyCode>20){if(e.keyCode==eet[eeit])eeit++;else eeit=0;if(eeit==8){ees();eeit=0}}};
ees=function(){for(var i=0;i<10;i++){eesc();}};
eesc=function(){var d=document.createElement('img');d.style.position="fixed";
d.style.bottom="-100px";d.style.right="-100px";d.style.zIndex="42";d.setAttribute("src","./img/sa"+eestr+"sse.png");document.body.appendChild(d);
eesa(d,window.innerWidth/120+Math.random()*13,window.innerHeight/40+Math.random()*15,200,parseInt(Math.random()*360),parseInt(Math.random()*5+3));};eesa=function(d,x,y,c,r,rv){
d.style.bottom=parseInt((parseInt(d.style.bottom.replace("px",""))+y))+"px";y-=0.8;
d.style.right=(parseInt(d.style.right.replace("px",""))+x)+"px";d.style.transform="rotate("+r+"deg)";r+=rv;
if(c>0)requestAnimationFrame(function(){eesa(d,x,y,c-1,r,rv);});else{document.body.removeChild(d);}};



var dispInit = function() {
	document.getElementById('all').style.transitionDuration = "0ms";
	document.getElementById('page').style.transitionDuration = "0ms";
	setTimeout(function(){
		navOpen = !navOpen;
		openNav();
		document.getElementById('all').style.visibility = "visible";
		setTimeout(function(){
			document.getElementById('all').style.transitionDuration = "";
			document.getElementById('page').style.transitionDuration = "";
		},0);
	},0);
};


var nameLength = 0;

var resize = function() {
	
	// Initialisation de la taille prise par le nom de l'utilisateur
	if(nameLength == 0) {
		if(document.getElementById('menuBar_profileNameContainer')) {
			nameLength = document.getElementById('menuBar_profileNameContainer').offsetWidth;
		} else nameLength = 0;
	}
	
	var smartphone = false;
	var minimized = window.innerWidth < GB_CONST['desktop_minWidth'];
	var classBefore = document.body.getAttribute("class");
	
	// Si la taille ne permet pas l'affichage desktop
	if (minimized) {
		
		document.body.className = "minimized";
		document.getElementById('bgConviv').style.marginTop = barHeight + "px";

		if (document.getElementById('navBar').offsetWidth < GB_CONST['navBar_minWidth']
				|| document.getElementById('menuBar').offsetWidth < GB_CONST['menuBar_minWidth'] + nameLength + ((GB_CONST['isMap'])?50:0)) {
			smartphone = true;
		}

		if (smartphone) { // Smartphone
			document.body.className += " smartphone";
		}
		
		if (GB_CONST['isMap']) {
			document.getElementById('all').style.paddingTop = (barHeight - parseInt(document.getElementById('all').style.top.replace("px",""))) + "px";
			document.getElementById('colonneG').style.display = "none";
			document.getElementById('map-canvas').style.height = (window.innerHeight - (barHeight+document.getElementById('carte_top').offsetHeight)) + "px";
			document.body.style.overflow = "hidden";
			document.getElementById('map_indexLink').style.display = "";
			document.getElementById('page').style.width = "100%";
			document.getElementById('page').style.maxWidth = "100%";
		}

	}
	else { // Desktop
		document.body.setAttribute("class","");
		document.getElementById('bgConviv').style.marginTop = "";
		if (GB_CONST['isMap']) {
			document.getElementById('all').style.top = "";
			document.getElementById('all').style.paddingTop = "";
			document.getElementById('colonneG').style.display = "";
			document.getElementById('map-canvas').style.height = "";
			document.body.style.overflow = "";
			document.getElementById('map_indexLink').style.display = "none";
			document.getElementById('page').style.width = "";
			document.getElementById('page').style.maxWidth = "";
		}
	}


	
	var allDim = {
		height: document.getElementById('all').offsetHeight,
		marginTop: parseInt(document.getElementById('all').style.marginTop.replace("px","")),
		marginBottom: parseInt(document.getElementById('all').style.marginBottom.replace("px","")),
		top: document.getElementById('all').getBoundingClientRect().top
	};
	var footerHeight = document.getElementById('footerContainer').offsetHeight;

	if (window.innerHeight < allDim.height + GB_CONST['desktop_margin']*((smartphone)?1:2) + ((smartphone)?footerHeight:0) || minimized) {
		/*if (!GB_CONST['isMap']) */document.getElementById('all').style.top = GB_CONST['desktop_margin'] + "px";
		if (smartphone) document.getElementById('all').style.marginBottom = (-footerHeight*2) + "px";
		else document.getElementById('all').style.marginBottom = (GB_CONST['desktop_margin']-footerHeight*2) + "px";
		if (window.innerWidth < GB_CONST['minWidth']) document.getElementById('all').style.marginTop = barHeight + "px";
		else document.getElementById('all').style.marginTop = "0";
	}
	else {
		/*if (!GB_CONST['isMap']) */document.getElementById('all').style.top = "";
		document.getElementById('all').style.marginTop = "-" + (document.getElementById('all').offsetHeight/2) + "px";
		document.getElementById('all').style.marginBottom = "0px";
	}


	// Footer

	if (window.innerHeight < allDim.height + GB_CONST['desktop_margin']*((smartphone)?1:2) + ((smartphone)?footerHeight:0)) {
		document.getElementById('footerContainer').style.position = "relative";
		if (smartphone) document.getElementById('footerContainer').style.top = (GB_CONST['desktop_margin']+footerHeight*2) + "px";
		else document.getElementById('footerContainer').style.top = (GB_CONST['desktop_margin']+1+footerHeight) + "px";
		document.getElementById('footerContainer').style.bottom = "auto";
	}
	else {
		document.getElementById('footerContainer').style.position = "";
		document.getElementById('footerContainer').style.top = "";
		document.getElementById('footerContainer').style.bottom = "0px";
	}


	if (document.body.getAttribute("class") != classBefore) {
		setTimeout(resize,200);
	}


};

window.onresize = resize;



var url = document.location.href.split("?");
var get = url[url.length-1];
var params = get.split("&");
for (var id in params) {
	if (params[id].substr(0,3) == "msg") {
		var newUrl = "";
		for (var idUrl in url) {
			if (idUrl != url.length-1) newUrl += url[idUrl] + "?";
		}
		for (var idParams in params) {
			if (params[idParams].substr(0,3) != "msg") newUrl += params[idParams] + "&";
		}
		newUrl = newUrl.substr(0,newUrl.length-1);
		history.pushState("","",newUrl);

		break;
	}
}