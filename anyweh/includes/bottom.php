<script type="text/javascript">a2a_linkname="wwww.anyweh.com";a2a_linkurl="<?php echo "http://www.anyweh.com".$_SERVER['REQUEST_URI']; ?>";a2a_onclick=1;a2a_show_title=1;a2a_hide_embeds=0;</script>
<script type="text/javascript" src="http://static.addtoany.com/menu/page.js"></script>

<script language="javascript">
	function getCookie(c_name)
	{
		if (document.cookie.length>0)
		  {
		  c_start=document.cookie.indexOf(c_name + "=");
		  if (c_start!=-1)
			{
			c_start=c_start + c_name.length+1;
			c_end=document.cookie.indexOf(";",c_start);
			if (c_end==-1) c_end=document.cookie.length;
			return unescape(document.cookie.substring(c_start,c_end));
			}
		  }
		return "";
	}
	
	function setCookie(c_name,value,expiredays)
	{
		var exdate=new Date();
		exdate.setDate(exdate.getDate()+expiredays);
		document.cookie=c_name+ "=" +escape(value)+
		((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
	}

	var cplayer = getCookie('playerr');
	
	if(cplayer==null || cplayer=="")
	{
		window.open('http://www.anyweh.com/audio_player.php', 'audio_player', 'width=470, height=335');
		setCookie('playerr','open_player',1);
	}
</script>	

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-5576813-1");
pageTracker._trackPageview();
} catch(err) {}</script>