<?php
	include_once("config/config.php");
	include_once("classes/mySqlDB__.class.php");
	include_once("classes/software.class.php");
	include_once("classes/pagination.class.php");
	include_once("classes/commonDB.class.php");
	
	$obj 	= new software();
	$comObj = new commonDB();
	
	$latestSoftware 	= $obj->getLatestSoftware(11);
	$featuredSoftware 	= $obj->featuredSoftware(3);
	$category 			= $obj->getCategory(12);
	$newsCategory 		= $obj->getNewsCategory(8);
	//$latestReviews 		= $obj->getLatestReviews(5);	
	###########BANNER###########
	$leaderboard 	= $obj->getPageBanner(1, 2);
	$medRectangle 	= $obj->getPageBanner(2, 1);
	$tinyAds		= $obj->getPageBanner(3, 6);
	
	$userName = (empty($_SESSION['account_user']))? "Welcome, Guest! Please <a href='registration.html'>register</a> or login" : "<h2>Welcome, ".ucfirst(strtolower($_SESSION['account_user']['user_name']))."!</h2><p>Last login on: ".date("l, M. d Y", strtotime($_SESSION['account_user']['last_login_date']))."</p><p><a href='".DOMAIN."logout.php'>Logout</a></p><p><a href='".DOMAIN."change_password.html'>Change Password</a></p>";
	if( !empty($_SESSION['account_user']) ){ logMemberActions(); }
	
	if($_POST['news_letter_email'])
	{ 
		$_POST['news_letter_email'] = trim($_POST['news_letter_email']);

		if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_POST['news_letter_email'])) 
		{
			$newsLetterMsg = "<font style='color:#c00;'>Invalid email address.</font>";
		}
		else
		{
			if($obj->addToNewsLetter($_POST['news_letter_email'])){ $newsLetterMsg = "Email added to newsletter."; }
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="<?php echo $META_DESC;?>" />
	<meta name="keywords" content="<?php echo $META_KEY;?>" />
	<meta name="author" content="Rohan (Iceman) Morris" />
	<meta name="sitename" content="downloadhours.com" />
	<meta name="copyright" content="<?php echo date("Y"); ?>" />
	<meta name="language" content="en" />
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<title>DownloadHours.com - Free Software</title>
    <link rel="alternate" type="application/rss+xml" title="downloadhours.com rss feed" href="rss.xml" />
	<script src="js/jquery.tools.min.js" language="javascript"></script>
	<style type="text/css">
	<!--
	@import url("css/styles.css");
	-->
	</style>
</head>
<body>
<div id="container">
<div id="header">
<div class="clear">
	<a href="<?php echo DOMAIN;?>index.html" id="homeLink" title="Downloadhours.com home page">&nbsp;</a>
</div>
<ul id="menu">
    <li class="selected"><a href="<?php echo DOMAIN;?>index.html" title="Downloadhours.com home page"><span>Home</span></a></li>
    <li><a href="<?php echo DOMAIN;?>software/" title="Download software"><span>Software</span></a></li>
    <li><a href="<?php echo DOMAIN;?>software/games/" title="Games"><span>Games</span></a></li>
    <li><a href="<?php echo DOMAIN;?>wallpaper/" title="Wallpaper from downloadhours.com"><span>Wallpaper</span></a></li>
    <li><a href="#" title="Downloadhours.com driver"><span>Drivers</span></a></li>
    <li><a href="<?php echo DOMAIN;?>news/" title="Downloadhours.com news"><span>News</span></a></li>
    <!--li><a href="<?php echo DOMAIN;?>contact_us.html" title="Contact us at downloadhours.com"><span>Contact</span></a></li>
    <li><a href="<?php echo DOMAIN;?>links.html" title="Downloadhours.com links"><span>Links</span></a></li>
    <li><a href="<?php echo DOMAIN;?>advertising.html" title="Advertise on downloadhours.com"><span>Advertising</span></a></li-->
	<?php if($_SESSION['account_user']['account_type'] == 4){ ?>
	<li><a href="<?php echo DOMAIN;?>publisher.html" title="software publisher\developer."><span>Publisher</span></a></li>  
	<?php } ?>
</ul>
<div id="subMenu">
    <ul>
     <?php 
	 	if(!empty($category))
		{
			foreach($category as $row)
			{
    ?>
         	<li><a href="<?php echo DOMAIN;?>software/<?php echo $row['ceo_url_category']; ?>/"><?php echo $row['category'];?></a></li>
    <?php
			}
        }
    ?>
    </ul>
</div>
</div>
<div id="top_bar">
<div id="newsBox">
    <h3>News</h3>
    <ul>
    <?php
	 	if(!empty($newsCategory))
		{
			foreach($newsCategory as $row)
			{
    ?>
         	<li><a href="<?php echo DOMAIN;?>news/<?php echo $row['cat_url_title']; ?>/"><?php echo $row['cat_name'];?></a></li>
    <?php
			}
        }
    ?>
    </ul>
</div>
<ul id="topBar">
	<li>
    	<div class="grayBox">
        	<div>
            	<span style="width:245px;">
                    <form name="login" method="post" action="<?php echo DOMAIN;?>secure/login.html">
                    <p><?php echo $userName;?></p>
                    <?php if(empty($_SESSION['account_user']['account_type'])){ ?>
                        <p><input class="tb" type="text" name="username" /><input type="image" src="<?php echo DOMAIN;?>images/btn_login.png" id="btnLogin" /></p>
                        <p><input class="tb" type="password" name="password" /> <a href="registration.html#rempass">forget password</a></p>
                        Login Space for Publisher Developer only.
                    <?php } ?>
                    </form>
            	</span>
            </div>
        </div>
    </li>
    <li>
        <div class="grayBox grayBoxSearch">
        	<div>
            	<span>
                	<form name="search" method="post" action="<?php echo DOMAIN;?>search.php">
                	<p align="center">Welcome to download hours</p>
                    <p>Search:</p>
                    <p>
                    <input class="tb" type="text" name="search_text"  />
                    <select class="tb" name="search_cat">
                        <option value="">Select Category</option>
                        <?php
                            if(!empty($category))
                            {
                                foreach($category as $row)
                                {
                        ?>
                                <option value="<?php echo $row['ceo_url_category'];?>"><?php echo $row['category'];?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                    <input type="image" id="btnGo" src="<?php echo DOMAIN;?>images/btn_go.png" />
                    </p>
                    <a href="<?php echo DOMAIN;?>advance_search.php">Advance Search</a>
                    </form>
                </span>
            </div>
        </div>
    </li>
</ul>
<div class="clear clearTopBar"></div>
<div id="addTo">
	<p><a class="a2a_dd" href="http://www.addtoany.com/share_save?linkname=Downloadhours&amp;linkurl=http%3A%2F%2Fdownloadhours.com%2F"><img src="http://static.addtoany.com/buttons/share_save_171_16.gif" width="171" height="16" border="0" alt="Share/Save/Bookmark"/></a></p>
    <p><a class="a2a_dd" href="http://www.addtoany.com/subscribe?linkname=Downloadhours&amp;linkurl=http%3A%2F%2Fdownloadhours.com%2F"><img src="http://static.addtoany.com/buttons/subscribe_171_16.gif" width="171" height="16" border="0" alt="Subscribe"/></a></p>
</div>
<div id="leaderboard"><?php echo stripcslashes($leaderboard[0]['banner_code']);?></div>
<div id="newsLetter">
<div title="Newsletter delievers the Hottest Downloads right to your Inbox! Sign up Now!">
	<form name="newsLetter" method="post" action="">
	<p><?php echo $newsLetterMsg;?>&nbsp;</p>
	<input type="text" name="news_letter_email" />
    <p><img id="btnSub" src="images/btn_sub.png" onclick="document.newsLetter.submit();"/></p>
	</form>
</div>
<ul>
    <li><a href="privacy_policy.html">Privacy Policy</a> |</li>
    <!--li><a href="news_Archive">Archive</a> |</li-->
    <li><a href="rss.xml"><img src="images/rss.jpg" /></a></li>
</ul>
</div>
<div id="feature">
	<h2>Featured App</h2>
	<div class="scrollable">
		<div style="left:600px;" class="items">
			<?php foreach($featuredSoftware as $row){ ?>
			<div>
				<h3><a href="<?php echo DOMAIN;?>software/<?php echo $row['ceo_url_category']; ?>/<?php echo $row['url_title']; ?>.html"><?php echo $row['title']; ?></a></h3>
				<a href="software/<?php echo $row['ceo_url_category']; ?>/">- <?php echo $row['category']; ?> -</a>
				<p><?php echo cleanString($row['title_summary'], 370); ?></p>
				<h4><a href="<?php echo $row['app_buy_url']; ?>" target="_blank" title="Buy now!!!">$<?php echo number_format($row['app_price'], 2, ".", ",");?></a></h4>	
			</div>
			<?php } ?>
		</div>
	</div>
	<a href="software/" id="viewAllLink" title="View software listing">View all applications</a>
</div>
<div id="adsPanel"><div id="medRectangle"><?php echo stripcslashes($medRectangle[0]['banner_code']);?></div></div>
<div class="clear"></div>
</div>

<div id="content">
	<div id="homeAds">
        <ul>
            <?php
				if(!empty($tinyAds))
				{ 
					foreach($tinyAds as $row)
					{ 
			?>
			<li><div><?php echo stripcslashes($row['banner_code']);?></div></li>
        	<?php 
					}
				}else{ echo "<li>&nbsp;</li>"; } 
			?>
		</ul>
    </div>
    <div id="midCol">
    	<h2>Site Categories</h2>
        <div><a><img src="images/arrow_2.png" /></a></div>
        <?php
        	foreach($category as $row)
			{
		?>
        		<span>
                	<a href="software/<?php echo $row['ceo_url_category']; ?>/"><?php echo $row['category'];?></a>
                    <?php 
						$obj->printSubCategories($row['ceo_url_category']); 
					?>
                </span>
        <?php
			}
			if(!empty($latestReviews))
			{
		?>
        <div class="clear"></div>
        <h2>User's Review</h2>
        <div><a><img src="images/arrow_2.png" /></a></div>
		<?php
				foreach($latestReviews as $row)
				{
		?>
				<div class="reviews">
					<h5><a href="software/<?php echo $row['ceo_url_category'];?>/<?php echo $row['ceo_url_name'];?>.html" class="category"><?php echo cleanString($row['product']);?></a></h5>
					<p><?php echo cleanString($row['comment']);?></p>
					<small><?php echo cleanString($row['name']);?> - <i><?php echo date("l, F d. Y", strtotime($row['date_added']));?></i></small>
				</div>
		<?php
				}
			}
		?>
    </div>
    <div id="softWareList">
        <div class="bg">
        	<h2>Latest Software</h2>
            <div><a><img src="images/arrow_2.png" /></a></div>
            <?php
				$count = count($latestSoftware);
            	for( $i=0; $i<$count; $i++ )
				{
			?>
            		<div class="app">
                    <p><a href="software/<?php echo $latestSoftware[$i]['ceo_url_category']; ?>/" class="category"><?php echo $latestSoftware[$i]['category'];?></a> - <a href="<?php echo DOMAIN;?>software/<?php echo $latestSoftware[$i]['ceo_url_category']; ?>/<?php echo $latestSoftware[$i]['url_title']; ?>.html"><?php echo $latestSoftware[$i]['title'];?></a></p>
                    <p><span><a href="<?php echo DOMAIN;?>download.php?file=<?php echo base64_encode(cleanString($latestSoftware[$i]['app_download']));?>&id=<?php echo $latestSoftware[$i]['id'];?>" title="download <?php echo strtolower($latestSoftware[$i]['title']);?>" target="_blank" ><?php echo $latestSoftware[$i]['app_filesize'];?> MB</a> | <a href="<?php echo $latestSoftware[$i]['app_buy_url']; ?>" target="_blank" title="Buy now!!!">USD $<?php echo number_format($latestSoftware[$i]['app_price'], 2, ".", ",");?></a></span></p>
                    <p><?php echo cleanText($latestSoftware[$i]['app_summary'], 100);?></p>
                    </div>
            <?php
				}
			?>
        </div>
    </div>
	<div class="clear"></div>
</div>

<div id="footer">
<div class="leaderboard"><div><?php echo stripcslashes($leaderboard[1]['banner_code']);?></div></div>
<p>
    <a href="http://www.fileplaza.com" >Free Downloads Software </a>
    |
    <a title="Free Software Download" href="http://www.downloadatoz.com" >Free Software Download
    </a>| <a href="http://www.iccellphone.com" >
    Cheap Cell Phone Plan</a> |
    <a href="http://messenger.softros.com" >
    Corporate instant LAN messenger</a> |
    <a href="http://www.cstrikemovies.com" >Counter 
    Strike Movies</a><br />
    <a href="http://www.iflexion.com/services/database_development.php" >
    Web database development</a> |
    <a href="http://www.effectivesoft.com" >
    Custom software development</a> |
    <a href="http://www.incentaclick.com" >
    Affiliate Programs</a> |
    <a href="http://www.allwebhostingresources.com" >
    Asp Hosting</a> |
    <a href="http://www.itransition.com" >Offshore Software Development</a><br />
	<a href="<?php echo DOMAIN;?>contact_us.html" title="Contact us at downloadhours.com">Contact</a> |
	<a href="<?php echo DOMAIN;?>links.html" title="Downloadhours.com links">Links</a> |
	<a href="<?php echo DOMAIN;?>advertising.html" title="Advertise on downloadhours.com">Advertising</a> |
    <a href="privacy_policy.html">Privacy Policy</a> | <a href="terms_and_conditions.html">Terms And Conditions</a> |
	<a href="<?php echo DOMAIN;?>sitemap.html">HTML Sitemap</a> | <a href="<?php echo DOMAIN;?>sitemap.xml">XML Sitemap</a>
</p>
<p>Copyright <?php echo date("Y");?> DownloadHours.com All rights reserved</p>
</div>

</div>
<script>
$(function(){
	$("div.scrollable").scrollable({size:1}).circular().autoscroll(5000);
});
</script>
<script type="text/javascript">a2a_linkname="Downloadhours";a2a_linkurl="http://downloadhours.com/";a2a_onclick=1;a2a_show_title=1;a2a_hide_embeds=0;a2a_color_main="D7E5ED";a2a_color_border="AECADB";a2a_color_link_text="333333";a2a_color_link_text_hover="333333";</script>
<script type="text/javascript" src="http://static.addtoany.com/menu/page.js"></script>
<script type="text/javascript">a2a_linkname="Downloadhours";a2a_linkurl="http://downloadhours.com/";a2a_onclick=1;a2a_show_title=1;a2a_hide_embeds=0;a2a_num_services=20;</script>
<script type="text/javascript" src="http://static.addtoany.com/menu/feed.js"></script>
</body>
</html>