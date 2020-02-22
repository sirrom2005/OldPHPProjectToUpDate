<?php
	$month 	= (!empty($_GET['month']))? $_GET['month'] : date('n');
	$cacheHTML="cache/events$month.html";
	//if( file_exists($cacheHTML) ){ include($cacheHTML); exit(); }

	header("Vary: Accept-Encoding");
	if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip'))
	ob_start('ob_gzhandler');
	else ob_start();
	
	include_once("config/global.php");
	include_once("config/config.php");
	include_once("classes/mySqlDB__.class.php" );
	include_once("classes/events.class.php");
	include_once("classes/blog.class.php");
	include_once("classes/banner.class.php");
	
	$blogObj 	  = new blog();
	$eventsObj 	  = new events();	
	$bannerObj 	  = new banner();
	
	$currentdate 	= date('Y-m-d', mktime(0,0,0,$month,date('d'),date('Y')));

	$eventReview 	= $blogObj->getEventReview();
	
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
	


	
	if(!empty($_GET['id']))
	{
		$id = $_GET['id'];
	}
	
	if(!empty($id))
	{
		$rs = $eventsObj->getEventsById($id);
	} 
    
    $meta_content = ( !empty($rs['intro_text']) )? cleanString($rs['intro_text']) : "The event page, events calendar, event calendar, sessions, party calendar";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="Author" content="Rohan (Iceman) Morris : sirrom2005@gmail.com" />
<meta name="sitename" content="www.anyweh.com" />
<meta name="copyright" content="Anyweh.com <?php echo date("Y"); ?>" />
<meta name="language" content="en" />
<meta http-equiv="keywords" name="keywords" content="anyweh, events, calender, events calendar, event calendar, party, parties, goout, club, dance, sessions, party calendar, ati, ATI, RTI, rti, dream team, dream weekend" />
<meta http-equiv="description" name="description" content="Jamaica's ultimate party and events calendar, dream team" />
<link rel="alternate" type="application/rss+xml" title="www.anyweh.com blog rss feed" href="http://feeds.feedburner.com/AnywehcomBlog" />
<link rel="alternate" type="application/rss+xml" title="www.anyweh.com photo gallery rss feed" href="http://feeds.feedburner.com/AnywehcomPhotoGallery" />
<link rel="alternate" type="application/rss+xml" title="www.anyweh.com comment rss feed" href="<?php echo DOMAIN; ?>blog/comments/feed" />
<title>Jamaica's ultimate party and events calendar : www.anyweh.com </title>
<style type="text/css" media="screen">
<!--
@import url("css/layout_styles.css");
@import url("calender/css/styles.css");
-->
</style>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">jQuery.noConflict();</script>
<script type="text/javascript" src="js/thickbox.js"></script>
<link rel="stylesheet" href="css/thickbox.css" type="text/css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/slideshow.css" media="screen" />
</head>
<body>
    <div id="container"> 
    	<? include_once("includes/menu.php"); ?>
        <div id="h_main">
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
                            <a href="includes/event_win.php?id=<?php echo $row['id'];?>" class="thickbox" title="<?php echo strtolower($row['title']);?>"><?php echo $row['title'];?></a>
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
                            <a href="includes/event_win.php?id=<?php echo $row['id'];?>" class="thickbox" title="<?php echo strtolower($row['title']);?>"><?php echo $row['title'];?></a>
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
					/* 200x200_image_ads */
					google_ad_slot = "9205053553";
					google_ad_width = 200;
					google_ad_height = 200;
					//-->
					</script>
					<script type="text/javascript"
					src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
					</script>
                </div>
                <div style="margin:2px 0 5px 0;">
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
        	<? include_once("calender/index.php"); ?>
            <div id="pageAds">
				<script type="text/javascript"><!--
                google_ad_client = "pub-7769573252573851";
                /* 120x600_image_ads */
                google_ad_slot = "8476924370";
                google_ad_width = 120;
                google_ad_height = 600;
                //-->
                </script>
                <script type="text/javascript"
                src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
                </script>
            </div>
            <script type="text/javascript" src="images/ads/page_ads.js"></script>
            <div class="clear"></div>
        	<div id="bottom_events"><? include_once("includes/bottom_events.php"); ?></div>
        </div>
        <? include_once("includes/footer.php"); ?>
    </div>
</body>
<?php include_once("includes/bottom.php"); ?>

</html>
<?php
	$fp=fopen($cacheHTML,'w'); 
	$cachecontents=ob_get_contents();
	fwrite($fp,$cachecontents);
	fclose($fp);
	ob_end_flush();
?>