<?php
include_once("classes/events.class.php");
$eventsObj 	  = new events();

$month 	= (!empty($_GET['month']))? $_GET['month'] : date('n');

function getEvents($date)
{ 
	if(empty($date)){ return false; }
	global $eventsObj;
	$rs  = $eventsObj->getEventsByDate($date);
	$str = "";
	if(!empty($rs))
	{ 
		foreach($rs as $row)
		{
			$formatDate = date("l, F d. Y", strtotime($date));
			$title 		= (!empty($row['title']))? $row['title'] : "" ;
			$altTitle 	= ucwords(strtolower($title));
			$id 		= (!empty($row['id']))? base64_encode($row['id']) : "#";
			$imgStr 	= (fileExists(EVENTS_IMG_PATH.$row['banner']))? "<br><a href='".EVENTS_IMG_URL.$row['banner']."' target='_blank' rel='#mies{$row['id']}'><img src='images/icon-photo.gif' alt='download $altTitle flyer' /></a><div class='simple_overlay' id='mies{$row['id']}'><img src='".EVENTS_IMG_URL.$row['banner']."' /></div>" : "";
			$str.="<div><a href='event.php?id=$id' title='$altTitle :: $formatDate' class='thickbox event' >".cleanString(substr($title,0,11))."</a>$imgStr</div>";
			
		}
		return $str;
	}
}

// get year, eg 2006
$year = date('Y');
// get month, eg 04
if( empty($_GET['month']) ){ $_GET['month'] = $month; }
// get day, eg 3
$day = date('j');
// get number of days in month, eg 28
$daysInMonth = date("t",mktime(0,0,0,$month,1,$year));
// get first day of the month, eg 4
$firstDay = date("w", mktime(0,0,0,$month,1,$year));
// calculate total spaces needed in array
$tempDays = $firstDay + $daysInMonth;
// calculate total rows needed
$weeksInMonth = ceil($tempDays/7);
$currentdate = date('F', mktime(0,0,0,$month,1,$year)).' '.$year; 
$today = date("Y-m-d");

$counter = 0;
for($j=0;$j<$weeksInMonth;$j++)
{
    for($i=0;$i<7;$i++) 
	{
        $counter++;
        $week[$j][$i] = $counter; 
		
		// offset the days
		$week[$j][$i] -= $firstDay;
		if (($week[$j][$i] < 1) || ($week[$j][$i] > $daysInMonth)) 
		{    
			$week[$j][$i] = NULL;
		}
    }
}

$nxtClick = ((int)$_GET['month'] < 12)? (int)$_GET['month']+1 : 1;
$preClick = ((int)$_GET['month'] > 1 )? (int)$_GET['month']-1 : 12;


########## SIDE BAR ##########
$currentdate 	= date('Y-m-d', mktime(0,0,0,$month,date('d'),date('Y')));

if( date("n") == date("n", strtotime($currentdate)) )
{
	$pastEvents 	= $eventsObj->getPastEvent($currentdate);
	$comingEvents 	= $eventsObj->getComingEvent($currentdate);
}
if( date("n", strtotime($currentdate)) > date("n") )
{
	$comingEvents 	= $eventsObj->getEventForThisMonth($month);
}
if( date("n", strtotime($currentdate)) < date("n") )
{
	$pastEvents 	= $eventsObj->getEventForThisMonth($month);
}

if(!empty($id))
{
	$rs = $eventsObj->getEventsById($id);
}
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
<style type="text/css" media="screen">
<!--
@import url("calender/css/styles.css");
-->
</style>
<h1>Party Calendar</h1>
<div id="event_list" >
	<h1>Events for <?php echo date("F", mktime(0,0,0,$month+1,0,0));?></h1>
	<?php
		if(!empty($pastEvents))
		{
			echo "<ul id='past'>";
			foreach($pastEvents as $row)
			{
	?>
			<li>
				<a href="event.php?id=<?php echo base64_encode($row['id']);?>" title="<?php echo strtolower($row['title']);?>"><?php echo $row['title'];?></a>
				<p><?php echo date("l, F. d Y.", strtotime($row['date']));?></p>
			</li>
	<?php
			}
			echo "</ul>";
		}
	?>
	<?php
		if(!empty($comingEvents))
		{
			echo "<ul id='coming'>";
			foreach($comingEvents as $row)
			{
	?>
			<li>
				<a href="event.php?id=<?php echo base64_encode($row['id']);?>" title="<?php echo strtolower($row['title']);?>"><?php echo $row['title'];?></a>
				<p><?php echo date("l, F. d Y", strtotime($row['date']));?></p>
			</li>
	<?php
			}
			echo "</ul>";
		}
		if( empty($comingEvents) && empty($pastEvents) )
		{
			echo "<h3>No events for this month.</h3>";
		}
	?>
	<div>
		<script type="text/javascript"><!--
		google_ad_client = "pub-7769573252573851";
		/* 200x90_link_ads */
		google_ad_slot = "4856914449";
		google_ad_width = 200;
		google_ad_height = 90;
		//-->
		</script>
		<script type="text/javascript"
		src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
	</div>
</div>
<div id="calender">
<form name="controls" id="controls">
<a href="events_calendar.html?month=<?php echo $preClick;?>">&laquo;&laquo;</a>
	<select name="month" onchange="submit();">
	<? for($i=1; $i<=12; $i++){ ?>
		<option value="<?=$i?>" <?=( $_GET['month']==$i )? "selected" : ""; ?> ><?=date('F', mktime(0,0,0,$i,1,0))?></option>
	<? } ?>
	</select>
	<a href="events_calendar.html?month=<?php echo $nxtClick;?>">&raquo;&raquo;</a>
</form> 
<ol>
	<li>Sunday</li>
	<li>Monday</li>
	<li>Tuesday</li>
	<li>Wednesday</li>
	<li>Thursday</li>
	<li>Friday</li>
	<li>Saturday</li>
</ol>
<div class="tads">
	<script type="text/javascript"><!--
	google_ad_client = "pub-7769573252573851";
	/* blog_468x15_ad_links */
	google_ad_slot = "0424525984";
	google_ad_width = 468;
	google_ad_height = 15;
	//-->
	</script>
	<script type="text/javascript"
	src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script>
</div>
<?php
$alternat = true;
foreach ($week as $key => $val) 
{ 
	
	$alternat = ($alternat)? false : true;
	$rowStyle = ($alternat)? "rowStyle1" : "rowStyle2";
	
	echo "<ul class='$rowStyle'>";
	foreach ($val as $key => $val) 
	{
		$day  		= (!empty($val))? "<span>$val</span>" : "" ;
		$date 		= (!empty($val))? date("Y-m-d", mktime(0,0,0,$month,$val,$year)) : "";
		$formatDate = date("l, F d. Y", strtotime($date));
		$thisDay 	= ($today==$date)? "todayStyle" : "";
		echo "<li align='center' class='weekday$key $thisDay'><a title='$formatDate'>$day</a><br>".getEvents($date)."</li>";
	}
	echo "</ul>";
}
?>
<div class="tads">
	<script type="text/javascript"><!--
	google_ad_client = "pub-7769573252573851";
	/* blog_468x15_ad_links */
	google_ad_slot = "0424525984";
	google_ad_width = 468;
	google_ad_height = 15;
	//-->
	</script>
	<script type="text/javascript"
	src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script>
</div>
</div>
<script>
// What is $(document).ready ? See: http://flowplayer.org/tools/using.html#document_ready
$(document).ready(function() 
	{
		$("a[rel]").overlay({expose: '#000', effect: 'apple'}); 
	}
);
</script>