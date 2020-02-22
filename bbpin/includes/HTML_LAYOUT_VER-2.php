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
<link rel="stylesheet" media="all" href="styles/layout2.0.css">
<script type="text/javascript" src="js/global.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-5039d3134bebc572"></script>
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
        	<h4><?php echo utf8_encode($locale['warn.mes']);?></h4>
			<?php echo $warnings; ?>
        </div>
    </div>
    <?php } ?>
    <div id="header">
    	<div class="section">
        	<span>
           		<?php if(isset($_SESSION['BBPINWORLD'])){?>
				<?php echo utf8_encode($locale['hello']);?> <?php echo $_SESSION['BBPINWORLD']['fname'];?>! <a href="<?php echo DOMAIN;?>change-password.html"><?php echo utf8_encode($locale['change.password']);?></a>, <a href="logout.php"><?php echo utf8_encode($locale['logout']);?></a>
            	<?php }else{ echo "<a href='login.php'>{$locale['signin']}</a>";} ?>
            </span>
        	<a href="<?php echo DOMAIN;?>index.php" id="logo" title="<?php echo $locale['goto.home'];?>"><?php echo SITE_NAME;?></a>
            <?php if(isset($_SESSION['BBPINWORLD'])){?>
            <ul>                
                <li class="<?php echo ($_GET['action']=="" || $_GET['action']=="home")? 'selected' : '' ;?>"><a title="<?php echo $locale['goto.home'];?>" href="<?php echo DOMAIN;?>index.php"><?php echo utf8_encode($locale['menu.home']);?></a></li>
                <li class="<?php echo ($_GET['action']=="find-blackberry-messenger-pins" || $_GET['action']=="search")? 'selected' : '' ;?>"><a title="<?php echo strtolower($locale['find.pins']);?>" href="<?php echo DOMAIN;?>find-blackberry-messenger-pins.html"><?php echo utf8_encode($locale['menu.find.people']);?></a></li>
                <li class="<?php echo ($_GET['action']=="find-blackberry-messenger-groups" || $_GET['action']=="bbm-chat-groups" || $_GET['action']=="group")? 'selected' : '' ;?>"><a title="<?php echo strtolower($locale['find.group']);?>" href="<?php echo DOMAIN;?>find-blackberry-messenger-groups.html"><?php echo utf8_encode($locale['menu.find.groups']);?></a></li>
                <li class="<?php echo ($_GET['action']=="messages" || $_GET['action']=="message" )? 'selected' : '' ;?>"><a title="<?php echo strtolower($locale['menu.messages']);?>" href="<?php echo DOMAIN;?>messages.html" class="<?php echo (isset($_SESSION['BBPINWORLD']['newMessage']) && $_SESSION['BBPINWORLD']['newMessage']=='yes')? 'highlight' : '' ;?>" ><?php echo utf8_encode($locale['menu.messages']);?></a></li>
                <li class="<?php echo ($_GET['action']=="blackberry-messenger-pin-request")? 'selected' : '' ;?>"><a title="<?php echo strtolower($locale['menu.pin.request']);?>" href="<?php echo DOMAIN;?>blackberry-messenger-pin-request.html"><?php echo utf8_encode($locale['menu.pin.request']);?></a></li>
                <li class="<?php echo ($_GET['action']=="profile" || $_GET['action']=="edit-profile" || $_GET['action']=="edit-my-gallery" || $_GET['action']=="profile-photo")? 'selected' : '' ;?>"><a title="<?php echo strtolower($locale['menu.my.profile']);?>" href="<?php echo DOMAIN;?>profile.html"><?php echo utf8_encode($locale['menu.my.profile']);?></a></li>
            </ul>
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
            	<li class="lt">
                    <h3>About Jusbbmpins.com</h3>                     
                    <p>Looking for BlackBerry Messenger PINs then you’re in the right place.</p> 
                    <p><b>JusBBMpins.com</b> (The Blackberry PIN Yellow Page) is for anyone who is looking to share/exchange BlackBerry Messenger PINs.</p>
                    <p>Find new friends, (BBM) chat groups that share your common and similar interest...<a title="read more about jusbbmpins.com" href="<?php echo DOMAIN;?>about-us.htm"><b>read more&raquo;</b></a></p>           	
                </li>
                <li class="ctr">
					<h3>Page Links</h3>
                    <ol>
                        <li><a href="<?php echo DOMAIN;?>about-us.htm"><?php echo utf8_encode($locale['about']);?></a></li>
                        <li><a href="<?php echo DOMAIN;?>faqs.htm"><?php echo utf8_encode($locale['faqs']);?></a></li>
                        <li><a href="<?php echo DOMAIN;?>privacy-policy.htm"><?php echo utf8_encode($locale['privacy']);?></a></li>
                        <li><a href="<?php echo DOMAIN;?>terms.htm"><?php echo utf8_encode($locale['terms']);?></a></li>
                        <li><a href="<?php echo DOMAIN;?>contact-us.htm"><?php echo utf8_encode($locale['contact']);?></a></li>
                    </ol>              	
                </li>
                <li class="rt">
                	<h3>Stay Connected</h3>
                    <ol>
                    	<li><a class="fb" title="follow us jusbbmpins on facebook.com" href="http://www.facebook.com/jusbbmpins" target="_blank">Facebook.com</a></li>
                        <li><a class="tw" title="follow us jusbbmpins on twitter.com" href="https://twitter.com/jusbbmpins" target="_blank">Twitter.com</a></li>
                        <li><a class="rs" title="jusbbmpins xml rss feed" href="rssfeed.php" target="_blank">Rss Feed</a></li>
                        <li><a class="tw" title="follow me the web developer on twitter.com" href="https://twitter.com/rohanmorris" target="_blank">Follow Me!</a></li>
                    </ol>
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
    <div id="feedback">
    	<div class="section">
        	<form name="fbfrm" id="fbfrm" method="post" action="">
                <div>
                    <b>Website feedback for this page</b>
                    <span>
                        <p>Send us your ideas, requests or comments about jusbbmpins.com</p>
                        <p>Your feedback will be used it to improve the website experience. Please provide the details about your suggestion below.</p>
                        <p><b>Note:</b> do not provide any personal information such as names, phone numbers, or email as we are unable to reply to this form.</p>
                    </span>
                    <p>
                        <select name="fb_subject" id="fb_subject" class="textbox">
                            <option value="">Please select feedback option</option>
                            <option value="Page recommendation">Page recommendation</option>
                            <option value="Page compliment">Page compliment</option>
                            <option value="Missing or incorrect information">Missing or incorrect information</option>
                            <option value="Page error - report a bug">Page error - report a bug</option>
                            <option value="Didn't find what I was looking for">Didn't find what I was looking for</option>
                        </select>
                    </p>
                    <p><textarea name="fb_comment" id="fb_comment"></textarea></p>
                </div>
                <div>
                	<ul>
                       <li><b style="padding:4px; display:block;">Optional rating below:</b></li>
                       <li>
                            <label>Content</label>
                            <input type="radio" name="content" value="0" id="c0" /><label for="c0" class="nostyle">0</label>
                            <input type="radio" name="content" value="1" id="c1" /><label for="c1" class="nostyle">1</label>
                            <input type="radio" name="content" value="2" id="c2" /><label for="c2" class="nostyle">2</label>
                            <input type="radio" name="content" value="3" id="c3" /><label for="c3" class="nostyle">3</label>
                            <input type="radio" name="content" value="4" id="c4" /><label for="c4" class="nostyle">4</label>
                        </li>
                        <li>
                            <label>Design</label>
                            <input type="radio" name="design" value="0" id="d0" /><label for="d0" class="nostyle">0</label>
                            <input type="radio" name="design" value="1" id="d1" /><label for="d1" class="nostyle">1</label>
                            <input type="radio" name="design" value="2" id="d2" /><label for="d2" class="nostyle">2</label>
                            <input type="radio" name="design" value="3" id="d3" /><label for="d3" class="nostyle">3</label>
                            <input type="radio" name="design" value="4" id="d4" /><label for="d4" class="nostyle">4</label>
                        </li>
                        <li>
                            <label>Easy of use</label>
                            <input type="radio" name="easy-of-use" value="0" id="e0" /><label for="e0" class="nostyle">0</label>
                            <input type="radio" name="easy-of-use" value="1" id="e1" /><label for="e1" class="nostyle">1</label>
                            <input type="radio" name="easy-of-use" value="2" id="e2" /><label for="e2" class="nostyle">2</label>
                            <input type="radio" name="easy-of-use" value="3" id="e3" /><label for="e3" class="nostyle">3</label>
                            <input type="radio" name="easy-of-use" value="4" id="e4" /><label for="e4" class="nostyle">4</label>
                        </li>
                    </ul>
                </div>
                <p align="right"><input type="button" value="Send feedback" id="fb_btn" class="button"/></p>
            </form>
            <br>
    	</div>
    </div>
    <div id="copyright">
        <div class="section"> 
        	<?php echo SITE_NAME;?> &copy; <?php echo date('Y');?>      
            <span class="right">Powered by: Iceman's Blackberry Storm 2</span><br>
            <a class="btnfb"><?php echo utf8_encode($locale['feedback']);?></a>   	         
        </div>
    </div>
</div>
<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_floating_style addthis_counter_style" style="left:30px;top:80px;">
<a class="addthis_button_facebook_like" fb:like:layout="box_count"></a>
<a class="addthis_button_tweet" tw:count="vertical"></a>
<a class="addthis_button_google_plusone" g:plusone:size="tall"></a>
<a class="addthis_counter"></a>
</div>
<!-- AddThis Button END -->    
</body>
</html>
<script language="javascript">
$(function() {	
	$('.btnfb').click(function(){
		$("#feedback").slideToggle('2000', "linear", function () {
			$('html,body').animate({scrollTop:$("#feedback").offset().top},800);
		})
    });
});
$('#fb_btn').bind('click', function(){
	var txt = $('#fb_comment').val();
	var sbj = $('#fb_subject').val();
	var con = $('input[name=content]:checked').val();
	var des = $('input[name=design]:checked').val();
	var eou = $('input[name=easy-of-use]:checked').val();
		
	if(isEmpty(sbj)){
		alert("Please select feedback option from the list.");
		$('#fb_subject').focus();
		//$('#fb_subject').css('border','solid 2px #c00');
		return false;
	}
	if(isEmpty(txt)){
		//$('#fb_comment').css('border','solid 2px #c00');
		alert("Feedback comment required.");
		$('#fb_comment').focus();
		return false;
	}
	//$('#ldr').css('visibility','visible'); 
	$('#fb_btn').attr('disabled',true);
	$.get("includes/ajx_fb.php",{t:txt,s:sbj,c:con,d:des,e:eou,u:'<?php echo base64_encode(str_replace('//','/',DOMAIN.$_SERVER['REQUEST_URI']));?>'},
		function(data){
			//$('#comments').prepend(data);
			$('#fb_comment').val('');
			$('#fb_subject').val('');
			$('#fb_btn').attr('disabled',false);
			//$('#ldr').css('visibility','hidden');
			alert(data);
			$("#feedback").slideToggle('2000', "linear", function () {})		
		}
	);
});
</script>
<!-- 
To my beloved rose [@}~%~~~] missing you like crazy,
love you always xoxo wether your near or far, beside me or not 2013/05/11 
-->
