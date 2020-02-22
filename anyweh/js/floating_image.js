/*
Floating image II (up down)- Bruce Anderson (http://appletlib.tripod.com)
Submitted to Dynamicdrive.com to feature script in archive
Modified by DD for script to function in NS6
For 100's of FREE DHTML scripts, Visit http://www.dynamicdrive.com
*/

var XX=10; // X position of the scrolling objects
var xstep=1;
var delay_time=60;

//Begin of the unchangable area, please do not modify this area
var YY=0;  
var ch=0;
var oh=0;
var yon=0;

var ns4=document.layers?1:0
var ie=document.all?1:0
var ns6=document.getElementById&&!document.all?1:0

if(ie){
	//YY=document.body.clientHeight;
	floater_ads.style.top=YY + "px";
}
else if (ns4){
	//YY=window.innerHeight;
	document.floater_ads.pageY=YY + "px";
	document.floater_ads.visibility="hidden";
}
else if (ns6){
	//YY=window.innerHeight;
	document.getElementById('floater_ads').style.top=YY + "px";
}


function reloc1()
{
	if(yon==0){YY=YY-xstep;}
	else{YY=YY+xstep;}
	if (ie){
	ch=document.documentElement.clientHeight;
	oh=floater_ads.offsetHeight;
	}
	else if (ns4){
	ch=window.innerHeight;
	oh=document.floater_ads.clip.height;
	}
	else if (ns6){
	ch=window.innerHeight
	oh=document.getElementById("floater_ads").offsetHeight
	}
			
	if(YY<0){yon=1;YY=0;}
	if(YY>=(ch-oh)){yon=0;YY=(ch-oh);}
	if(ie){
	floater_ads.style.left=XX + "px";
	floater_ads.style.top=YY+document.documentElement.scrollTop;
	}
	else if (ns4){
	document.floater_ads.pageX=XX + "px";
	document.floater_ads.pageY=YY+window.pageYOffset + "px";
	}
	else if (ns6){
	document.getElementById("floater_ads").style.left=XX + "px";
	document.getElementById("floater_ads").style.top=YY+window.pageYOffset + "px";
	}
}
function onad()
{
	if(ns4)
	document.floater_ads.visibility="visible";
	loopfunc();
}
function loopfunc()
{
	reloc1();
	setTimeout('loopfunc()',delay_time);
}
if (ie||ns4||ns6){ onad(); }
//if (ie||ns4||ns6){ window.onload=onad }