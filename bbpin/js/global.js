function rTrim(sString)
{
	while (sString.substring(sString.length-1, sString.length) == ' ')
	{sString = sString.substring(0,sString.length-1);}
	return sString;
}
function lTrim(sString)
{
	while (sString.substring(0,1) == ' ')
	{sString = sString.substring(1, sString.length);}
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
function setLang(id){
	location.href = "includes/ajx_setlang.php?l="+id;
}