// JavaScript Document
function clearText(thefield)
{
	if(thefield.defaultValue==thefield.value)
	{
		thefield.value = "";
		thefield.className = "textBoxTextStyle";
	}	
}
function addtonewletter()
{
	var mail = document.newsletter.newsletteremail.value;
	$.get("http://127.0.0.1/v-up/doc_root/includes/ajax_addtonewsletter.php",
		{email:mail},
		function(data)
		{
			$("#nlspan").show(500).delay(4000);
			$("#nlspan").html(data);
			$("#nlspan").hide(500);
		}
	)	
}
if(document.getElementById("latestvid"))
{
	var fileref=document.createElement("link");
	fileref.setAttribute("rel", "stylesheet");
	fileref.setAttribute("type", "text/css");
	fileref.setAttribute("href", "doc_root/www/themes/default/css/home.css");
	document.getElementsByTagName("head")[0].appendChild(fileref);
}
$("#newsupdate").html("<p align='center'><a href=\"http://www.videouploader.net/vci\">VIDEOS NEEDED CLICK HERE TO UPLOAD.</a></p>");
/*$(document).ready(function() {
	// put all your jQuery goodness in here.
});*/