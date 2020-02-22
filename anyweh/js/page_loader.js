// JavaScript Document
var d = document;

var xmlHttp = null;
var pageId	= null;
var nTimer	= null;


function writePageData()
{ 
	if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		if( document.getElementById("loadingScreen") )
		{
			document.getElementById("loadingScreen").style.display = "none"; 
		}

		document.getElementById(pageId).innerHTML = xmlHttp.responseText; 
		
		/*var frm = document.newsletter;
		frm.email.value = "";
		nTimer = setInterval("clearNewsLetterText()", 2500);*/
	}
}

function clearNewsLetterText()
{
	document.getElementById("newsLetterMsg").innerHTML = "";
	clearInterval(nTimer);
	nTimer = null;
}

function GetXmlHttpObject()
{ 
	var objXMLHttp = null;
	if (window.XMLHttpRequest)
	{
		objXMLHttp = new XMLHttpRequest();
	}
	else if (window.ActiveXObject)
	{
		objXMLHttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	return objXMLHttp;
}  


function getPage( url, pageId )
{ 
	if( document.getElementById("loadingScreen") )
	{
		document.getElementById("loadingScreen").style.display = "inline"; 
	}
	xmlHttp = GetXmlHttpObject();
	
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	}
	
	this.pageId = pageId;

	var urlLoc = url+"&amp;sisId=" + Math.random();
	xmlHttp.onreadystatechange=writePageData;
	xmlHttp.open("POST",urlLoc,true);
	xmlHttp.send(null);
}