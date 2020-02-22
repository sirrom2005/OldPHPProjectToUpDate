function priceOnly(e, decimal) 
{
	var key;
	var keychar;

	if (window.event) {
	   key = window.event.keyCode;
	}
	else if (e) {
	   key = e.which;
	}
	else {
	   return true;
	}
	keychar = String.fromCharCode(key);
	
	if ((key==null) || (key==0) || (key==8) ||  (key==9) || (key==13) || (key==27) ) {
	   return true;
	}
	else if ((("0123456789.").indexOf(keychar) > -1)) {
	   return true;
	}
	else if (decimal && (keychar == ".")) {
	  return true;
	}
	else
	   return false;
}

function numbersOnly(e, decimal) 
{
	var key;
	var keychar;

	if (window.event) {
	   key = window.event.keyCode;
	}
	else if (e) {
	   key = e.which;
	}
	else {
	   return true;
	}
	keychar = String.fromCharCode(key);
	
	if ((key==null) || (key==0) || (key==8) ||  (key==9) || (key==13) || (key==27) ) {
	   return true;
	}
	else if ((("0123456789-").indexOf(keychar) > -1)) {
	   return true;
	}
	else if (decimal && (keychar == ".")) {
	  return true;
	}
	else
	   return false;
}

function rTrim(sString)
{
	while (sString.substring(sString.length-1, sString.length) == ' ')
	{
	sString = sString.substring(0,sString.length-1);
	}
	return sString;
}
function lTrim(sString)
{
	while (sString.substring(0,1) == ' ')
	{
	sString = sString.substring(1, sString.length);
	}
	return sString;
}
function Trim( sString )
{
	return lTrim( rTrim(sString) );
}
function isEmpty( ele )
{
	ele = Trim(ele);
	if( ele == "" || ele == null )
		return true;	
	return false;
}
function isEmailValid(str) 
{
	var at="@"
	var dot="."
	var lat=str.indexOf(at)
	var lstr=str.length
	var ldot=str.indexOf(dot)
	if (str.indexOf(at)==-1){
	   //alert("Invalid E-mail ID")
	   return false
	}

	if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
	   //alert("Invalid E-mail ID")
	   return false
	}

	if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		//alert("Invalid E-mail ID")
		return false
	}

	 if (str.indexOf(at,(lat+1))!=-1){
		alert("Invalid E-mail ID")
		return false
	 }

	 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		//alert("Invalid E-mail ID")
		return false
	 }

	 if (str.indexOf(dot,(lat+2))==-1){
		//alert("Invalid E-mail ID")
		return false
	 }
	
	 if (str.indexOf(" ")!=-1){
		//alert("Invalid E-mail ID")
		return false
	 }

	 return true					
}

function buymp3(id)
{
	$.get("includes/ajax_buymp3.php",
		{id:id},
		function(data)
		{
			var str =  data;
			if(!isNaN(str))
			{
				$("#mycamount").html(str);
				$("#fbox").html("<h4 align='center'><b>Purchase complete<br>view your <a href='my_music.html'>libaray</a></b></h4>");
			}
			else
			{
				$("#fbox").html(str);
			}
		}
	)
}