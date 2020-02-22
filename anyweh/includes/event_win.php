<?
	include_once("../config/global.php");
	include_once("../config/config.php");
	include_once("../classes/mySqlDB__.class.php" );
	include_once("../classes/events.class.php");
	
	$eventsObj 	= new events();	
	
	$id = $_GET['id'];
	if(!empty($id))
	{
		$rs = $eventsObj->getEventsById($id);
	} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Events Calendar :: <?=cleanString($rs['title'])?></title>
<style>
body, h1, h3{ margin:0; padding:0;}
h1{ font-size:18px; margin-bottom:10px; text-align:center; }
h3{ font-size:14px; margin-bottom:10px; }
</style>
</head>

<body>

<table border="0" width="100%" id="events">
<tr>
<td align="center" colspan="2">    
<script type="text/javascript"><!--
google_ad_client = "pub-7769573252573851";
/* wide_image_banner */
google_ad_slot = "7284682713";
google_ad_width = 468;
google_ad_height = 60;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</td>
</tr>
      <? if(fileExists(EVENTS_IMG_PATH.$rs['banner'])){ ?>
      <tr><td width="310" rowspan="2" align="center" valign="top"><img src="<?=EVENTS_IMG_URL."300_".$rs['banner']?>" width="300" title="<?=cleanString($rs['title'])?>" border="0" /></td></tr>
      <? } ?>
      <tr>
        <td valign="top">
			<h1><?=cleanString($rs['title'])?></h1>
            <h3><?=date("l. F d, Y", strtotime($rs['date']))?></h3>
            <div><?=cleanText($rs['intro_text'])?></div>
        </td>
      </tr>
</table>
</body>
</html>