<?php
	include_once("classes/commonDB.class.php");
	
	$obj 	= new commonDB();	
	$id		= base64_decode($_GET['id']);
	$rs 	= $obj->getDataById( "events", $id );  
?>
<style>
/* the overlayed element */ 
.simple_overlay 
{ 
    /* must be initially hidden */ 
    display:none; 
    /* place overlay on top of other elements */ 
    z-index:10000; 
    /* styling */ 
    background-color:#333; 
    width:auto;      
    border:1px inset #cc0000; 
    /* CSS3 styling for latest browsers */ 
    -moz-box-shadow:0 0 90px 5px #000; 
    -webkit-box-shadow: 0 0 90px #000;     
} 
/* close button positioned on upper right corner */ 
.simple_overlay .close { 
    background-image:url(images/close.png); 
    position:absolute; 
    right:-15px; 
    top:-15px; 
    cursor:pointer; 
    height:35px; 
    width:35px; 
}
</style>
<!--[if lt IE 7]> 
<style>  
div.apple_overlay { 
    background-image:url(images/overlay_IE6.gif); 
    color:#fff; 
} 
 
/* default close button positioned on upper right corner */ 
div.apple_overlay div.close { 
    background-image:url(images/overlay_close_IE6.gif); 
 
}     
</style> 
<![endif]-->
<script language="javascript" src="js/jquery112.js"></script>
<h1><a href="events_calendar.html" title="return to anyweh.com events calendar">Event Calendar</a> &raquo; Event Information</h1>
<p><b><?php echo cleanString($rs['title']);?></b></p>
<p><b><?php echo date("l. F d, Y", strtotime($rs['date']))." ".$rs['time']; ?></b></p>
<p><b>Admission : <?php echo (empty($rs['admission']))? "Free" : $rs['admission'] ; ?></b></p>
<p><b>Venue : <?php echo cleanString($rs['Venue']);?></b></p>
<?php if(fileExists(EVENTS_IMG_PATH.$rs['banner'])){ ?>
<p><a href="<?php echo EVENTS_IMG_URL.$rs['banner']?>" rel="#mies1" target="_blank"><?php echo strtoupper("View ".cleanString($rs['title'])." Flyer...");?> </a></p>
<div class="simple_overlay" id="mies1"> 
    <img src="<?php echo "../images/events/".$rs['banner']?>" />  
</div> 
<?php } ?>
<?php echo cleanText($rs['description'])?>

<script>
// What is $(document).ready ? See: http://flowplayer.org/tools/using.html#document_ready
$(document).ready(function() 
	{
		$("a[rel]").overlay({expose: '#000', effect: 'apple'}); 
	}
);
</script>