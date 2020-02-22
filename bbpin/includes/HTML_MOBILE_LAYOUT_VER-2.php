<!DOCTYPE HTML>
<html dir="<?php echo $locale['lang.dir'];?>" lang="<?php echo $locale['php.locale'];?>"> 
<head>
<meta http-equiv="Content-Type" content="text/html;charset=<?php echo $locale['content.type'];?>" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>
<meta name="language" content="<?php echo $locale['lang'];?>" />
<title><?php echo $pageTitle;?></title>
<meta name="title" content="<?php echo $pageTitle;?>">
<meta name="description" content="<?php echo $pageDesc;?>">
<meta name="keywords" content="<?php echo $pageKeyWords;?>">
<meta property="og:title" content="<?php echo $pageTitle;?>"/>
<meta property="og:url" content="<?php echo str_replace('//','/',DOMAIN.$_SERVER['REQUEST_URI']);?>"/>
<meta property="og:image" content="<?php echo DOMAIN;?>images/mini-promo.jpg"/>
<meta property="og:site_name" content="<?php echo SITE_NAME;?>"/>
<meta property="og:description" content="<?php echo $pageDesc;?>"/>
<link rel="icon" type="image/png" href="images/bbm_icon.png" />
<link rel="stylesheet" media="all" href="../styles/mobile_layout2.0.css">
<script type="text/javascript" src="../js/global.js"></script>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-31035193-4']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
</head>
<body>
<div id="container">
	<?php if(!empty($warnings)){ ?>
	<div id="notice">
    	<div class="section">
        	<h4><?php echo $locale['warn.mes'];?></h4>
			<?php echo $warnings; ?>
        </div>
    </div>
    <?php } ?>
    <div id="header">
    	<div class="section">
            <a href="<?php echo DOMAIN;?>m/index.php" id="logo" title="<?php echo $locale['goto.home'];?>"><?php echo SITE_NAME;?></a>        	
            <?php if(isset($_SESSION['BBPINWORLD'])){?>
            <font>Menu
                <ul class="nav">                
                    <li class="<?php echo ($_GET['action']=="" || $_GET['action']=="home")? 'selected' : '' ;?>"><a title="<?php echo $locale['goto.home'];?>" href="<?php echo DOMAIN;?>m/index.php"><?php echo $locale['menu.home'];?></a></li>
                    <li class="<?php echo ($_GET['action']=="find-blackberry-messenger-pins" || $_GET['action']=="search")? 'selected' : '' ;?>"><a title="<?php echo strtolower($locale['find.pins']);?>" href="<?php echo DOMAIN;?>m/find-blackberry-messenger-pins.html"><?php echo $locale['menu.find.people'];?></a></li>
                    <li class="<?php echo ($_GET['action']=="find-blackberry-messenger-groups")? 'selected' : '' ;?>"><a title="<?php echo strtolower($locale['find.group']);?>" href="<?php echo DOMAIN;?>m/find-blackberry-messenger-groups.html"><?php echo $locale['menu.find.groups'];?></a></li>
                    <li class="<?php echo ($_GET['action']=="messages" || $_GET['action']=="message" )? 'selected' : '' ;?>"><a title="<?php echo strtolower($locale['menu.messages']);?>" href="<?php echo DOMAIN;?>m/messages.html" class="<?php echo (isset($_SESSION['BBPINWORLD']['newMessage']) && $_SESSION['BBPINWORLD']['newMessage']=='yes')? 'highlight' : '' ;?>" ><?php echo $locale['menu.messages'];?></a></li>
                    <li class="<?php echo ($_GET['action']=="blackberry-messenger-pin-request")? 'selected' : '' ;?>"><a title="<?php echo strtolower($locale['menu.pin.request']);?>" href="<?php echo DOMAIN;?>m/blackberry-messenger-pin-request.html"><?php echo $locale['menu.pin.request'];?></a></li>
                    <li class="<?php echo ($_GET['action']=="m.profile" || $_GET['action']=="edit-profile" || $_GET['action']=="edit-my-gallery" || $_GET['action']=="profile-photo")? 'selected' : '' ;?>"><a title="<?php echo strtolower($locale['menu.my.profile']);?>" href="<?php echo DOMAIN;?>m/profile.html"><?php echo $locale['menu.my.profile'];?></a></li>
                </ul>
            </font>
            <br/>
            <?php }?>
        </div>
    </div>
    <div id="body">
    	<div class="section">
			<?php echo $pageContent; ?>
        </div>
        <hr style="clear:both;"/>
    </div>
    <div id="footer">
    	<div class="section">	
        	<ul>
            	<li>
                    <h3>About Jusbbmpins.com</h3>                     
                    <p>Looking for BlackBerry Messenger PINs then you’re in the right place.</p> 
                    <p><b>JusBBMpins.com</b> (The Blackberry PIN Yellow Page) is for anyone who is looking to share/exchange BlackBerry Messenger PINs.</p>
                    <p>Find new friends, (BBM) chat groups that share your common and similar interest...<a title="read more about jusbbmpins.com" href="<?php echo DOMAIN;?>m/about-us.htm"><b>read more&raquo;</b></a></p>           	
                </li>
                <li>
					<h3>Page Links</h3>
                    <ol>
                        <li><a href="<?php echo DOMAIN;?>m/about-us.htm"><?php echo $locale['about'];?></a></li>
                        <li><a href="<?php echo DOMAIN;?>m/faqs.htm"><?php echo $locale['faqs'];?></a></li>
                        <li><a href="<?php echo DOMAIN;?>m/privacy-policy.htm"><?php echo $locale['privacy'];?></a></li>
                        <li><a href="<?php echo DOMAIN;?>m/terms.htm"><?php echo $locale['terms'];?></a></li>
                        <li><a href="<?php echo DOMAIN;?>m/contact-us.htm"><?php echo $locale['contact'];?></a></li>
                    </ol>              	
                </li>
                <li>
                	<h3>Stay Connected</h3>
                    <ol>
                    	<li><a class="fb" title="follow us jusbbmpins on facebook.com" href="http://www.facebook.com/jusbbmpins" target="_blank">Facebook.com</a></li>
                        <li><a class="tw" title="follow us jusbbmpins on twitter.com" href="https://twitter.com/jusbbmpins" target="_blank">Twitter.com</a></li>
                        <li><a class="rs" title="jusbbmpins xml rss feed" href="rssfeed.php" target="_blank">Rss Feed</a></li>
                        <li><a class="tw" title="follow me the web developer on twitter.com" href="https://twitter.com/rohanmorris" target="_blank">Follow Me!</a></li>
                        <li>&nbsp;</li>
                    </ol>                           
                </li>
                <li>
                	<h3>Website langages</h3>
					<ol>
                    	<li><a class="en" title="view website in english" href="javaScript:setLang('en');">English</a></li>
                        <li><a class="es" title="view website in spanish" href="javaScript:setLang('es');">Spanish</a></li>
                        <li><a class="fr" title="view website in french" href="javaScript:setLang('fr');">French</a></li>
                    </ol> 
                </li>
                <br>
            </ul>
        </div>
    </div>
    <div id="copyright">
        <div class="section"> 
			<?php if(isset($_SESSION['BBPINWORLD'])){?>
            <?php echo $locale['hello'];?> <?php echo $_SESSION['BBPINWORLD']['fname'];?>! <a href="<?php echo DOMAIN;?>m/change-password.html"><?php echo $locale['change.password'];?></a>, <a href="logout.php"><?php echo $locale['logout'];?></a>
            <?php }else{ echo "<a href='../login.php'>{$locale['signin']}</a>";} ?>
			<br/>
        	<?php echo SITE_NAME;?> &copy; <?php echo date('Y');?>      
            <p>Powered by: Iceman's Blackberry Storm 2</p>  	         
        </div>
    </div>
</div>    
</body>
</html>
<!-- 
Moblie version.
15/05/2013
-->
