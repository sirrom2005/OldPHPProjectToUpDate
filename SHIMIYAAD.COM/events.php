<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>WWW.FIMIYAAD.COM</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/lightbox.css" />
<!--[if lte IE 6]>
<link rel="stylesheet" type="text/css" href="assets/css/ie6.css" />
<script type="text/javascript" src="assets/js/unitpngfix.js"></script>
<![endif]-->
<script type="text/javascript" src="javascript.js"></script>
<script type="text/javascript" src="assets/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.cycle.all.min.js"></script>
<script type="text/javascript" src="assets/js/prototype.js"></script>
<script type="text/javascript" src="assets/js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="assets/js/lightbox.js"></script>
<style type="text/css">
<!--
body {
	background-color: #FFF;
}
#wrapper #body #content .single table tr td {
	text-align: center;
}
body,td,th {
	font-size: 12px;
	text-align: center;
	color: #000;
}
#Table_01 {text-align: center;
}
#wrapper p {
	color: #000;
}
-->

  

</style>

<script language="JavaScript">
var timerID=0;
var minInterval = .25;     //change this value to determine how ofter the banners should switch. Its currently set to 1 minute

var imgArray = new Array("banner1", "banner2", "banner3"); //list of banner images. NB. filename without extention

function setupAdbanner() {
	rotateBanner();
	timerID = setInterval("rotateBanner()", minInterval * 15000);
}

function cleanupPage() {
	if (timerID)
		clearInterval(timerID);
}

function rotateBanner() {
imgIndex = Math.ceil(Math.random() * imgArray.length) - 1;
document.getElementById("mainBanner").src= "images/banners/" + imgArray[imgIndex] + ".jpg";  //Assumes all banner images are in images/banners...change if necessary
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
</script>

</head>
  <!-- add the following onload and onunload events to your body tag -->
<body onload="setupAdbanner();"  onunload="cleanupPage()">

<!-- BEGIN wrapper  -->
<div id="wrapper">
  <p align="center"><img src="images/evehead2.jpg" width="960" height="100" align="absmiddle" /><img src="images/evehead.jpg" width="960" height="40" align="absmiddle" /></p>
  <p align="center"><img src="images/FIMI.png" width="919" height="504"  alt=""/></p>
  <p align="center"><a href="index.html" target="_self"><img src="images/home.jpg" width="240" height="300"  alt=""/></a><a href="pictures.html" target="_self"><img src="images/pictures.jpg" width="240" height="300"  alt=""/></a><a href="events.html" target="_self"><img src="images/events.jpg" width="240" height="300"  alt=""/></a></p>
  <p>&nbsp;</p>
  <p align="center">

  </p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
<p></p>
<p></p>
  <div id="body">
    <div class="break"></div>
  </div>
  <!-- END body -->
</div>
<!-- END wrapper -->
<!-- BEGIN footer -->
<!-- END footer -->
<script type="text/JavaScript">var TFN='';var TFA='';var TFI='0';var TFL='0';var tf_RetServer="rt.trafficfacts.com";var tf_SiteId="4019g6393062069518266e20ab892e35a2cbb2fda8412h14";var tf_ScrServer=document.location.protocol+"//rt.trafficfacts.com/tf.php?k=4019g6393062069518266e20ab892e35a2cbb2fda8412h14;c=s;v=5";document.write(unescape('%3Cscript type="text/JavaScript" src="'+tf_ScrServer+'">%3C/script>'));</script><noscript><img src="http://rt.trafficfacts.com/ns.php?k=4019g6393062069518266e20ab892e35a2cbb2fda8412h14" height="1" width="1" alt=""/></noscript>
</body>
</html>
