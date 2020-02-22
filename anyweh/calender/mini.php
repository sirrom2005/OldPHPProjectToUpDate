<?php
include_once("classes/events.class.php");
$eventsObj 	  = new events();

$month 	= (!empty($_GET['month']))? $_GET['month'] : date('n');
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

if(!empty($id))
{
	$rs = $eventsObj->getEventsById($id);
}
?>
<style type="text/css" media="screen">
#minicalender ul li a{font-weight:bold; padding-left:2px;}
#minicalender ul li.todayStyle a{color:#000000;}
#minicalender{font-family:Arial, Helvetica, sans-serif; width:300px; font-size:11px; padding:0;}
#minicalender ol li, #minicalender span{float:left; color:#FFFFFF; text-align:center; list-style:none; border:solid 1px #000000; border-bottom:0; background-color:#cc0000; margin:0 1px 0 0; padding:3px 0 3px 0; font-weight:bold; width:39px; }
#minicalender ul li{ float:left; height:33px; width:39px; margin:0 1px 1px 0; border:solid 1px #000000; }
#minicalender span{width:291px; display:block; float:none; margin:0 0 1px 0; border:solid 1px #000000;}
#minicalender ol{margin:0;}
#calender ul li.weekday0, #calender ul li.weekday6{ background-color:#cc0000; }
ul.rowStyle1 li{ background-color:#FFFFFF; }
ul.rowStyle2 li{ background-color:#FFFF99; }
</style>
<div id="minicalender">
<span>No upcoming events for <?php echo date("F");?></span>
<ol>
	<li>Sun</li>
	<li>Mon</li>
	<li>Tue</li>
	<li>Wed</li>
	<li>Thu</li>
	<li>Fri</li>
	<li>Sat</li>
</ol>
<?php
$alternat = true;
foreach ($week as $key => $val) 
{ 
	
	$alternat = ($alternat)? false : true;
	$rowStyle = ($alternat)? "rowStyle1" : "rowStyle2";
	
	echo "<ul class='$rowStyle'>";
	foreach ($val as $key => $val) 
	{
		$day  		= (!empty($val))? "$val" : "" ;
		$date 		= (!empty($val))? date("Y-m-d", mktime(0,0,0,$month,$val,$year)) : "";
		$formatDate = date("l, F d. Y", strtotime($date));
		$thisDay 	= ($today==$date)? "todayStyle" : "";
		echo "<li class='weekday$key $thisDay'><a title='$formatDate'>$day</a></li>";
	}
	echo "</ul>";
}
?>
<div class="clear"></div>
</div>