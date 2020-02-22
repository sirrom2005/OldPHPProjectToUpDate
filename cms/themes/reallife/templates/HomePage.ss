<!DOCTYPE html>
<html>
<head>
<% base_tag %>
<title>$Title</title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
$MetaTags
<% require themedCSS(styles) %> 
</head>

<body>
<div id="containerbody"> 
	<div id="myLogin">
    	<h3>Already a member?</h3>
        <p>
            <a href="login?action=register" rel="nofollow">Register</a> |
            <a href="login?action=lostpassword" rel="nofollow">Lost Password</a>
        </p>
    </div>
    <div id="menu">
	<ul>
		<% control Menu(1) %>
			<li><a href="$Link" title="$Title" >$MenuTitle</a></li>
		<% end_control %>
	<ul>
	</div>
    <div id="contentbody">
    	<div id="contentbg">
    	<div id="tl">
        	<h2 class="genre" title="genre">&nbsp;</h2>
            <div class="blkbox">
				<% include Sidemenu %>
			</div>
            <p>&nbsp;</p>
            <h2 class="mood" title="mood">&nbsp;</h2>
            <div class="blkbox">
				<ol>
				<% control Menu(2) %>
					<li><a href="$Link" title="$Title" >$MenuTitle</a></li>
				<% end_control %>
				</ol>
			</div>
        </div>
<!-- #HEADER -->        
<div id="container">
    <div id="content" role="main">
		<% if Level(2) %>
			$Breadcrumbs
			<hr>
		<% end_if %>
		<h3>$Title</h3>
		$Content
    </div>
	<!-- #content -->
</div>
<!-- #container -->

<!-- #FOOTER -->
        <div id="tr">
        	<h2 class="toprate" title="top rated">&nbsp;</h2>
            <div class="blkbox">
				<% include Sidemenu %>
			</div>
            <p>&nbsp;</p>
            <h2 class="popular" title="popular beats">&nbsp;</h2>
            <div class="blkbox">
				<% include Sidemenu %>
			</div>
            <p>&nbsp;</p>
            <h2 class="followus" title="follow us">&nbsp;</h2>
            <div class="blkbox socail_net">
            	<ul>
                	<li class="sn1"><a href="#"></a></li>
                    <li class="sn2"><a href="#"></a></li>
                    <li class="sn3"><a href="#"></a></li>
                    <li class="sn4"><a href="#"></a></li>
                </ul>
            </div>
        </div>
        <br />
        </div>
    </div>
    <div id="footer">
    	<div id="fl"><h2>Latest Design</h2></div>
        <div id="fc">
        	<h2>New Release</h2>
        	<div id="slider-wrapper">
                <div id="slider" class="nivoSlider">
                    <img width="100" src="themes/reallife/images/toystory.jpg" alt="" />
                    <img width="100" src="themes/reallife/images/up.jpg" alt="" title="This is an example of a caption" />
                    <img width="100" src="themes/reallife/images/walle.jpg" alt="" />
                    <img width="100" src="themes/reallife/images/nemo.jpg"  alt="" title="#htmlcaption" />
                </div>
                <div id="htmlcaption" class="nivo-html-caption">
                    <strong>This</strong> is an example of a <em>HTML</em> caption with <a href="#">a link</a>.
                </div>
            </div>
        </div>
        <div id="fr">
        	<h2 class="search" title="search for tee shirts">&nbsp;</h2>
            <div class="blkbox">fgfg</div>
        </div>
    </div>
    <div id="footer_links">
    	<a href="#" id="poweredby"></a>
    	<% include Footer %>
    </div>
</div>
<link rel="stylesheet" type="text/css" media="all" href="themes/reallife/css/nivo-slider.css" />
<script type="text/javascript" src="themes/reallife/js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="themes/reallife/js/jquery.nivo.slider.pack.js"></script>
<script type="text/javascript">
$(window).load(function() {
	$('#slider').nivoSlider();
});
</script>
</body>
</html>