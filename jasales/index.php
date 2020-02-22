<?php
include_once("config/config.php");
//include_once("classes/mySQlDB__.class.php");
//include_once("classes/site.class.php");
//$obj = new site();
//@$page = (file_exists('includes/'.$_GET['action'].'.php') )? $_GET['action'].'.php' : 'home.php';
?>
<!DOCTYPE HTML>
<html dir="<?php echo $locale['lang.dir'];?>" lang="<?php echo $locale['php.locale'];?>"> 
<meta name="language" content="<?php echo $locale['lang'];?>" />
<head>
<meta http-equiv="Content-Type" content="text/html;charset=<?php echo $locale['content.type'];?>" />
<title><?php echo $locale['site.name'];?></title>
<link href="css/layout.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.tools.min.js"></script>
<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=xa-50af1adc041c97c3"></script>
</head>

<body>
    <div id="container">
    	<div id="header">
            <span id="topspan">
                <div id="memlinks">
                	<a href="#">create a business account</a> <a style="color:#000;">&bull;</a> <a href="#">company login</a>
                </div>
                <form class="frmsyle" id="frmsearch" name="frmsearch" method="post" action="" >
                    <input type="submit" id="btnsearch" title="" value="" />
                    <input type="text" name="s" id="s" autocomplete="off" maxlength="100" value="" />
                    <div></div>
                </form>
                <script>
                    $('#s').click(function(){setDefSerText();});
                    $('#s').blur(function(){ window.setTimeout("$('#s').val('');$('#frmsearch div').html('');defText();",250);});
                    var defText = function(){$('#s').val('Search for company or promotions').css('font-size','0.75em').css('color','#666');}
                    var setDefSerText = function(){$('#s').val('').css('font-size','0.8em').css('color','#000');}
                    defText();
                </script>
            </span>
            <a id="logo" href="index.php" title="goto home"><?php echo $locale['site.name'];?></a>
            <br><hr />
        	<div id="leaderboard">
            	<script type="text/javascript"><!--
				google_ad_client = "ca-pub-9222115009045453";
				/* leaderboard_image */
				google_ad_slot = "6203768677";
				google_ad_width = 728;
				google_ad_height = 90;
				//-->
				</script>
				<script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>
            </div>
      	</div>
        <hr/>  
        <ul class="rax-tabstrip bluetab">
            <li class="selected-tab"><a href="#">Home</a></li>
            <li><a href="#">Events</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Contact Us</a></li>
            <li><a href="#">Reviews</a></li>
        </ul>   
        <br>    	
		<div id="topmenu"><a class="morecomp" id="morecomp" href="#" title="show more companies"></a>   
            <ul>
            	<li><a href="#">Company 1</a></li>
                <li><a href="#">Company 2</a></li>
                <li><a href="#">Company 3</a></li>
                <li><a href="#">Company 4</a></li>
                <li><a href="#">Company 5</a></li>
                <li><a href="#">Company6</a></li>
                <li><a href="#">Company7</a></li>
                <li><a href="#">Company8</a></li>
                <li><a href="#">Company 9</a></li>
            </ul>       
            <br>
            <div id="popup" style="display:none;">
                <ul>
                    <li><a href="#">More Company 1</a></li>
                    <li><a href="#">More Company 2</a></li>
                    <li><a href="#">More Company 3</a></li>
                    <li><a href="#">More Company 4</a></li>
                    <li><a href="#">More Company 5</a></li>
                    <li><a href="#">More Company 1</a></li>
                    <li><a href="#">More Company 2</a></li>
                    <li><a href="#">More Company 3</a></li>
                    <li><a href="#">More Company 4</a></li>
                </ul>
            </div>
        </div>
        <div id="rightcol">
            <!-- AddThis Follow BEGIN -->
            <p>Follow</p>
            <div class="addthis_toolbox addthis_32x32_style addthis_default_style" style="margin-bottom:5px;">
            <a class="addthis_button_facebook_follow" addthis:userid="YOUR-PROFILE"></a>
            <a class="addthis_button_twitter_follow" addthis:userid="YOUR-USERNAME"></a>
            <a class="addthis_button_google_follow" addthis:userid="yyy"></a>
            <a class="addthis_button_rss_follow" addthis:userid="index.php"></a>
            </div>
            <!-- AddThis Follow END -->
        	<script type="text/javascript"><!--
			google_ad_client = "ca-pub-9222115009045453";
			/* 200x200_text_image */
			google_ad_slot = "3655167530";
			google_ad_width = 200;
			google_ad_height = 200;
			//-->
			</script>
			<script type="text/javascript"
			src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
			</script>
            <div class="scrollable">
                <ol class="items">
                    <li>
                        <h3>Neque porro quisquam est</h3>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                        <hr/>
                    </li>
                    <li>
                        <h3>Where does it come from?</h3>
                        Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.
                        <hr/>
                    </li>
                    <li>
                        <h3>Sample test heading to test header wraping</h3>
                        There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour
                        <hr/>
                    </li>
                    <li>
                        <h3>More text!!!</h3>
                        The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum".
                        <hr/>
                    </li>
                    <li>
                        <h3>Sample test heading to test header wraping</h3>
                        There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour
                        <hr/>
                    </li>
                    <li>
                        <h3>More text!!!</h3>
                        The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum".
                        <hr/>
                    </li>
                </ol>
            </div>
        </div>
        <div>
        	<div id="sideMenu">
                <ul>
                    <li><a href="#">Shoes</a></li>
                    <li><a href="#">Clothing & Jewelry</a></li>
                    <li><a href="#">Toys</a></li>
                    <li><a href="#">Clothing</a></li>
                    <li><a href="#">Appliances</a></li>
                    <li><a href="#">Automotive</a></li>
                    <li><a href="#">Books</a></li>
                    <li><a href="#">Computer</a></li>
                    <li><a href="#">Electronics</a></li>
                    <li><a href="#">Hardware</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Home and Garden</a></li>
                </ul>
            </div>
            <div id="content">
            	<a href="#" class="promo1"></a>
                <a href="#" class="promo2"></a>
                <a href="#" class="promo2"></a>
                <a href="#" class="promo1"></a>
                <a href="#" class="promo1"></a>
            </div>
        </div>
        <hr style="margin:0; visibility:hidden;"/>
        <hr/>
        <div id="footer">
		    <form class="frmsyle" id="frmnewsletter" name="frmnewsletter" method="post" action="" >
                <input type="submit" id="btnnewsletter" title="" value="" />
                <input type="text" name="s2" id="s2" autocomplete="off" maxlength="100" value="" />
            </form>
			<!-- AddThis Button BEGIN -->
			<div class="addthis_toolbox addthis_default_style ">
			<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
			<a class="addthis_button_tweet"></a>
			<a class="addthis_button_pinterest_pinit"></a>
			<a class="addthis_counter addthis_pill_style"></a>
			</div>
			<!-- AddThis Button END -->

            <div style="margin-bottom:10px;"></div>
            <a href="#"><?php echo $locale['about'];?></a> &bull;
            <a href="#"><?php echo $locale['faqs'];?></a> &bull;
            <a href="#"><?php echo $locale['privacy'];?></a> &bull;
            <a href="#"><?php echo $locale['terms'];?></a> &bull;
            <a href="#"><?php echo $locale['feedback'];?></a> &bull;
            <a href="#"><?php echo $locale['contact'];?></a> &bull;
            <a href="http://www.twitter.com/rohanmorris" title="Thanks to Iceman of the fire clan Follow on twitter" target="_blank"><?php echo $locale['credit'];?></a>
            <br><?php echo $locale['site.name'];?> &copy; <?php echo date('Y');?>
        </div>
    </div>
<script language="javascript">
$(document).ready(function() {
	$("#morecomp").toggle(
		function(){
			$("#popup").show("slow"); 
			$("#morecomp").css("background-image","url(images/popin.png)");
			$("#morecomp").attr("title","close window");
		},
		function(){
			$("#popup").hide("slow"); 
			$("#morecomp").css("background-image","url(images/popout.png)");
			$("#morecomp").attr("title","show more companies");
		}
	);
});

$('#s2').click(function(){setNewLetterDefSerText();});
$('#s2').blur(function(){ window.setTimeout("$('#s2').val('');$('#frmnewsletter div').html('');defNewLetterText();",250);});
var defNewLetterText = function(){$('#s2').val('Add your email to our newsletter listing').css('font-size','1.1em').css('color','#666');}
var setNewLetterDefSerText = function(){$('#s2').val('').css('font-size','1.1em').css('color','#000');}
defNewLetterText();

$(document).ready(function() {
	$("div.scrollable").scrollable({vertical:true,speed:1000}).circular().autoscroll(4000);
});
</script>
</body>
</html>