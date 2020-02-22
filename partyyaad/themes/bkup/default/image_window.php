<?php
$album = $_GET['a'];
$image = $_GET['i'];
$imageurl = 'cache/'.$album.'/'.$image;
$ext = explode('.',$image);
$ext = strtoupper($ext[count($ext)-1]);
$fullImagePath = 'index.php?album='.urlencode($album).'&image='.substr(str_replace('_595', '', urlencode($image)), 0,-4).'.'.$ext.'#comment';
?>
<html>
<head>
<title>Untitled Document</title>
<style>
body{margin:0;padding:0;}
#contianer{ margin:0 auto; text-align:center;}
.righttext{float:right;}
.righttext a{color:#FFFFFF; padding-left:20px; text-decoration:none; text-transform:uppercase; font-size:12px; background:url(themes/default/images/notes.png) no-repeat;}
.righttext a:hover{color:#FF0000;}
img{ margin-bottom:3px;}
</style>
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div id="contianer">
    <img src="<?php echo $imageurl;?>" style="max-width:100%; height:90%;" /><br>
    <div style="width:100%; text-align:left;">
    <div class="righttext"><a target="_parent" href="<?php echo $fullImagePath;?>">add comment</a></div>
    <div class="fb-like" data-href="http://partyaad.com/index.php?album=<?php echo $album;?>&image=<?php echo str_replace('_595', '', $image);?>" data-send="true" data-layout="button_count" data-width="300" data-show-faces="true" data-font="arial"></div>
    </div>
</div>
</body>
</html>